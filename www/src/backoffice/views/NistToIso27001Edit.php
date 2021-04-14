<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistToIso27001Edit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnist_to_iso27001edit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnist_to_iso27001edit = currentForm = new ew.Form("fnist_to_iso27001edit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "nist_to_iso27001")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.nist_to_iso27001)
        ew.vars.tables.nist_to_iso27001 = currentTable;
    fnist_to_iso27001edit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["nistrefs_family", [fields.nistrefs_family.visible && fields.nistrefs_family.required ? ew.Validators.required(fields.nistrefs_family.caption) : null], fields.nistrefs_family.isInvalid],
        ["isorefs", [fields.isorefs.visible && fields.isorefs.required ? ew.Validators.required(fields.isorefs.caption) : null], fields.isorefs.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid],
        ["just_for_question_link", [fields.just_for_question_link.visible && fields.just_for_question_link.required ? ew.Validators.required(fields.just_for_question_link.caption) : null], fields.just_for_question_link.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnist_to_iso27001edit,
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
    fnist_to_iso27001edit.validate = function () {
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
    fnist_to_iso27001edit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnist_to_iso27001edit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnist_to_iso27001edit.lists.nistrefs_family = <?= $Page->nistrefs_family->toClientList($Page) ?>;
    fnist_to_iso27001edit.lists.isorefs = <?= $Page->isorefs->toClientList($Page) ?>;
    loadjs.done("fnist_to_iso27001edit");
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
<form name="fnist_to_iso27001edit" id="fnist_to_iso27001edit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_to_iso27001">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "nist_refs_controlfamily") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nist_refs_controlfamily">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->nistrefs_family->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "iso27001_refs") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="iso27001_refs">
<input type="hidden" name="fk_control_ID" value="<?= HtmlEncode($Page->isorefs->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_nist_to_iso27001_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_nist_to_iso27001_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nistrefs_family->Visible) { // nistrefs_family ?>
    <div id="r_nistrefs_family" class="form-group row">
        <label id="elh_nist_to_iso27001_nistrefs_family" for="x_nistrefs_family" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nistrefs_family->caption() ?><?= $Page->nistrefs_family->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nistrefs_family->cellAttributes() ?>>
<?php if ($Page->nistrefs_family->getSessionValue() != "") { ?>
<span id="el_nist_to_iso27001_nistrefs_family">
<span<?= $Page->nistrefs_family->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nistrefs_family->getDisplayValue($Page->nistrefs_family->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_nistrefs_family" name="x_nistrefs_family" value="<?= HtmlEncode($Page->nistrefs_family->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_nist_to_iso27001_nistrefs_family">
    <select
        id="x_nistrefs_family"
        name="x_nistrefs_family"
        class="form-control ew-select<?= $Page->nistrefs_family->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x_nistrefs_family"
        data-table="nist_to_iso27001"
        data-field="x_nistrefs_family"
        data-value-separator="<?= $Page->nistrefs_family->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nistrefs_family->getPlaceHolder()) ?>"
        <?= $Page->nistrefs_family->editAttributes() ?>>
        <?= $Page->nistrefs_family->selectOptionListHtml("x_nistrefs_family") ?>
    </select>
    <?= $Page->nistrefs_family->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->nistrefs_family->getErrorMessage() ?></div>
<?= $Page->nistrefs_family->Lookup->getParamTag($Page, "p_x_nistrefs_family") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x_nistrefs_family']"),
        options = { name: "x_nistrefs_family", selectId: "nist_to_iso27001_x_nistrefs_family", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.nistrefs_family.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isorefs->Visible) { // isorefs ?>
    <div id="r_isorefs" class="form-group row">
        <label id="elh_nist_to_iso27001_isorefs" for="x_isorefs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isorefs->caption() ?><?= $Page->isorefs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isorefs->cellAttributes() ?>>
<?php if ($Page->isorefs->getSessionValue() != "") { ?>
<span id="el_nist_to_iso27001_isorefs">
<span<?= $Page->isorefs->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->isorefs->getDisplayValue($Page->isorefs->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_isorefs" name="x_isorefs" value="<?= HtmlEncode($Page->isorefs->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_nist_to_iso27001_isorefs">
    <select
        id="x_isorefs"
        name="x_isorefs"
        class="form-control ew-select<?= $Page->isorefs->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x_isorefs"
        data-table="nist_to_iso27001"
        data-field="x_isorefs"
        data-value-separator="<?= $Page->isorefs->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->isorefs->getPlaceHolder()) ?>"
        <?= $Page->isorefs->editAttributes() ?>>
        <?= $Page->isorefs->selectOptionListHtml("x_isorefs") ?>
    </select>
    <?= $Page->isorefs->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->isorefs->getErrorMessage() ?></div>
<?= $Page->isorefs->Lookup->getParamTag($Page, "p_x_isorefs") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x_isorefs']"),
        options = { name: "x_isorefs", selectId: "nist_to_iso27001_x_isorefs", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.isorefs.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_nist_to_iso27001_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_nist_to_iso27001_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="nist_to_iso27001" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnist_to_iso27001edit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnist_to_iso27001edit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_nist_to_iso27001_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_nist_to_iso27001_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="nist_to_iso27001" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnist_to_iso27001edit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnist_to_iso27001edit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->just_for_question_link->Visible) { // just_for_question_link ?>
    <div id="r_just_for_question_link" class="form-group row">
        <label id="elh_nist_to_iso27001_just_for_question_link" for="x_just_for_question_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->just_for_question_link->caption() ?><?= $Page->just_for_question_link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->just_for_question_link->cellAttributes() ?>>
<span id="el_nist_to_iso27001_just_for_question_link">
<input type="<?= $Page->just_for_question_link->getInputTextType() ?>" data-table="nist_to_iso27001" data-field="x_just_for_question_link" name="x_just_for_question_link" id="x_just_for_question_link" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->just_for_question_link->getPlaceHolder()) ?>" value="<?= $Page->just_for_question_link->EditValue ?>"<?= $Page->just_for_question_link->editAttributes() ?> aria-describedby="x_just_for_question_link_help">
<?= $Page->just_for_question_link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->just_for_question_link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("questions_library", explode(",", $Page->getCurrentDetailTable())) && $questions_library->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("questions_library", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "QuestionsLibraryGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("nist_to_iso27001");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
