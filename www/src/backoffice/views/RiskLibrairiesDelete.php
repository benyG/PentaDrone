<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$RiskLibrairiesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var frisk_librairiesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    frisk_librairiesdelete = currentForm = new ew.Form("frisk_librairiesdelete", "delete");
    loadjs.done("frisk_librairiesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.risk_librairies) ew.vars.tables.risk_librairies = <?= JsonEncode(GetClientVar("tables", "risk_librairies")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="frisk_librairiesdelete" id="frisk_librairiesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_librairies">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_risk_librairies_id" class="risk_librairies_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <th class="<?= $Page->title->headerCellClass() ?>"><span id="elh_risk_librairies_title" class="risk_librairies_title"><?= $Page->title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->layer->Visible) { // layer ?>
        <th class="<?= $Page->layer->headerCellClass() ?>"><span id="elh_risk_librairies_layer" class="risk_librairies_layer"><?= $Page->layer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
        <th class="<?= $Page->function_csf->headerCellClass() ?>"><span id="elh_risk_librairies_function_csf" class="risk_librairies_function_csf"><?= $Page->function_csf->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
        <th class="<?= $Page->tag->headerCellClass() ?>"><span id="elh_risk_librairies_tag" class="risk_librairies_tag"><?= $Page->tag->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <th class="<?= $Page->Confidentiality->headerCellClass() ?>"><span id="elh_risk_librairies_Confidentiality" class="risk_librairies_Confidentiality"><?= $Page->Confidentiality->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
        <th class="<?= $Page->Integrity->headerCellClass() ?>"><span id="elh_risk_librairies_Integrity" class="risk_librairies_Integrity"><?= $Page->Integrity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
        <th class="<?= $Page->Availability->headerCellClass() ?>"><span id="elh_risk_librairies_Availability" class="risk_librairies_Availability"><?= $Page->Availability->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <th class="<?= $Page->Efficiency->headerCellClass() ?>"><span id="elh_risk_librairies_Efficiency" class="risk_librairies_Efficiency"><?= $Page->Efficiency->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_risk_librairies_id" class="risk_librairies_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <td <?= $Page->title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_title" class="risk_librairies_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->layer->Visible) { // layer ?>
        <td <?= $Page->layer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_layer" class="risk_librairies_layer">
<span<?= $Page->layer->viewAttributes() ?>>
<?= $Page->layer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
        <td <?= $Page->function_csf->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_function_csf" class="risk_librairies_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<?= $Page->function_csf->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
        <td <?= $Page->tag->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_tag" class="risk_librairies_tag">
<span<?= $Page->tag->viewAttributes() ?>>
<?= $Page->tag->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <td <?= $Page->Confidentiality->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Confidentiality" class="risk_librairies_Confidentiality">
<span<?= $Page->Confidentiality->viewAttributes() ?>>
<?= $Page->Confidentiality->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
        <td <?= $Page->Integrity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Integrity" class="risk_librairies_Integrity">
<span<?= $Page->Integrity->viewAttributes() ?>>
<?= $Page->Integrity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
        <td <?= $Page->Availability->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Availability" class="risk_librairies_Availability">
<span<?= $Page->Availability->viewAttributes() ?>>
<?= $Page->Availability->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <td <?= $Page->Efficiency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Efficiency" class="risk_librairies_Efficiency">
<span<?= $Page->Efficiency->viewAttributes() ?>>
<?= $Page->Efficiency->getViewValue() ?></span>
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
