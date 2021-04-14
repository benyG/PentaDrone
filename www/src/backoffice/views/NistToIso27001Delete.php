<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistToIso27001Delete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnist_to_iso27001delete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnist_to_iso27001delete = currentForm = new ew.Form("fnist_to_iso27001delete", "delete");
    loadjs.done("fnist_to_iso27001delete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.nist_to_iso27001) ew.vars.tables.nist_to_iso27001 = <?= JsonEncode(GetClientVar("tables", "nist_to_iso27001")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnist_to_iso27001delete" id="fnist_to_iso27001delete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_to_iso27001">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_nist_to_iso27001_id" class="nist_to_iso27001_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nistrefs_family->Visible) { // nistrefs_family ?>
        <th class="<?= $Page->nistrefs_family->headerCellClass() ?>"><span id="elh_nist_to_iso27001_nistrefs_family" class="nist_to_iso27001_nistrefs_family"><?= $Page->nistrefs_family->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isorefs->Visible) { // isorefs ?>
        <th class="<?= $Page->isorefs->headerCellClass() ?>"><span id="elh_nist_to_iso27001_isorefs" class="nist_to_iso27001_isorefs"><?= $Page->isorefs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->just_for_question_link->Visible) { // just_for_question_link ?>
        <th class="<?= $Page->just_for_question_link->headerCellClass() ?>"><span id="elh_nist_to_iso27001_just_for_question_link" class="nist_to_iso27001_just_for_question_link"><?= $Page->just_for_question_link->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_nist_to_iso27001_id" class="nist_to_iso27001_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nistrefs_family->Visible) { // nistrefs_family ?>
        <td <?= $Page->nistrefs_family->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_nist_to_iso27001_nistrefs_family" class="nist_to_iso27001_nistrefs_family">
<span<?= $Page->nistrefs_family->viewAttributes() ?>>
<?= $Page->nistrefs_family->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isorefs->Visible) { // isorefs ?>
        <td <?= $Page->isorefs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_nist_to_iso27001_isorefs" class="nist_to_iso27001_isorefs">
<span<?= $Page->isorefs->viewAttributes() ?>>
<?= $Page->isorefs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->just_for_question_link->Visible) { // just_for_question_link ?>
        <td <?= $Page->just_for_question_link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_nist_to_iso27001_just_for_question_link" class="nist_to_iso27001_just_for_question_link">
<span<?= $Page->just_for_question_link->viewAttributes() ?>>
<?= $Page->just_for_question_link->getViewValue() ?></span>
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
