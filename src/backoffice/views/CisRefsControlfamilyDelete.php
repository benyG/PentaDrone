<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$CisRefsControlfamilyDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcis_refs_controlfamilydelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcis_refs_controlfamilydelete = currentForm = new ew.Form("fcis_refs_controlfamilydelete", "delete");
    loadjs.done("fcis_refs_controlfamilydelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.cis_refs_controlfamily) ew.vars.tables.cis_refs_controlfamily = <?= JsonEncode(GetClientVar("tables", "cis_refs_controlfamily")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcis_refs_controlfamilydelete" id="fcis_refs_controlfamilydelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cis_refs_controlfamily">
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
        <th class="<?= $Page->code->headerCellClass() ?>"><span id="elh_cis_refs_controlfamily_code" class="cis_refs_controlfamily_code"><?= $Page->code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->control_familyName->Visible) { // control_familyName ?>
        <th class="<?= $Page->control_familyName->headerCellClass() ?>"><span id="elh_cis_refs_controlfamily_control_familyName" class="cis_refs_controlfamily_control_familyName"><?= $Page->control_familyName->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_cis_refs_controlfamily_code" class="cis_refs_controlfamily_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->control_familyName->Visible) { // control_familyName ?>
        <td <?= $Page->control_familyName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_controlfamily_control_familyName" class="cis_refs_controlfamily_control_familyName">
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