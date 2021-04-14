<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001RefsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fiso27001_refsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fiso27001_refsview = currentForm = new ew.Form("fiso27001_refsview", "view");
    loadjs.done("fiso27001_refsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.iso27001_refs) ew.vars.tables.iso27001_refs = <?= JsonEncode(GetClientVar("tables", "iso27001_refs")) ?>;
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
<form name="fiso27001_refsview" id="fiso27001_refsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_refs">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->code->Visible) { // code ?>
    <tr id="r_code">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_refs_code"><?= $Page->code->caption() ?></span></td>
        <td data-name="code" <?= $Page->code->cellAttributes() ?>>
<span id="el_iso27001_refs_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_familyName_id->Visible) { // control_familyName_id ?>
    <tr id="r_control_familyName_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_refs_control_familyName_id"><?= $Page->control_familyName_id->caption() ?></span></td>
        <td data-name="control_familyName_id" <?= $Page->control_familyName_id->cellAttributes() ?>>
<span id="el_iso27001_refs_control_familyName_id">
<span<?= $Page->control_familyName_id->viewAttributes() ?>>
<?= $Page->control_familyName_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_name->Visible) { // control_name ?>
    <tr id="r_control_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_refs_control_name"><?= $Page->control_name->caption() ?></span></td>
        <td data-name="control_name" <?= $Page->control_name->cellAttributes() ?>>
<span id="el_iso27001_refs_control_name">
<span<?= $Page->control_name->viewAttributes() ?>>
<?= $Page->control_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_refs_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el_iso27001_refs_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_ID->Visible) { // control_ID ?>
    <tr id="r_control_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_refs_control_ID"><?= $Page->control_ID->caption() ?></span></td>
        <td data-name="control_ID" <?= $Page->control_ID->cellAttributes() ?>>
<span id="el_iso27001_refs_control_ID">
<span<?= $Page->control_ID->viewAttributes() ?>>
<?= $Page->control_ID->getViewValue() ?></span>
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
    if (in_array("questions_library", explode(",", $Page->getCurrentDetailTable())) && $questions_library->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("questions_library", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "QuestionsLibraryGrid.php" ?>
<?php } ?>
<?php
    if (in_array("nist_to_iso27001", explode(",", $Page->getCurrentDetailTable())) && $nist_to_iso27001->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("nist_to_iso27001", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "NistToIso27001Grid.php" ?>
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
