<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Cobit5RefsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcobit5_refsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcobit5_refsview = currentForm = new ew.Form("fcobit5_refsview", "view");
    loadjs.done("fcobit5_refsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.cobit5_refs) ew.vars.tables.cobit5_refs = <?= JsonEncode(GetClientVar("tables", "cobit5_refs")) ?>;
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
<form name="fcobit5_refsview" id="fcobit5_refsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cobit5_refs">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->NIdentifier->Visible) { // NIdentifier ?>
    <tr id="r_NIdentifier">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cobit5_refs_NIdentifier"><?= $Page->NIdentifier->caption() ?></span></td>
        <td data-name="NIdentifier" <?= $Page->NIdentifier->cellAttributes() ?>>
<span id="el_cobit5_refs_NIdentifier">
<span<?= $Page->NIdentifier->viewAttributes() ?>>
<?= $Page->NIdentifier->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cobit5_refs_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_cobit5_refs_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cobit5_refs_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el_cobit5_refs_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->code_cobitfamily->Visible) { // code_cobitfamily ?>
    <tr id="r_code_cobitfamily">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cobit5_refs_code_cobitfamily"><?= $Page->code_cobitfamily->caption() ?></span></td>
        <td data-name="code_cobitfamily" <?= $Page->code_cobitfamily->cellAttributes() ?>>
<span id="el_cobit5_refs_code_cobitfamily">
<span<?= $Page->code_cobitfamily->viewAttributes() ?>>
<?= $Page->code_cobitfamily->getViewValue() ?></span>
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
    if (in_array("subcat_cobit_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cobit_links->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cobit_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCobitLinksGrid.php" ?>
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
