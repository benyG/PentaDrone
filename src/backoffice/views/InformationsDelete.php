<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$InformationsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var finformationsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    finformationsdelete = currentForm = new ew.Form("finformationsdelete", "delete");
    loadjs.done("finformationsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.informations) ew.vars.tables.informations = <?= JsonEncode(GetClientVar("tables", "informations")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="finformationsdelete" id="finformationsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="informations">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_informations_id" class="informations_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->people_id->Visible) { // people_id ?>
        <th class="<?= $Page->people_id->headerCellClass() ?>"><span id="elh_informations_people_id" class="informations_people_id"><?= $Page->people_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_value->Visible) { // asset_value ?>
        <th class="<?= $Page->asset_value->headerCellClass() ?>"><span id="elh_informations_asset_value" class="informations_asset_value"><?= $Page->asset_value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->business_value->Visible) { // business_value ?>
        <th class="<?= $Page->business_value->headerCellClass() ?>"><span id="elh_informations_business_value" class="informations_business_value"><?= $Page->business_value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->criticality_points->Visible) { // criticality_points ?>
        <th class="<?= $Page->criticality_points->headerCellClass() ?>"><span id="elh_informations_criticality_points" class="informations_criticality_points"><?= $Page->criticality_points->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_informations_created_at" class="informations_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_informations_updated_at" class="informations_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_informations_id" class="informations_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->people_id->Visible) { // people_id ?>
        <td <?= $Page->people_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_informations_people_id" class="informations_people_id">
<span<?= $Page->people_id->viewAttributes() ?>>
<?= $Page->people_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_value->Visible) { // asset_value ?>
        <td <?= $Page->asset_value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_informations_asset_value" class="informations_asset_value">
<span<?= $Page->asset_value->viewAttributes() ?>>
<?= $Page->asset_value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->business_value->Visible) { // business_value ?>
        <td <?= $Page->business_value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_informations_business_value" class="informations_business_value">
<span<?= $Page->business_value->viewAttributes() ?>>
<?= $Page->business_value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->criticality_points->Visible) { // criticality_points ?>
        <td <?= $Page->criticality_points->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_informations_criticality_points" class="informations_criticality_points">
<span<?= $Page->criticality_points->viewAttributes() ?>>
<?= $Page->criticality_points->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_informations_created_at" class="informations_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_informations_updated_at" class="informations_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
