<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$ThreatsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fthreatsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fthreatsdelete = currentForm = new ew.Form("fthreatsdelete", "delete");
    loadjs.done("fthreatsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.threats) ew.vars.tables.threats = <?= JsonEncode(GetClientVar("tables", "threats")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fthreatsdelete" id="fthreatsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="threats">
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
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_threats_name" class="threats_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <th class="<?= $Page->Confidentiality->headerCellClass() ?>"><span id="elh_threats_Confidentiality" class="threats_Confidentiality"><?= $Page->Confidentiality->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
        <th class="<?= $Page->Integrity->headerCellClass() ?>"><span id="elh_threats_Integrity" class="threats_Integrity"><?= $Page->Integrity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
        <th class="<?= $Page->Availability->headerCellClass() ?>"><span id="elh_threats_Availability" class="threats_Availability"><?= $Page->Availability->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <th class="<?= $Page->Efficiency->headerCellClass() ?>"><span id="elh_threats_Efficiency" class="threats_Efficiency"><?= $Page->Efficiency->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_threats_created_at" class="threats_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_threats_updated_at" class="threats_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_threats_name" class="threats_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <td <?= $Page->Confidentiality->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_threats_Confidentiality" class="threats_Confidentiality">
<span<?= $Page->Confidentiality->viewAttributes() ?>>
<?= $Page->Confidentiality->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
        <td <?= $Page->Integrity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_threats_Integrity" class="threats_Integrity">
<span<?= $Page->Integrity->viewAttributes() ?>>
<?= $Page->Integrity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
        <td <?= $Page->Availability->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_threats_Availability" class="threats_Availability">
<span<?= $Page->Availability->viewAttributes() ?>>
<?= $Page->Availability->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <td <?= $Page->Efficiency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_threats_Efficiency" class="threats_Efficiency">
<span<?= $Page->Efficiency->viewAttributes() ?>>
<?= $Page->Efficiency->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_threats_created_at" class="threats_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_threats_updated_at" class="threats_updated_at">
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
