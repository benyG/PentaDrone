<?php namespace PHPMaker2021\ITaudit_backoffice_v2; ?>
<form id="ew-email-form" class="ew-horizontal ew-form ew-email-form" action="<?= CurrentPageUrl() ?>">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="export" id="export" value="email">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="sender"><?= $Language->phrase("EmailFormSender") ?></label>
        <div class="col-sm-10">
            <input type="text" class="form-control ew-control" name="sender" id="sender">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="recipient"><?= $Language->phrase("EmailFormRecipient") ?></label>
        <div class="col-sm-10">
            <input type="text" class="form-control ew-control" name="recipient" id="recipient">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="cc"><?= $Language->phrase("EmailFormCc") ?></label>
        <div class="col-sm-10">
            <input type="text" class="form-control ew-control" name="cc" id="cc">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="bcc"><?= $Language->phrase("EmailFormBcc") ?></label>
        <div class="col-sm-10">
            <input type="text" class="form-control ew-control" name="bcc" id="bcc">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="subject"><?= $Language->phrase("EmailFormSubject") ?></label>
        <div class="col-sm-10">
            <input type="text" class="form-control ew-control" name="subject" id="subject">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="message"><?= $Language->phrase("EmailFormMessage") ?></label>
        <div class="col-sm-10">
            <textarea class="form-control ew-control" rows="6" name="message" id="message"></textarea>
            <div class="invalid-feedback"></div>
        </div>
    </div>
</form>
