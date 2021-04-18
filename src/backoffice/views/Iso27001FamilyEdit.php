<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001FamilyEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fiso27001_familyedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fiso27001_familyedit = currentForm = new ew.Form("fiso27001_familyedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "iso27001_family")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.iso27001_family)
        ew.vars.tables.iso27001_family = currentTable;
    fiso27001_familyedit.addFields([
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["control_area_id", [fields.control_area_id.visible && fields.control_area_id.required ? ew.Validators.required(fields.control_area_id.caption) : null], fields.control_area_id.isInvalid],
        ["control_familyName", [fields.control_familyName.visible && fields.control_familyName.required ? ew.Validators.required(fields.control_familyName.caption) : null], fields.control_familyName.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fiso27001_familyedit,
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
    fiso27001_familyedit.validate = function () {
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
    fiso27001_familyedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fiso27001_familyedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fiso27001_familyedit.lists.control_area_id = <?= $Page->control_area_id->toClientList($Page) ?>;
    loadjs.done("fiso27001_familyedit");
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
<form name="fiso27001_familyedit" id="fiso27001_familyedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_family">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "iso27001_controlarea") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="iso27001_controlarea">
<input type="hidden" name="fk_control_area" value="<?= HtmlEncode($Page->control_area_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code" class="form-group row">
        <label id="elh_iso27001_family_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->code->cellAttributes() ?>>
<span id="el_iso27001_family_code">
<input type="<?= $Page->code->getInputTextType() ?>" data-table="iso27001_family" data-field="x_code" name="x_code" id="x_code" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>" value="<?= $Page->code->EditValue ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_area_id->Visible) { // control_area_id ?>
    <div id="r_control_area_id" class="form-group row">
        <label id="elh_iso27001_family_control_area_id" for="x_control_area_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_area_id->caption() ?><?= $Page->control_area_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_area_id->cellAttributes() ?>>
<?php if ($Page->control_area_id->getSessionValue() != "") { ?>
<span id="el_iso27001_family_control_area_id">
<span<?= $Page->control_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->control_area_id->getDisplayValue($Page->control_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_control_area_id" name="x_control_area_id" value="<?= HtmlEncode($Page->control_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_iso27001_family_control_area_id">
    <select
        id="x_control_area_id"
        name="x_control_area_id"
        class="form-control ew-select<?= $Page->control_area_id->isInvalidClass() ?>"
        data-select2-id="iso27001_family_x_control_area_id"
        data-table="iso27001_family"
        data-field="x_control_area_id"
        data-value-separator="<?= $Page->control_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->control_area_id->getPlaceHolder()) ?>"
        <?= $Page->control_area_id->editAttributes() ?>>
        <?= $Page->control_area_id->selectOptionListHtml("x_control_area_id") ?>
    </select>
    <?= $Page->control_area_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->control_area_id->getErrorMessage() ?></div>
<?= $Page->control_area_id->Lookup->getParamTag($Page, "p_x_control_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='iso27001_family_x_control_area_id']"),
        options = { name: "x_control_area_id", selectId: "iso27001_family_x_control_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.iso27001_family.fields.control_area_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_familyName->Visible) { // control_familyName ?>
    <div id="r_control_familyName" class="form-group row">
        <label id="elh_iso27001_family_control_familyName" for="x_control_familyName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_familyName->caption() ?><?= $Page->control_familyName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_familyName->cellAttributes() ?>>
<input type="<?= $Page->control_familyName->getInputTextType() ?>" data-table="iso27001_family" data-field="x_control_familyName" name="x_control_familyName" id="x_control_familyName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->control_familyName->getPlaceHolder()) ?>" value="<?= $Page->control_familyName->EditValue ?>"<?= $Page->control_familyName->editAttributes() ?> aria-describedby="x_control_familyName_help">
<?= $Page->control_familyName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_familyName->getErrorMessage() ?></div>
<input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="o_control_familyName" id="o_control_familyName" value="<?= HtmlEncode($Page->control_familyName->OldValue ?? $Page->control_familyName->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_iso27001_family_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<span id="el_iso27001_family_description">
<?php $Page->description->EditAttrs->appendClass("editor"); ?>
<textarea data-table="iso27001_family" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
<script>
loadjs.ready(["fiso27001_familyedit", "editor"], function() {
	ew.createEditor("fiso27001_familyedit", "x_description", 35, 4, <?= $Page->description->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("iso27001_refs", explode(",", $Page->getCurrentDetailTable())) && $iso27001_refs->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("iso27001_refs", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "Iso27001RefsGrid.php" ?>
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
    ew.addEventHandlers("iso27001_family");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>