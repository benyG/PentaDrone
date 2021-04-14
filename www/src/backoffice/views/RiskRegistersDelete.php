<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$RiskRegistersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var frisk_registersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    frisk_registersdelete = currentForm = new ew.Form("frisk_registersdelete", "delete");
    loadjs.done("frisk_registersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.risk_registers) ew.vars.tables.risk_registers = <?= JsonEncode(GetClientVar("tables", "risk_registers")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="frisk_registersdelete" id="frisk_registersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_registers">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_risk_registers_id" class="risk_registers_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_risk_registers_created_at" class="risk_registers_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_risk_registers_updated_at" class="risk_registers_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vulnerability->Visible) { // vulnerability ?>
        <th class="<?= $Page->vulnerability->headerCellClass() ?>"><span id="elh_risk_registers_vulnerability" class="risk_registers_vulnerability"><?= $Page->vulnerability->caption() ?></span></th>
<?php } ?>
<?php if ($Page->threat->Visible) { // threat ?>
        <th class="<?= $Page->threat->headerCellClass() ?>"><span id="elh_risk_registers_threat" class="risk_registers_threat"><?= $Page->threat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->layer_code->Visible) { // layer_code ?>
        <th class="<?= $Page->layer_code->headerCellClass() ?>"><span id="elh_risk_registers_layer_code" class="risk_registers_layer_code"><?= $Page->layer_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->exposure_factor_EF->Visible) { // exposure_factor_EF ?>
        <th class="<?= $Page->exposure_factor_EF->headerCellClass() ?>"><span id="elh_risk_registers_exposure_factor_EF" class="risk_registers_exposure_factor_EF"><?= $Page->exposure_factor_EF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset->Visible) { // asset ?>
        <th class="<?= $Page->asset->headerCellClass() ?>"><span id="elh_risk_registers_asset" class="risk_registers_asset"><?= $Page->asset->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_id" class="risk_registers_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_created_at" class="risk_registers_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_updated_at" class="risk_registers_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vulnerability->Visible) { // vulnerability ?>
        <td <?= $Page->vulnerability->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_vulnerability" class="risk_registers_vulnerability">
<span<?= $Page->vulnerability->viewAttributes() ?>>
<?= $Page->vulnerability->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->threat->Visible) { // threat ?>
        <td <?= $Page->threat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_threat" class="risk_registers_threat">
<span<?= $Page->threat->viewAttributes() ?>>
<?= $Page->threat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->layer_code->Visible) { // layer_code ?>
        <td <?= $Page->layer_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_layer_code" class="risk_registers_layer_code">
<span<?= $Page->layer_code->viewAttributes() ?>>
<?= $Page->layer_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->exposure_factor_EF->Visible) { // exposure_factor_EF ?>
        <td <?= $Page->exposure_factor_EF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_exposure_factor_EF" class="risk_registers_exposure_factor_EF">
<span<?= $Page->exposure_factor_EF->viewAttributes() ?>>
<?= $Page->exposure_factor_EF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset->Visible) { // asset ?>
        <td <?= $Page->asset->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_registers_asset" class="risk_registers_asset">
<span<?= $Page->asset->viewAttributes() ?>>
<?= $Page->asset->getViewValue() ?></span>
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
