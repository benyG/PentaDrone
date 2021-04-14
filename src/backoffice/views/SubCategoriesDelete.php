<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubCategoriesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsub_categoriesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsub_categoriesdelete = currentForm = new ew.Form("fsub_categoriesdelete", "delete");
    loadjs.done("fsub_categoriesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.sub_categories) ew.vars.tables.sub_categories = <?= JsonEncode(GetClientVar("tables", "sub_categories")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsub_categoriesdelete" id="fsub_categoriesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_categories">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->code_nist->Visible) { // code_nist ?>
        <th class="<?= $Page->code_nist->headerCellClass() ?>"><span id="elh_sub_categories_code_nist" class="sub_categories_code_nist"><?= $Page->code_nist->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statement->Visible) { // statement ?>
        <th class="<?= $Page->statement->headerCellClass() ?>"><span id="elh_sub_categories_statement" class="sub_categories_statement"><?= $Page->statement->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->code_nist->Visible) { // code_nist ?>
        <td <?= $Page->code_nist->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_categories_code_nist" class="sub_categories_code_nist">
<span<?= $Page->code_nist->viewAttributes() ?>>
<?= $Page->code_nist->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statement->Visible) { // statement ?>
        <td <?= $Page->statement->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sub_categories_statement" class="sub_categories_statement">
<span<?= $Page->statement->viewAttributes() ?>>
<?= $Page->statement->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
