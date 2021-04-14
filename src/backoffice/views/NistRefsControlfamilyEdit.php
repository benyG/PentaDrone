<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistRefsControlfamilyEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnist_refs_controlfamilyedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnist_refs_controlfamilyedit = currentForm = new ew.Form("fnist_refs_controlfamilyedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "nist_refs_controlfamily")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.nist_refs_controlfamily)
        ew.vars.tables.nist_refs_controlfamily = currentTable;
    fnist_refs_controlfamilyedit.addFields([
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["controlarea_id", [fields.controlarea_id.visible && fields.controlarea_id.required ? ew.Validators.required(fields.controlarea_id.caption) : null], fields.controlarea_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnist_refs_controlfamilyedit,
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
    fnist_refs_controlfamilyedit.validate = function () {
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
    fnist_refs_controlfamilyedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnist_refs_controlfamilyedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnist_refs_controlfamilyedit");
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
<form name="fnist_refs_controlfamilyedit" id="fnist_refs_controlfamilyedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_refs_controlfamily">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "nist_refs_controlarea") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nist_refs_controlarea">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->controlarea_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "subcat_nist_links") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="subcat_nist_links">
<input type="hidden" name="fk_nistrefs_id" value="<?= HtmlEncode($Page->code->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code" class="form-group row">
        <label id="elh_nist_refs_controlfamily_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->code->cellAttributes() ?>>
<?php if ($Page->code->getSessionValue() != "") { ?>
<span id="el_nist_refs_controlfamily_code">
<span<?= $Page->code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->code->getDisplayValue($Page->code->EditValue))) ?>"></span>
</span>
<input type="hidden" id="x_code" name="x_code" value="<?= HtmlEncode($Page->code->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->code->getInputTextType() ?>" data-table="nist_refs_controlfamily" data-field="x_code" name="x_code" id="x_code" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>" value="<?= $Page->code->EditValue ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="nist_refs_controlfamily" data-field="x_code" data-hidden="1" name="o_code" id="o_code" value="<?= HtmlEncode($Page->code->OldValue ?? $Page->code->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_nist_refs_controlfamily_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_nist_refs_controlfamily_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="nist_refs_controlfamily" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->controlarea_id->Visible) { // controlarea_id ?>
    <div id="r_controlarea_id" class="form-group row">
        <label id="elh_nist_refs_controlfamily_controlarea_id" for="x_controlarea_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->controlarea_id->caption() ?><?= $Page->controlarea_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->controlarea_id->cellAttributes() ?>>
<?php if ($Page->controlarea_id->getSessionValue() != "") { ?>
<span id="el_nist_refs_controlfamily_controlarea_id">
<span<?= $Page->controlarea_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->controlarea_id->getDisplayValue($Page->controlarea_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_controlarea_id" name="x_controlarea_id" value="<?= HtmlEncode($Page->controlarea_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_nist_refs_controlfamily_controlarea_id">
<input type="<?= $Page->controlarea_id->getInputTextType() ?>" data-table="nist_refs_controlfamily" data-field="x_controlarea_id" name="x_controlarea_id" id="x_controlarea_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->controlarea_id->getPlaceHolder()) ?>" value="<?= $Page->controlarea_id->EditValue ?>"<?= $Page->controlarea_id->editAttributes() ?> aria-describedby="x_controlarea_id_help">
<?= $Page->controlarea_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->controlarea_id->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("nist_refs", explode(",", $Page->getCurrentDetailTable())) && $nist_refs->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("nist_refs", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "NistRefsGrid.php" ?>
<?php } ?>
<?php
    if (in_array("nist_to_iso27001", explode(",", $Page->getCurrentDetailTable())) && $nist_to_iso27001->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("nist_to_iso27001", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "NistToIso27001Grid.php" ?>
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
    ew.addEventHandlers("nist_refs_controlfamily");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
