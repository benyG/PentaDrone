<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001ControlareaEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fiso27001_controlareaedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fiso27001_controlareaedit = currentForm = new ew.Form("fiso27001_controlareaedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "iso27001_controlarea")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.iso27001_controlarea)
        ew.vars.tables.iso27001_controlarea = currentTable;
    fiso27001_controlareaedit.addFields([
        ["control_area", [fields.control_area.visible && fields.control_area.required ? ew.Validators.required(fields.control_area.caption) : null], fields.control_area.isInvalid],
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["ordre", [fields.ordre.visible && fields.ordre.required ? ew.Validators.required(fields.ordre.caption) : null], fields.ordre.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fiso27001_controlareaedit,
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
    fiso27001_controlareaedit.validate = function () {
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
    fiso27001_controlareaedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fiso27001_controlareaedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fiso27001_controlareaedit");
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
<form name="fiso27001_controlareaedit" id="fiso27001_controlareaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_controlarea">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->control_area->Visible) { // control_area ?>
    <div id="r_control_area" class="form-group row">
        <label id="elh_iso27001_controlarea_control_area" for="x_control_area" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_area->caption() ?><?= $Page->control_area->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_area->cellAttributes() ?>>
<input type="<?= $Page->control_area->getInputTextType() ?>" data-table="iso27001_controlarea" data-field="x_control_area" name="x_control_area" id="x_control_area" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->control_area->getPlaceHolder()) ?>" value="<?= $Page->control_area->EditValue ?>"<?= $Page->control_area->editAttributes() ?> aria-describedby="x_control_area_help">
<?= $Page->control_area->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_area->getErrorMessage() ?></div>
<input type="hidden" data-table="iso27001_controlarea" data-field="x_control_area" data-hidden="1" name="o_control_area" id="o_control_area" value="<?= HtmlEncode($Page->control_area->OldValue ?? $Page->control_area->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code" class="form-group row">
        <label id="elh_iso27001_controlarea_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->code->cellAttributes() ?>>
<span id="el_iso27001_controlarea_code">
<input type="<?= $Page->code->getInputTextType() ?>" data-table="iso27001_controlarea" data-field="x_code" name="x_code" id="x_code" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>" value="<?= $Page->code->EditValue ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ordre->Visible) { // ordre ?>
    <div id="r_ordre" class="form-group row">
        <label id="elh_iso27001_controlarea_ordre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ordre->caption() ?><?= $Page->ordre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ordre->cellAttributes() ?>>
<span id="el_iso27001_controlarea_ordre">
<input type="<?= $Page->ordre->getInputTextType() ?>" data-table="iso27001_controlarea" data-field="x_ordre" name="x_ordre" id="x_ordre" placeholder="<?= HtmlEncode($Page->ordre->getPlaceHolder()) ?>" value="<?= $Page->ordre->EditValue ?>"<?= $Page->ordre->editAttributes() ?> aria-describedby="x_ordre_help">
<?= $Page->ordre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ordre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("iso27001_family", explode(",", $Page->getCurrentDetailTable())) && $iso27001_family->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("iso27001_family", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "Iso27001FamilyGrid.php" ?>
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
    ew.addEventHandlers("iso27001_controlarea");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
