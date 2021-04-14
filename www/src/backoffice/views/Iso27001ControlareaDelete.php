<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001ControlareaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fiso27001_controlareadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fiso27001_controlareadelete = currentForm = new ew.Form("fiso27001_controlareadelete", "delete");
    loadjs.done("fiso27001_controlareadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.iso27001_controlarea) ew.vars.tables.iso27001_controlarea = <?= JsonEncode(GetClientVar("tables", "iso27001_controlarea")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fiso27001_controlareadelete" id="fiso27001_controlareadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_controlarea">
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
<?php if ($Page->control_area->Visible) { // control_area ?>
        <th class="<?= $Page->control_area->headerCellClass() ?>"><span id="elh_iso27001_controlarea_control_area" class="iso27001_controlarea_control_area"><?= $Page->control_area->caption() ?></span></th>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <th class="<?= $Page->code->headerCellClass() ?>"><span id="elh_iso27001_controlarea_code" class="iso27001_controlarea_code"><?= $Page->code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ordre->Visible) { // ordre ?>
        <th class="<?= $Page->ordre->headerCellClass() ?>"><span id="elh_iso27001_controlarea_ordre" class="iso27001_controlarea_ordre"><?= $Page->ordre->caption() ?></span></th>
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
<?php if ($Page->control_area->Visible) { // control_area ?>
        <td <?= $Page->control_area->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_iso27001_controlarea_control_area" class="iso27001_controlarea_control_area">
<span<?= $Page->control_area->viewAttributes() ?>>
<?= $Page->control_area->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <td <?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_iso27001_controlarea_code" class="iso27001_controlarea_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ordre->Visible) { // ordre ?>
        <td <?= $Page->ordre->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_iso27001_controlarea_ordre" class="iso27001_controlarea_ordre">
<span<?= $Page->ordre->viewAttributes() ?>>
<?= $Page->ordre->getViewValue() ?></span>
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
