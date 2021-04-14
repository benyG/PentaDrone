<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Cobit5RefsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcobit5_refsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcobit5_refsdelete = currentForm = new ew.Form("fcobit5_refsdelete", "delete");
    loadjs.done("fcobit5_refsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.cobit5_refs) ew.vars.tables.cobit5_refs = <?= JsonEncode(GetClientVar("tables", "cobit5_refs")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcobit5_refsdelete" id="fcobit5_refsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cobit5_refs">
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
<?php if ($Page->NIdentifier->Visible) { // NIdentifier ?>
        <th class="<?= $Page->NIdentifier->headerCellClass() ?>"><span id="elh_cobit5_refs_NIdentifier" class="cobit5_refs_NIdentifier"><?= $Page->NIdentifier->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_cobit5_refs_name" class="cobit5_refs_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th class="<?= $Page->description->headerCellClass() ?>"><span id="elh_cobit5_refs_description" class="cobit5_refs_description"><?= $Page->description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->code_cobitfamily->Visible) { // code_cobitfamily ?>
        <th class="<?= $Page->code_cobitfamily->headerCellClass() ?>"><span id="elh_cobit5_refs_code_cobitfamily" class="cobit5_refs_code_cobitfamily"><?= $Page->code_cobitfamily->caption() ?></span></th>
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
<?php if ($Page->NIdentifier->Visible) { // NIdentifier ?>
        <td <?= $Page->NIdentifier->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cobit5_refs_NIdentifier" class="cobit5_refs_NIdentifier">
<span<?= $Page->NIdentifier->viewAttributes() ?>>
<?= $Page->NIdentifier->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cobit5_refs_name" class="cobit5_refs_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <td <?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cobit5_refs_description" class="cobit5_refs_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->code_cobitfamily->Visible) { // code_cobitfamily ?>
        <td <?= $Page->code_cobitfamily->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cobit5_refs_code_cobitfamily" class="cobit5_refs_code_cobitfamily">
<span<?= $Page->code_cobitfamily->viewAttributes() ?>>
<?= $Page->code_cobitfamily->getViewValue() ?></span>
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
