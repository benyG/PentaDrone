<?php

include_once dirname(__FILE__) . '/../security/security_feedback.php';

class LoginControl {

    /** @var Page */
    private $page;
    /** @var AbstractUserAuthentication */
    private $userAuthentication;
    /** @var UserIdentityStorage */
    private $userIdentityStorage;
    /** @var ConnectionFactory */
    private $connectionFactory;
    /** @var string */
    private $urlToRedirectAfterLogin;
    /** @var string */
    private $errorMessage = '';
    /** @var boolean */
    private $lastSaveidentity = false;
    /** @var Captions */
    private $captions;

    /** @var null|string */
    private $securityFeedbackPositive = null;
    /** @var null|string */
    private $securityFeedbackNegative = null;

    /**
     * @param LoginPage $page
     * @param string $urlToRedirectAfterLogin
     * @param AbstractUserAuthentication $userAuthentication
     * @param ConnectionFactory $connectionFactory
     * @param Captions $captions
     */
    public function __construct(
        LoginPage $page,
        $urlToRedirectAfterLogin,
        AbstractUserAuthentication $userAuthentication,
        ConnectionFactory $connectionFactory,
        Captions $captions)
    {
        $this->page = $page;
        $this->connectionFactory = $connectionFactory;
        $this->userAuthentication = $userAuthentication;
        $this->urlToRedirectAfterLogin = $urlToRedirectAfterLogin;
        $this->captions = $captions;
        $this->userIdentityStorage = $this->userAuthentication->getIdentityStorage();
    }

    public function getPage()
    {
        return $this->page;
    }

    public function Accept(Renderer $renderer) {
        $renderer->RenderLoginControl($this);
    }

    public function GetErrorMessage() {
        return $this->errorMessage;
    }

    public function GetLastSaveidentity() {
        return $this->lastSaveidentity;
    }

    public function CanLoginAsGuest() {
        return $this->userAuthentication->getGuestAccessEnabled();
    }

    public function GetLoginAsGuestLink() {
        $pageInfos = GetPageInfos();
        foreach ($pageInfos as $pageInfo) {
            if (GetApplication()->GetUserPermissionSet('guest', $pageInfo['name'])->HasViewGrant()) {
                return $pageInfo['filename'];
            }
        }
        return $this->urlToRedirectAfterLogin;
    }

    public function checkUserAccountVerified($username) {
        try {
            $result = $this->userAuthentication->checkUserAccountVerified($username);
            if (!$result) {
                $this->errorMessage = $this->captions->GetMessageString('AccountHasNotBeenVerified');
            }
            return $result;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function ClearUserIdentity() {
        $this->userIdentityStorage->ClearUserIdentity();
    }

    private function getAuxiliaryConnection() {
        $connection = $this->connectionFactory->CreateConnection(GetConnectionOptions());
        try {
            $connection->Connect();
            return $connection;
        } catch (Exception $e) {
            ShowErrorPage($e);
            die;
        }
    }

    private function DoOnAfterLogin($userName, &$canLogin, &$errorMessage) {
        $connection = $this->getAuxiliaryConnection();
        $this->page->OnAfterLogin->Fire(array($userName, $connection, &$canLogin, &$errorMessage));
        $connection->Disconnect();
    }

    private function DoBeforeLogout($userName) {
        $connection = $this->getAuxiliaryConnection();
        $this->page->OnBeforeLogout->Fire(array($userName, $connection));
        $connection->Disconnect();
    }

    private function GetUrlToRedirectAfterLogin() {
        if (GetApplication()->GetSuperGlobals()->IsGetValueSet('redirect')) {
            return GetApplication()->GetSuperGlobals()->GetGetValue('redirect');
        }

        $pageInfos = GetPageInfos();
        foreach ($pageInfos as $pageInfo) {
            if (GetCurrentUserPermissionSetForDataSource($pageInfo['name'])->HasViewGrant()) {
                return $pageInfo['filename'];
            }
        }
        return $this->urlToRedirectAfterLogin;
    }

    public function ProcessMessages() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $this->processLogin($_POST['username'], $_POST['password'], isset($_POST['saveidentity']));
        } elseif (isset($_GET[OPERATION_PARAMNAME]) && $_GET[OPERATION_PARAMNAME] == 'logout') {
            $this->processLogout();
        }

        $this->processSecurityFeedback();
    }

    /**
     * @param string $username
     * @param string $password
     * @param bool $saveIdentity
     */
    private function processLogin($username, $password, $saveIdentity) {
        if ($this->getSelfRegistrationEnabled() && !$this->checkUserAccountVerified($username)) {
            return;
        }
        if ($this->checkUserIdentity($username, $password, $this->errorMessage)) {
            $this->SaveUserIdentity($username, $password, $saveIdentity);

            $canLogin = true;
            $message = '';
            $this->DoOnAfterLogin($username, $canLogin, $message);
            if (!$canLogin) {
                $this->ClearUserIdentity();
                $this->errorMessage = $message;
                return;
            }

            header('Location: ' . $this->GetUrlToRedirectAfterLogin());
            exit;
        } else {
            $this->lastSaveidentity = $saveIdentity;
        }
    }

    public function checkUserIdentity($username, $password, &$errorMessage) {
        try {
            $result = $this->userAuthentication->checkUserIdentity($username, $password);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return false;
        }
        if (!$result) {
            $errorMessage = $this->captions->GetMessageString('UsernamePasswordWasInvalid');
        }
        return $result;
    }

    public function SaveUserIdentity($username, $password, $is_persistent) {
        $this->userAuthentication->saveUserIdentity(new UserIdentity($username, $password, $is_persistent));
    }

    private function processLogout() {
        $identity = $this->userIdentityStorage->getUserIdentity();
        if (!is_null($identity)) {
            $this->DoBeforeLogout($identity->userName);
        }
        $this->ClearUserIdentity();
    }

    public function getSelfRegistrationEnabled() {
        return $this->userAuthentication->getSelfRegistrationEnabled();
    }

    public function getRecoveringPasswordEnabled() {
        return $this->userAuthentication->getRecoveringPasswordEnabled();
    }

    public function getEmailBasedFeaturesEnabled() {
        return ($this->userAuthentication->getSelfRegistrationEnabled() || $this->userAuthentication->getRecoveringPasswordEnabled());
    }

    public function processSecurityFeedback() {
        $this->securityFeedbackPositive = $this->getSessionVariable(SecurityFeedback::Positive);
        $this->securityFeedbackNegative = $this->getSessionVariable(SecurityFeedback::Negative);
        $this->unsetSessionVariable(SecurityFeedback::Positive);
        $this->unsetSessionVariable(SecurityFeedback::Negative);
    }

    public function getSecurityFeedbackPositive() {
        return $this->securityFeedbackPositive;
    }

    public function getSecurityFeedbackNegative() {
        return $this->securityFeedbackNegative;
    }

    private function getSessionVariable($name) {
        return GetApplication()->GetSessionVariable($name);
    }

    private function unsetSessionVariable($name) {
        GetApplication()->UnSetSessionVariable($name);
    }

}