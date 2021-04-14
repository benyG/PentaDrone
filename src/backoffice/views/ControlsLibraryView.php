<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$ControlsLibraryView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcontrols_libraryview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcontrols_libraryview = currentForm = new ew.Form("fcontrols_libraryview", "view");
    loadjs.done("fcontrols_libraryview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.controls_library) ew.vars.tables.controls_library = <?= JsonEncode(GetClientVar("tables", "controls_library")) ?>;
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
<form name="fcontrols_libraryview" id="fcontrols_libraryview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="controls_library">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_controls_library_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
    <tr id="r_nist_subcategory_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_nist_subcategory_id"><?= $Page->nist_subcategory_id->caption() ?></span></td>
        <td data-name="nist_subcategory_id" <?= $Page->nist_subcategory_id->cellAttributes() ?>>
<span id="el_controls_library_nist_subcategory_id">
<span<?= $Page->nist_subcategory_id->viewAttributes() ?>>
<?= $Page->nist_subcategory_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <tr id="r_title">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_title"><?= $Page->title->caption() ?></span></td>
        <td data-name="title" <?= $Page->title->cellAttributes() ?>>
<span id="el_controls_library_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el_controls_library_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->best_practices->Visible) { // best_practices ?>
    <tr id="r_best_practices">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_best_practices"><?= $Page->best_practices->caption() ?></span></td>
        <td data-name="best_practices" <?= $Page->best_practices->cellAttributes() ?>>
<span id="el_controls_library_best_practices">
<span<?= $Page->best_practices->viewAttributes() ?>>
<?= $Page->best_practices->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Evidence_to_request->Visible) { // Evidence_to_request ?>
    <tr id="r_Evidence_to_request">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_Evidence_to_request"><?= $Page->Evidence_to_request->caption() ?></span></td>
        <td data-name="Evidence_to_request" <?= $Page->Evidence_to_request->cellAttributes() ?>>
<span id="el_controls_library_Evidence_to_request">
<span<?= $Page->Evidence_to_request->viewAttributes() ?>>
<?= $Page->Evidence_to_request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_controls_library_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_controls_library_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_controls_library_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("layer_controls_links", explode(",", $Page->getCurrentDetailTable())) && $layer_controls_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("layer_controls_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "LayerControlsLinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("risk_control_links", explode(",", $Page->getCurrentDetailTable())) && $risk_control_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("risk_control_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "RiskControlLinksGrid.php" ?>
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
