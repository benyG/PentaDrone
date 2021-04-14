<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Email class
 */
class Email
{
    public $Sender = ""; // Sender
    public $Recipient = ""; // Recipient
    public $Cc = ""; // Cc
    public $Bcc = ""; // Bcc
    public $Subject = ""; // Subject
    public $Format = ""; // Format
    public $Content = ""; // Content
    public $Attachments = []; // Attachments
    public $EmbeddedImages = []; // Embedded image
    public $Charset = ""; // Charset
    public $SendErrDescription; // Send error description
    public $SmtpSecure = ""; // Send secure option
    protected $Prop = []; // PHPMailer properties

    // Constructor
    public function __construct()
    {
        $this->Charset = Config("EMAIL_CHARSET");
        $this->SmtpSecure = Config("SMTP.SECURE_OPTION");
    }

    // Set PHPMailer property
    public function __set($name, $value)
    {
        $this->Prop[$name] = $value;
    }

    // Load email from template
    public function load($fn, $langId = "")
    {
        global $CurrentLanguage;
        $langId = ($langId == "") ? $CurrentLanguage : $langId;
        $pos = strrpos($fn, '.');
        if ($pos !== false) {
            $wrkname = substr($fn, 0, $pos); // Get file name
            $wrkext = substr($fn, $pos + 1); // Get file extension
            $wrkpath = PathCombine(ScriptFolder(), Config("EMAIL_TEMPLATE_PATH"), true); // Get file path
            $ar = ($langId != "") ? ["_" . $langId, "-" . $langId, ""] : [""];
            $exist = false;
            foreach ($ar as $suffix) {
                $wrkfile = $wrkpath . $wrkname . $suffix . "." . $wrkext;
                $exist = file_exists($wrkfile);
                if ($exist) {
                    break;
                }
            }
            if (!$exist) {
                return;
            }
            $wrk = file_get_contents($wrkfile); // Load template file content
            if (StartsString("\xEF\xBB\xBF", $wrk)) { // UTF-8 BOM
                $wrk = substr($wrk, 3);
            }
            $wrkid = $wrkname . "_content";
            if (ContainsString($wrk, $wrkid)) { // Replace content
                $wrkfile = $wrkpath . $wrkid . "." . $wrkext;
                if (file_exists($wrkfile)) {
                    $content = file_get_contents($wrkfile);
                    if (StartsString("\xEF\xBB\xBF", $content)) { // UTF-8 BOM
                        $content = substr($content, 3);
                    }
                    $wrk = str_replace("<!--" . $wrkid . "-->", $content, $wrk);
                }
            }
        }
        if ($wrk != "" && preg_match('/\n\n|\r\n\r\n/', $wrk, $m, PREG_OFFSET_CAPTURE)) { // Locate Header & Mail Content
            $i = $m[0][1];
            $header = trim(substr($wrk, 0, $i)) . "\r\n"; // Add last CrLf for matching
            $this->Content = trim(substr($wrk, $i));
            if (preg_match_all('/^\s*(Subject|From|To|Cc|Bcc|Format)\s*:([^\r\n]*)[\r\n]/m', $header, $m)) {
                $ar = array_combine($m[1], $m[2]);
                $this->Subject = trim(@$ar["Subject"]);
                $this->Sender = trim(@$ar["From"]);
                $this->Recipient = trim(@$ar["To"]);
                $this->Cc = trim(@$ar["Cc"]);
                $this->Bcc = trim(@$ar["Bcc"]);
                $this->Format = trim(@$ar["Format"]);
            }
        }
    }

    // Replace sender
    public function replaceSender($sender, $senderName = '')
    {
        if ($senderName != '') {
            $sender = $senderName . ' <' . $sender . '>';
        }
        if (ContainsString($this->Sender, '<!--$From-->')) {
            $this->Sender = str_replace('<!--$From-->', $sender, $this->Sender);
        } else {
            $this->Sender = $sender;
        }
    }

    // Replace recipient
    public function replaceRecipient($recipient, $recipientName = '')
    {
        if ($recipientName != '') {
            $recipient = $recipientName . ' <' . $recipient . '>';
        }
        if (ContainsString($this->Recipient, '<!--$To-->')) {
            $this->Recipient = str_replace('<!--$To-->', $recipient, $this->Recipient);
        } else {
            $this->addRecipient($recipient);
        }
    }
    // Add recipient
    public function addRecipient($recipient, $recipientName = '')
    {
        if ($recipientName != '') {
            $recipient = $recipientName . ' <' . $recipient . '>';
        }
        $this->Recipient = Concat($this->Recipient, $recipient, ";");
    }

    // Add cc email
    public function addCc($cc, $ccName = '')
    {
        if ($ccName != '') {
            $cc = $ccName . ' <' . $cc . '>';
        }
        $this->Cc = Concat($this->Cc, $cc, ";");
    }

    // Add bcc email
    public function addBcc($bcc, $bccName = '')
    {
        if ($bccName != '') {
            $bcc = $bccName . ' <' . $bcc . '>';
        }
        $this->Bcc = Concat($this->Bcc, $bcc, ";");
    }

    // Replace subject
    public function replaceSubject($subject)
    {
        if (ContainsString($this->Subject, '<!--$Subject-->')) {
            $this->Subject = str_replace('<!--$Subject-->', $subject, $this->Subject);
        } else {
            $this->Subject = $subject;
        }
    }

    // Replace content
    public function replaceContent($find, $replaceWith)
    {
        $this->Content = str_replace($find, $replaceWith, $this->Content);
    }

    /**
     * Add embedded image
     *
     * @param string $image File name of image (in global upload folder)
     * @return void
     */
    public function addEmbeddedImage($image)
    {
        if ($image != "") {
            $this->EmbeddedImages[] = $image;
        }
    }

    /**
     * Add attachment
     *
     * @param string $fileName Full file path (without $content) or file name (with $content)
     * @param string $content File content
     * @return void
     */
    public function addAttachment($fileName, $content = "")
    {
        if ($fileName != "") {
            $this->Attachments[] = ["filename" => $fileName, "content" => $content];
        }
    }

    /**
     * Send email
     *
     * @return bool Whether email is sent successfully
     */
    public function send()
    {
        $result = SendEmail(
            $this->Sender,
            $this->Recipient,
            $this->Cc,
            $this->Bcc,
            $this->Subject,
            $this->Content,
            $this->Format,
            $this->Charset,
            $this->SmtpSecure,
            $this->Attachments,
            $this->EmbeddedImages,
            $this->Prop
        );
        if (is_bool($result)) {
            return $result;
        } else { // Error
            $this->SendErrDescription = $result;
            return false;
        }
    }
}
