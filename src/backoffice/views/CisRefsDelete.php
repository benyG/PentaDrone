<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$CisRefsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcis_refsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcis_refsdelete = currentForm = new ew.Form("fcis_refsdelete", "delete");
    loadjs.done("fcis_refsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.cis_refs) ew.vars.tables.cis_refs = <?= JsonEncode(GetClientVar("tables", "cis_refs")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcis_refsdelete" id="fcis_refsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cis_refs">
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
<?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
        <th class="<?= $Page->Nidentifier->headerCellClass() ?>"><span id="elh_cis_refs_Nidentifier" class="cis_refs_Nidentifier"><?= $Page->Nidentifier->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <th class="<?= $Page->Control_Family_id->headerCellClass() ?>"><span id="elh_cis_refs_Control_Family_id" class="cis_refs_Control_Family_id"><?= $Page->Control_Family_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->control_Name->Visible) { // control_Name ?>
        <th class="<?= $Page->control_Name->headerCellClass() ?>"><span id="elh_cis_refs_control_Name" class="cis_refs_control_Name"><?= $Page->control_Name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impl_group1->Visible) { // impl_group1 ?>
        <th class="<?= $Page->impl_group1->headerCellClass() ?>"><span id="elh_cis_refs_impl_group1" class="cis_refs_impl_group1"><?= $Page->impl_group1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impl_group2->Visible) { // impl_group2 ?>
        <th class="<?= $Page->impl_group2->headerCellClass() ?>"><span id="elh_cis_refs_impl_group2" class="cis_refs_impl_group2"><?= $Page->impl_group2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impl_group3->Visible) { // impl_group3 ?>
        <th class="<?= $Page->impl_group3->headerCellClass() ?>"><span id="elh_cis_refs_impl_group3" class="cis_refs_impl_group3"><?= $Page->impl_group3->caption() ?></span></th>
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
<?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
        <td <?= $Page->Nidentifier->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_Nidentifier" class="cis_refs_Nidentifier">
<span<?= $Page->Nidentifier->viewAttributes() ?>>
<?= $Page->Nidentifier->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <td <?= $Page->Control_Family_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_Control_Family_id" class="cis_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<?= $Page->Control_Family_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->control_Name->Visible) { // control_Name ?>
        <td <?= $Page->control_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_control_Name" class="cis_refs_control_Name">
<span<?= $Page->control_Name->viewAttributes() ?>>
<?= $Page->control_Name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impl_group1->Visible) { // impl_group1 ?>
        <td <?= $Page->impl_group1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_impl_group1" class="cis_refs_impl_group1">
<span<?= $Page->impl_group1->viewAttributes() ?>>
<?= $Page->impl_group1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impl_group2->Visible) { // impl_group2 ?>
        <td <?= $Page->impl_group2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_impl_group2" class="cis_refs_impl_group2">
<span<?= $Page->impl_group2->viewAttributes() ?>>
<?= $Page->impl_group2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impl_group3->Visible) { // impl_group3 ?>
        <td <?= $Page->impl_group3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_impl_group3" class="cis_refs_impl_group3">
<span<?= $Page->impl_group3->viewAttributes() ?>>
<?= $Page->impl_group3->getViewValue() ?></span>
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
