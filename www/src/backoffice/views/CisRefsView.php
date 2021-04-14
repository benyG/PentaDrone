<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$CisRefsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcis_refsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcis_refsview = currentForm = new ew.Form("fcis_refsview", "view");
    loadjs.done("fcis_refsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.cis_refs) ew.vars.tables.cis_refs = <?= JsonEncode(GetClientVar("tables", "cis_refs")) ?>;
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
<form name="fcis_refsview" id="fcis_refsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cis_refs">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
    <tr id="r_Nidentifier">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cis_refs_Nidentifier"><?= $Page->Nidentifier->caption() ?></span></td>
        <td data-name="Nidentifier" <?= $Page->Nidentifier->cellAttributes() ?>>
<span id="el_cis_refs_Nidentifier">
<span<?= $Page->Nidentifier->viewAttributes() ?>>
<?= $Page->Nidentifier->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
    <tr id="r_Control_Family_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cis_refs_Control_Family_id"><?= $Page->Control_Family_id->caption() ?></span></td>
        <td data-name="Control_Family_id" <?= $Page->Control_Family_id->cellAttributes() ?>>
<span id="el_cis_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<?= $Page->Control_Family_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_Name->Visible) { // control_Name ?>
    <tr id="r_control_Name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cis_refs_control_Name"><?= $Page->control_Name->caption() ?></span></td>
        <td data-name="control_Name" <?= $Page->control_Name->cellAttributes() ?>>
<span id="el_cis_refs_control_Name">
<span<?= $Page->control_Name->viewAttributes() ?>>
<?= $Page->control_Name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_description->Visible) { // control_description ?>
    <tr id="r_control_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cis_refs_control_description"><?= $Page->control_description->caption() ?></span></td>
        <td data-name="control_description" <?= $Page->control_description->cellAttributes() ?>>
<span id="el_cis_refs_control_description">
<span<?= $Page->control_description->viewAttributes() ?>>
<?= $Page->control_description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impl_group1->Visible) { // impl_group1 ?>
    <tr id="r_impl_group1">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cis_refs_impl_group1"><?= $Page->impl_group1->caption() ?></span></td>
        <td data-name="impl_group1" <?= $Page->impl_group1->cellAttributes() ?>>
<span id="el_cis_refs_impl_group1">
<span<?= $Page->impl_group1->viewAttributes() ?>>
<?= $Page->impl_group1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impl_group2->Visible) { // impl_group2 ?>
    <tr id="r_impl_group2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cis_refs_impl_group2"><?= $Page->impl_group2->caption() ?></span></td>
        <td data-name="impl_group2" <?= $Page->impl_group2->cellAttributes() ?>>
<span id="el_cis_refs_impl_group2">
<span<?= $Page->impl_group2->viewAttributes() ?>>
<?= $Page->impl_group2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impl_group3->Visible) { // impl_group3 ?>
    <tr id="r_impl_group3">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cis_refs_impl_group3"><?= $Page->impl_group3->caption() ?></span></td>
        <td data-name="impl_group3" <?= $Page->impl_group3->cellAttributes() ?>>
<span id="el_cis_refs_impl_group3">
<span<?= $Page->impl_group3->viewAttributes() ?>>
<?= $Page->impl_group3->getViewValue() ?></span>
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
    if (in_array("subcat_cis_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cis_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cis_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCisLinksGrid.php" ?>
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
