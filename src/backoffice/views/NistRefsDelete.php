<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistRefsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnist_refsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnist_refsdelete = currentForm = new ew.Form("fnist_refsdelete", "delete");
    loadjs.done("fnist_refsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.nist_refs) ew.vars.tables.nist_refs = <?= JsonEncode(GetClientVar("tables", "nist_refs")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnist_refsdelete" id="fnist_refsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_refs">
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
        <th class="<?= $Page->Nidentifier->headerCellClass() ?>"><span id="elh_nist_refs_Nidentifier" class="nist_refs_Nidentifier"><?= $Page->Nidentifier->caption() ?></span></th>
<?php } ?>
<?php if ($Page->N_ordre->Visible) { // N_ordre ?>
        <th class="<?= $Page->N_ordre->headerCellClass() ?>"><span id="elh_nist_refs_N_ordre" class="nist_refs_N_ordre"><?= $Page->N_ordre->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <th class="<?= $Page->Control_Family_id->headerCellClass() ?>"><span id="elh_nist_refs_Control_Family_id" class="nist_refs_Control_Family_id"><?= $Page->Control_Family_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Control_Name->Visible) { // Control_Name ?>
        <th class="<?= $Page->Control_Name->headerCellClass() ?>"><span id="elh_nist_refs_Control_Name" class="nist_refs_Control_Name"><?= $Page->Control_Name->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_nist_refs_Nidentifier" class="nist_refs_Nidentifier">
<span<?= $Page->Nidentifier->viewAttributes() ?>>
<?= $Page->Nidentifier->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->N_ordre->Visible) { // N_ordre ?>
        <td <?= $Page->N_ordre->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_nist_refs_N_ordre" class="nist_refs_N_ordre">
<span<?= $Page->N_ordre->viewAttributes() ?>>
<?= $Page->N_ordre->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <td <?= $Page->Control_Family_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Family_id" class="nist_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<?= $Page->Control_Family_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Control_Name->Visible) { // Control_Name ?>
        <td <?= $Page->Control_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Name" class="nist_refs_Control_Name">
<span<?= $Page->Control_Name->viewAttributes() ?>>
<?= $Page->Control_Name->getViewValue() ?></span>
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
