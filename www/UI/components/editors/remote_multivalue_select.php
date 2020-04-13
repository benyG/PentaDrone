<?php

include_once dirname(__FILE__) . '/' . 'multivalue_select.php';

class RemoteMultiValueSelect extends MultiValueSelect {
    /**
     * @var string
     */
    private $handlerName;

    /**
     * @param string $name
     * @param LinkBuilder $linkBuilder
     */
    public function __construct($name, LinkBuilder $linkBuilder)
    {
        parent::__construct($name);
        $this->linkBuilder = $linkBuilder;
    }

    /**
     * @return string
     */
    public function getHandlerName() {
        return $this->handlerName;
    }
    
    /**
     * @param string $handlerName
     */
    public function setHandlerName($handlerName) {
        $this->handlerName = $handlerName;
    }

    /**
     * @return string
     */
    public function getDataUrl() {
        $linkBuilder = $this->linkBuilder->CloneLinkBuilder();
        $linkBuilder->AddParameter(OPERATION_HTTPHANDLER_NAME_PARAMNAME, $this->getHandlerName());
        return $linkBuilder->GetLink();
    }

    /**
     * @return string
     */
    public function getEditorName()
    {
        return 'remote_multivalue_select';
    }

    /**
     * @inheritdoc
     */
    public function extractValueFromArray(ArrayWrapper $arrayWrapper, &$valueChanged) {
        $valueChanged = $arrayWrapper->isValueSet($this->GetName());
        if ($valueChanged) {
            return $arrayWrapper->GetValue($this->GetName());
        } else {
            return '';
        }
    }

}