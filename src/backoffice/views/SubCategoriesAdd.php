<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubCategoriesAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsub_categoriesadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsub_categoriesadd = currentForm = new ew.Form("fsub_categoriesadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_categories")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_categories)
        ew.vars.tables.sub_categories = currentTable;
    fsub_categoriesadd.addFields([
        ["code_nist", [fields.code_nist.visible && fields.code_nist.required ? ew.Validators.required(fields.code_nist.caption) : null], fields.code_nist.isInvalid],
        ["statement", [fields.statement.visible && fields.statement.required ? ew.Validators.required(fields.statement.caption) : null], fields.statement.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid],
        ["fk_id_categories", [fields.fk_id_categories.visible && fields.fk_id_categories.required ? ew.Validators.required(fields.fk_id_categories.caption) : null], fields.fk_id_categories.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_categoriesadd,
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
    fsub_categoriesadd.validate = function () {
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
    fsub_categoriesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_categoriesadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsub_categoriesadd");
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
<form name="fsub_categoriesadd" id="fsub_categoriesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_categories">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "categories") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="categories">
<input type="hidden" name="fk_code_nist" value="<?= HtmlEncode($Page->fk_id_categories->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->code_nist->Visible) { // code_nist ?>
    <div id="r_code_nist" class="form-group row">
        <label id="elh_sub_categories_code_nist" for="x_code_nist" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code_nist->caption() ?><?= $Page->code_nist->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->code_nist->cellAttributes() ?>>
<span id="el_sub_categories_code_nist">
<input type="<?= $Page->code_nist->getInputTextType() ?>" data-table="sub_categories" data-field="x_code_nist" name="x_code_nist" id="x_code_nist" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code_nist->getPlaceHolder()) ?>" value="<?= $Page->code_nist->EditValue ?>"<?= $Page->code_nist->editAttributes() ?> aria-describedby="x_code_nist_help">
<?= $Page->code_nist->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code_nist->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statement->Visible) { // statement ?>
    <div id="r_statement" class="form-group row">
        <label id="elh_sub_categories_statement" for="x_statement" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statement->caption() ?><?= $Page->statement->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statement->cellAttributes() ?>>
<span id="el_sub_categories_statement">
<input type="<?= $Page->statement->getInputTextType() ?>" data-table="sub_categories" data-field="x_statement" name="x_statement" id="x_statement" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statement->getPlaceHolder()) ?>" value="<?= $Page->statement->EditValue ?>"<?= $Page->statement->editAttributes() ?> aria-describedby="x_statement_help">
<?= $Page->statement->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statement->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_sub_categories_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_sub_categories_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="sub_categories" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_categoriesadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_categoriesadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_sub_categories_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_sub_categories_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="sub_categories" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsub_categoriesadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsub_categoriesadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fk_id_categories->Visible) { // fk_id_categories ?>
    <div id="r_fk_id_categories" class="form-group row">
        <label id="elh_sub_categories_fk_id_categories" for="x_fk_id_categories" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fk_id_categories->caption() ?><?= $Page->fk_id_categories->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fk_id_categories->cellAttributes() ?>>
<?php if ($Page->fk_id_categories->getSessionValue() != "") { ?>
<span id="el_sub_categories_fk_id_categories">
<span<?= $Page->fk_id_categories->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fk_id_categories->getDisplayValue($Page->fk_id_categories->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_fk_id_categories" name="x_fk_id_categories" value="<?= HtmlEncode($Page->fk_id_categories->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_sub_categories_fk_id_categories">
<input type="<?= $Page->fk_id_categories->getInputTextType() ?>" data-table="sub_categories" data-field="x_fk_id_categories" name="x_fk_id_categories" id="x_fk_id_categories" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fk_id_categories->getPlaceHolder()) ?>" value="<?= $Page->fk_id_categories->EditValue ?>"<?= $Page->fk_id_categories->editAttributes() ?> aria-describedby="x_fk_id_categories_help">
<?= $Page->fk_id_categories->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fk_id_categories->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("subcat_iso27001_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_iso27001_links->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_iso27001_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatIso27001LinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("subcat_cis_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cis_links->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cis_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCisLinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("subcat_cobit_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cobit_links->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cobit_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCobitLinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("subcat_nist_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_nist_links->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_nist_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatNistLinksGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sub_categories");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
