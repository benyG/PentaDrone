<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubCategoriesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_categoriesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fsub_categoriesview = currentForm = new ew.Form("fsub_categoriesview", "view");
    loadjs.done("fsub_categoriesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.sub_categories) ew.vars.tables.sub_categories = <?= JsonEncode(GetClientVar("tables", "sub_categories")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fsub_categoriesview" id="fsub_categoriesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_categories">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->code_nist->Visible) { // code_nist ?>
    <tr id="r_code_nist">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_categories_code_nist"><?= $Page->code_nist->caption() ?></span></td>
        <td data-name="code_nist" <?= $Page->code_nist->cellAttributes() ?>>
<span id="el_sub_categories_code_nist">
<span<?= $Page->code_nist->viewAttributes() ?>>
<?= $Page->code_nist->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->statement->Visible) { // statement ?>
    <tr id="r_statement">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_categories_statement"><?= $Page->statement->caption() ?></span></td>
        <td data-name="statement" <?= $Page->statement->cellAttributes() ?>>
<span id="el_sub_categories_statement">
<span<?= $Page->statement->viewAttributes() ?>>
<?= $Page->statement->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_categories_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_sub_categories_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_categories_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_sub_categories_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fk_id_categories->Visible) { // fk_id_categories ?>
    <tr id="r_fk_id_categories">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sub_categories_fk_id_categories"><?= $Page->fk_id_categories->caption() ?></span></td>
        <td data-name="fk_id_categories" <?= $Page->fk_id_categories->cellAttributes() ?>>
<span id="el_sub_categories_fk_id_categories">
<span<?= $Page->fk_id_categories->viewAttributes() ?>>
<?= $Page->fk_id_categories->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
<?php
    if (in_array("subcat_iso27001_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_iso27001_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_iso27001_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatIso27001LinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("subcat_cis_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cis_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cis_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCisLinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("subcat_cobit_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cobit_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cobit_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCobitLinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("subcat_nist_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_nist_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_nist_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatNistLinksGrid.php" ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
