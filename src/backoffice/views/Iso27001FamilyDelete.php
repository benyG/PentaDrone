<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001FamilyDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fiso27001_familydelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fiso27001_familydelete = currentForm = new ew.Form("fiso27001_familydelete", "delete");
    loadjs.done("fiso27001_familydelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.iso27001_family) ew.vars.tables.iso27001_family = <?= JsonEncode(GetClientVar("tables", "iso27001_family")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fiso27001_familydelete" id="fiso27001_familydelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_family">
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
<?php if ($Page->code->Visible) { // code ?>
        <th class="<?= $Page->code->headerCellClass() ?>"><span id="elh_iso27001_family_code" class="iso27001_family_code"><?= $Page->code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->control_area_id->Visible) { // control_area_id ?>
        <th class="<?= $Page->control_area_id->headerCellClass() ?>"><span id="elh_iso27001_family_control_area_id" class="iso27001_family_control_area_id"><?= $Page->control_area_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->control_familyName->Visible) { // control_familyName ?>
        <th class="<?= $Page->control_familyName->headerCellClass() ?>"><span id="elh_iso27001_family_control_familyName" class="iso27001_family_control_familyName"><?= $Page->control_familyName->caption() ?></span></th>
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
<?php if ($Page->code->Visible) { // code ?>
        <td <?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_iso27001_family_code" class="iso27001_family_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->control_area_id->Visible) { // control_area_id ?>
        <td <?= $Page->control_area_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_iso27001_family_control_area_id" class="iso27001_family_control_area_id">
<span<?= $Page->control_area_id->viewAttributes() ?>>
<?= $Page->control_area_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->control_familyName->Visible) { // control_familyName ?>
        <td <?= $Page->control_familyName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_iso27001_family_control_familyName" class="iso27001_family_control_familyName">
<span<?= $Page->control_familyName->viewAttributes() ?>>
<?= $Page->control_familyName->getViewValue() ?></span>
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
