<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Export to email
 */
class ExportReportEmail
{
    // Export
    public function __invoke($page, $emailContent)
    {
        global $TempImages, $Language;
        $failRespPfx = "<p class=\"text-danger\">";
        $successRespPfx = "<p class=\"text-success\">";
        $respSfx = "</p>";
        $contentType = Param("contenttype", "");
        $sender = Param("sender", "");
        $recipient = Param("recipient", "");
        $cc = Param("cc", "");
        $bcc = Param("bcc", "");

        // Subject
        $emailSubject = Param("subject", "");

        // Message
        $emailMessage = Param("message", "");

        // Check sender
        if ($sender == "") {
            echo $failRespPfx . str_replace("%s", $Language->phrase("Sender"), $Language->phrase("EnterRequiredField")) . $respSfx;
            return;
        }
        if (!CheckEmail($sender)) {
            echo $failRespPfx . $Language->phrase("EnterProperSenderEmail") . $respSfx;
            return;
        }

        // Check recipient
        if ($recipient == "") {
            echo $failRespPfx . str_replace("%s", $Language->phrase("Recipient"), $Language->phrase("EnterRequiredField")) . $respSfx;
            return;
        }
        if (!CheckEmailList($recipient, Config("MAX_EMAIL_RECIPIENT"))) {
            echo $failRespPfx . $Language->phrase("EnterProperRecipientEmail") . $respSfx;
            return;
        }

        // Check cc
        if (!CheckEmailList($cc, Config("MAX_EMAIL_RECIPIENT"))) {
            echo $failRespPfx . $Language->phrase("EnterProperCcEmail") . $respSfx;
            return;
        }

        // Check bcc
        if (!CheckEmailList($bcc, Config("MAX_EMAIL_RECIPIENT"))) {
            echo $failRespPfx . $Language->phrase("EnterProperBccEmail") . $respSfx;
        }
        if ($emailMessage != "") {
            if (Config("REMOVE_XSS")) {
                $emailMessage = RemoveXSS($emailMessage);
            }
            $emailMessage .= ($contentType == "url") ? "\n\n" : "<br><br>";
        }
        $attachmentContent = AdjustEmailContent($emailContent);
        $appPath = FullUrl("");
        $appPath = substr($appPath, 0, strrpos($appPath, "/") + 1);
        if (ContainsString($attachmentContent, "<head>")) {
            $attachmentContent = str_replace("<head>", "<head><base href=\"" . $appPath . "\">", $attachmentContent); // Add <base href> statement inside the header
        } else {
            $attachmentContent = "<base href=\"" . $appPath . "\">" . $attachmentContent; // Add <base href> statement as the first statement
        }
        $attachmentFile = $page->TableVar . "_" . Date("YmdHis") . "_" . Random() . ".html";
        if ($contentType == "url") {
            SaveFile(Config("UPLOAD_DEST_PATH"), $attachmentFile, $attachmentContent);
            $attachmentFile = Config("UPLOAD_DEST_PATH") . $attachmentFile;
            $url = $appPath . $attachmentFile;
            $emailMessage .= $url; // Send URL only
            $attachmentFile = "";
            $attachmentContent = "";
        } else {
            $emailMessage .= $attachmentContent;
            $attachmentFile = "";
            $attachmentContent = "";
        }

        // Send email
        $email = new Email();
        $email->Sender = $sender; // Sender
        $email->Recipient = $recipient; // Recipient
        $email->Cc = $cc; // Cc
        $email->Bcc = $bcc; // Bcc
        $email->Subject = $emailSubject; // Subject
        $email->Content = $emailMessage; // Content
        if ($attachmentFile != "") {
            $email->addAttachment($attachmentFile, $attachmentContent);
        }
        if ($contentType != "url") {
            foreach ($TempImages as $tmpimage) {
                $email->addEmbeddedImage($tmpimage);
            }
        }
        $email->Format = ($contentType == "url") ? "text" : "html";
        $email->Charset = Config("EMAIL_CHARSET");
        if (method_exists($page, "emailSending")) {
            $eventArgs = [];
            $emailSent = false;
            if ($page->emailSending($email, $eventArgs)) {
                $emailSent = $email->send();
            }
        } else {
            $emailSent = $email->send();
        }
        DeleteTempImages($emailContent);

        // Check email sent status
        if ($emailSent) {
            echo $successRespPfx . $Language->phrase("SendEmailSuccess") . $respSfx; // Set up success message
        } else {
            echo $failRespPfx . $email->SendErrDescription . $respSfx;
        }
        exit();
    }
}
