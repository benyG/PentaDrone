<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistRefsControlfamilyView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnist_refs_controlfamilyview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnist_refs_controlfamilyview = currentForm = new ew.Form("fnist_refs_controlfamilyview", "view");
    loadjs.done("fnist_refs_controlfamilyview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.nist_refs_controlfamily) ew.vars.tables.nist_refs_controlfamily = <?= JsonEncode(GetClientVar("tables", "nist_refs_controlfamily")) ?>;
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
<form name="fnist_refs_controlfamilyview" id="fnist_refs_controlfamilyview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_refs_controlfamily">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->code->Visible) { // code ?>
    <tr id="r_code">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_controlfamily_code"><?= $Page->code->caption() ?></span></td>
        <td data-name="code" <?= $Page->code->cellAttributes() ?>>
<span id="el_nist_refs_controlfamily_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_controlfamily_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_nist_refs_controlfamily_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->controlarea_id->Visible) { // controlarea_id ?>
    <tr id="r_controlarea_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_controlfamily_controlarea_id"><?= $Page->controlarea_id->caption() ?></span></td>
        <td data-name="controlarea_id" <?= $Page->controlarea_id->cellAttributes() ?>>
<span id="el_nist_refs_controlfamily_controlarea_id">
<span<?= $Page->controlarea_id->viewAttributes() ?>>
<?= $Page->controlarea_id->getViewValue() ?></span>
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
    if (in_array("nist_refs", explode(",", $Page->getCurrentDetailTable())) && $nist_refs->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("nist_refs", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "NistRefsGrid.php" ?>
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
