<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$RiskRegistersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var frisk_registersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    frisk_registersview = currentForm = new ew.Form("frisk_registersview", "view");
    loadjs.done("frisk_registersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.risk_registers) ew.vars.tables.risk_registers = <?= JsonEncode(GetClientVar("tables", "risk_registers")) ?>;
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
<form name="frisk_registersview" id="frisk_registersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_registers">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_risk_registers_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->risk->Visible) { // risk ?>
    <tr id="r_risk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_risk"><?= $Page->risk->caption() ?></span></td>
        <td data-name="risk" <?= $Page->risk->cellAttributes() ?>>
<span id="el_risk_registers_risk">
<span<?= $Page->risk->viewAttributes() ?>>
<?= $Page->risk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_risk_registers_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_risk_registers_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vulnerability->Visible) { // vulnerability ?>
    <tr id="r_vulnerability">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_vulnerability"><?= $Page->vulnerability->caption() ?></span></td>
        <td data-name="vulnerability" <?= $Page->vulnerability->cellAttributes() ?>>
<span id="el_risk_registers_vulnerability">
<span<?= $Page->vulnerability->viewAttributes() ?>>
<?= $Page->vulnerability->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->threat->Visible) { // threat ?>
    <tr id="r_threat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_threat"><?= $Page->threat->caption() ?></span></td>
        <td data-name="threat" <?= $Page->threat->cellAttributes() ?>>
<span id="el_risk_registers_threat">
<span<?= $Page->threat->viewAttributes() ?>>
<?= $Page->threat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->layer_code->Visible) { // layer_code ?>
    <tr id="r_layer_code">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_layer_code"><?= $Page->layer_code->caption() ?></span></td>
        <td data-name="layer_code" <?= $Page->layer_code->cellAttributes() ?>>
<span id="el_risk_registers_layer_code">
<span<?= $Page->layer_code->viewAttributes() ?>>
<?= $Page->layer_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->exposure_factor_EF->Visible) { // exposure_factor_EF ?>
    <tr id="r_exposure_factor_EF">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_exposure_factor_EF"><?= $Page->exposure_factor_EF->caption() ?></span></td>
        <td data-name="exposure_factor_EF" <?= $Page->exposure_factor_EF->cellAttributes() ?>>
<span id="el_risk_registers_exposure_factor_EF">
<span<?= $Page->exposure_factor_EF->viewAttributes() ?>>
<?= $Page->exposure_factor_EF->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset->Visible) { // asset ?>
    <tr id="r_asset">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_registers_asset"><?= $Page->asset->caption() ?></span></td>
        <td data-name="asset" <?= $Page->asset->cellAttributes() ?>>
<span id="el_risk_registers_asset">
<span<?= $Page->asset->viewAttributes() ?>>
<?= $Page->asset->getViewValue() ?></span>
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
