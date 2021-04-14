<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Cobit5RefsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcobit5_refsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fcobit5_refsedit = currentForm = new ew.Form("fcobit5_refsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "cobit5_refs")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.cobit5_refs)
        ew.vars.tables.cobit5_refs = currentTable;
    fcobit5_refsedit.addFields([
        ["NIdentifier", [fields.NIdentifier.visible && fields.NIdentifier.required ? ew.Validators.required(fields.NIdentifier.caption) : null], fields.NIdentifier.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["code_cobitfamily", [fields.code_cobitfamily.visible && fields.code_cobitfamily.required ? ew.Validators.required(fields.code_cobitfamily.caption) : null], fields.code_cobitfamily.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcobit5_refsedit,
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
    fcobit5_refsedit.validate = function () {
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
    fcobit5_refsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcobit5_refsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcobit5_refsedit");
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
<form name="fcobit5_refsedit" id="fcobit5_refsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cobit5_refs">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "cobit5_family") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cobit5_family">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->code_cobitfamily->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->NIdentifier->Visible) { // NIdentifier ?>
    <div id="r_NIdentifier" class="form-group row">
        <label id="elh_cobit5_refs_NIdentifier" for="x_NIdentifier" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIdentifier->caption() ?><?= $Page->NIdentifier->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NIdentifier->cellAttributes() ?>>
<input type="<?= $Page->NIdentifier->getInputTextType() ?>" data-table="cobit5_refs" data-field="x_NIdentifier" name="x_NIdentifier" id="x_NIdentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->NIdentifier->getPlaceHolder()) ?>" value="<?= $Page->NIdentifier->EditValue ?>"<?= $Page->NIdentifier->editAttributes() ?> aria-describedby="x_NIdentifier_help">
<?= $Page->NIdentifier->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIdentifier->getErrorMessage() ?></div>
<input type="hidden" data-table="cobit5_refs" data-field="x_NIdentifier" data-hidden="1" name="o_NIdentifier" id="o_NIdentifier" value="<?= HtmlEncode($Page->NIdentifier->OldValue ?? $Page->NIdentifier->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_cobit5_refs_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_cobit5_refs_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="cobit5_refs" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_cobit5_refs_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<span id="el_cobit5_refs_description">
<textarea data-table="cobit5_refs" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code_cobitfamily->Visible) { // code_cobitfamily ?>
    <div id="r_code_cobitfamily" class="form-group row">
        <label id="elh_cobit5_refs_code_cobitfamily" for="x_code_cobitfamily" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code_cobitfamily->caption() ?><?= $Page->code_cobitfamily->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->code_cobitfamily->cellAttributes() ?>>
<?php if ($Page->code_cobitfamily->getSessionValue() != "") { ?>
<span id="el_cobit5_refs_code_cobitfamily">
<span<?= $Page->code_cobitfamily->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->code_cobitfamily->getDisplayValue($Page->code_cobitfamily->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_code_cobitfamily" name="x_code_cobitfamily" value="<?= HtmlEncode($Page->code_cobitfamily->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_cobit5_refs_code_cobitfamily">
<input type="<?= $Page->code_cobitfamily->getInputTextType() ?>" data-table="cobit5_refs" data-field="x_code_cobitfamily" name="x_code_cobitfamily" id="x_code_cobitfamily" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->code_cobitfamily->getPlaceHolder()) ?>" value="<?= $Page->code_cobitfamily->EditValue ?>"<?= $Page->code_cobitfamily->editAttributes() ?> aria-describedby="x_code_cobitfamily_help">
<?= $Page->code_cobitfamily->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code_cobitfamily->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("subcat_cobit_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cobit_links->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cobit_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCobitLinksGrid.php" ?>
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
    ew.addEventHandlers("cobit5_refs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
