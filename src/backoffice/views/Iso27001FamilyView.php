<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001FamilyView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fiso27001_familyview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fiso27001_familyview = currentForm = new ew.Form("fiso27001_familyview", "view");
    loadjs.done("fiso27001_familyview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.iso27001_family) ew.vars.tables.iso27001_family = <?= JsonEncode(GetClientVar("tables", "iso27001_family")) ?>;
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
<form name="fiso27001_familyview" id="fiso27001_familyview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_family">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->code->Visible) { // code ?>
    <tr id="r_code">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_family_code"><?= $Page->code->caption() ?></span></td>
        <td data-name="code" <?= $Page->code->cellAttributes() ?>>
<span id="el_iso27001_family_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_area_id->Visible) { // control_area_id ?>
    <tr id="r_control_area_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_family_control_area_id"><?= $Page->control_area_id->caption() ?></span></td>
        <td data-name="control_area_id" <?= $Page->control_area_id->cellAttributes() ?>>
<span id="el_iso27001_family_control_area_id">
<span<?= $Page->control_area_id->viewAttributes() ?>>
<?= $Page->control_area_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_familyName->Visible) { // control_familyName ?>
    <tr id="r_control_familyName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_family_control_familyName"><?= $Page->control_familyName->caption() ?></span></td>
        <td data-name="control_familyName" <?= $Page->control_familyName->cellAttributes() ?>>
<span id="el_iso27001_family_control_familyName">
<span<?= $Page->control_familyName->viewAttributes() ?>>
<?= $Page->control_familyName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_family_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el_iso27001_family_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
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
    if (in_array("iso27001_refs", explode(",", $Page->getCurrentDetailTable())) && $iso27001_refs->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("iso27001_refs", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "Iso27001RefsGrid.php" ?>
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
