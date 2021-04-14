<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001ControlareaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fiso27001_controlareaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fiso27001_controlareaview = currentForm = new ew.Form("fiso27001_controlareaview", "view");
    loadjs.done("fiso27001_controlareaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.iso27001_controlarea) ew.vars.tables.iso27001_controlarea = <?= JsonEncode(GetClientVar("tables", "iso27001_controlarea")) ?>;
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
<form name="fiso27001_controlareaview" id="fiso27001_controlareaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_controlarea">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->control_area->Visible) { // control_area ?>
    <tr id="r_control_area">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_controlarea_control_area"><?= $Page->control_area->caption() ?></span></td>
        <td data-name="control_area" <?= $Page->control_area->cellAttributes() ?>>
<span id="el_iso27001_controlarea_control_area">
<span<?= $Page->control_area->viewAttributes() ?>>
<?= $Page->control_area->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <tr id="r_code">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_controlarea_code"><?= $Page->code->caption() ?></span></td>
        <td data-name="code" <?= $Page->code->cellAttributes() ?>>
<span id="el_iso27001_controlarea_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ordre->Visible) { // ordre ?>
    <tr id="r_ordre">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_iso27001_controlarea_ordre"><?= $Page->ordre->caption() ?></span></td>
        <td data-name="ordre" <?= $Page->ordre->cellAttributes() ?>>
<span id="el_iso27001_controlarea_ordre">
<span<?= $Page->ordre->viewAttributes() ?>>
<?= $Page->ordre->getViewValue() ?></span>
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
    if (in_array("iso27001_family", explode(",", $Page->getCurrentDetailTable())) && $iso27001_family->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("iso27001_family", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "Iso27001FamilyGrid.php" ?>
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
