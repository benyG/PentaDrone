<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionTargetProfilesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestion_target_profilesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fquestion_target_profilesedit = currentForm = new ew.Form("fquestion_target_profilesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "question_target_profiles")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.question_target_profiles)
        ew.vars.tables.question_target_profiles = currentTable;
    fquestion_target_profilesedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["libelle", [fields.libelle.visible && fields.libelle.required ? ew.Validators.required(fields.libelle.caption) : null], fields.libelle.isInvalid],
        ["control_first", [fields.control_first.visible && fields.control_first.required ? ew.Validators.required(fields.control_first.caption) : null], fields.control_first.isInvalid],
        ["control_second", [fields.control_second.visible && fields.control_second.required ? ew.Validators.required(fields.control_second.caption) : null], fields.control_second.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestion_target_profilesedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fquestion_target_profilesedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fquestion_target_profilesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestion_target_profilesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fquestion_target_profilesedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fquestion_target_profilesedit" id="fquestion_target_profilesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_target_profiles">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_question_target_profiles_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_question_target_profiles_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_target_profiles" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->libelle->Visible) { // libelle ?>
    <div id="r_libelle" class="form-group row">
        <label id="elh_question_target_profiles_libelle" for="x_libelle" class="<?= $Page->LeftColumnClass ?>"><?= $Page->libelle->caption() ?><?= $Page->libelle->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->libelle->cellAttributes() ?>>
<span id="el_question_target_profiles_libelle">
<textarea data-table="question_target_profiles" data-field="x_libelle" name="x_libelle" id="x_libelle" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->libelle->getPlaceHolder()) ?>"<?= $Page->libelle->editAttributes() ?> aria-describedby="x_libelle_help"><?= $Page->libelle->EditValue ?></textarea>
<?= $Page->libelle->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->libelle->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_first->Visible) { // control_first ?>
    <div id="r_control_first" class="form-group row">
        <label id="elh_question_target_profiles_control_first" for="x_control_first" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_first->caption() ?><?= $Page->control_first->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_first->cellAttributes() ?>>
<span id="el_question_target_profiles_control_first">
<input type="<?= $Page->control_first->getInputTextType() ?>" data-table="question_target_profiles" data-field="x_control_first" name="x_control_first" id="x_control_first" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->control_first->getPlaceHolder()) ?>" value="<?= $Page->control_first->EditValue ?>"<?= $Page->control_first->editAttributes() ?> aria-describedby="x_control_first_help">
<?= $Page->control_first->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_first->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_second->Visible) { // control_second ?>
    <div id="r_control_second" class="form-group row">
        <label id="elh_question_target_profiles_control_second" for="x_control_second" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_second->caption() ?><?= $Page->control_second->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_second->cellAttributes() ?>>
<span id="el_question_target_profiles_control_second">
<input type="<?= $Page->control_second->getInputTextType() ?>" data-table="question_target_profiles" data-field="x_control_second" name="x_control_second" id="x_control_second" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->control_second->getPlaceHolder()) ?>" value="<?= $Page->control_second->EditValue ?>"<?= $Page->control_second->editAttributes() ?> aria-describedby="x_control_second_help">
<?= $Page->control_second->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_second->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_question_target_profiles_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_question_target_profiles_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="question_target_profiles" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_target_profilesedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_target_profilesedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_question_target_profiles_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_question_target_profiles_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="question_target_profiles" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_target_profilesedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_target_profilesedit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("question_target_profiles");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
