<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionsLibraryDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestions_librarydelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fquestions_librarydelete = currentForm = new ew.Form("fquestions_librarydelete", "delete");
    loadjs.done("fquestions_librarydelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.questions_library) ew.vars.tables.questions_library = <?= JsonEncode(GetClientVar("tables", "questions_library")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fquestions_librarydelete" id="fquestions_librarydelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="questions_library">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_questions_library_id" class="questions_library_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->libelle->Visible) { // libelle ?>
        <th class="<?= $Page->libelle->headerCellClass() ?>"><span id="elh_questions_library_libelle" class="questions_library_libelle"><?= $Page->libelle->caption() ?></span></th>
<?php } ?>
<?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
        <th class="<?= $Page->controlObj_id->headerCellClass() ?>"><span id="elh_questions_library_controlObj_id" class="questions_library_controlObj_id"><?= $Page->controlObj_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->refs1->Visible) { // refs1 ?>
        <th class="<?= $Page->refs1->headerCellClass() ?>"><span id="elh_questions_library_refs1" class="questions_library_refs1"><?= $Page->refs1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->refs2->Visible) { // refs2 ?>
        <th class="<?= $Page->refs2->headerCellClass() ?>"><span id="elh_questions_library_refs2" class="questions_library_refs2"><?= $Page->refs2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Activation_status->Visible) { // Activation_status ?>
        <th class="<?= $Page->Activation_status->headerCellClass() ?>"><span id="elh_questions_library_Activation_status" class="questions_library_Activation_status"><?= $Page->Activation_status->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_questions_library_id" class="questions_library_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->libelle->Visible) { // libelle ?>
        <td <?= $Page->libelle->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_questions_library_libelle" class="questions_library_libelle">
<span<?= $Page->libelle->viewAttributes() ?>>
<?= $Page->libelle->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
        <td <?= $Page->controlObj_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_questions_library_controlObj_id" class="questions_library_controlObj_id">
<span<?= $Page->controlObj_id->viewAttributes() ?>>
<?= $Page->controlObj_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->refs1->Visible) { // refs1 ?>
        <td <?= $Page->refs1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_questions_library_refs1" class="questions_library_refs1">
<span<?= $Page->refs1->viewAttributes() ?>>
<?= $Page->refs1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->refs2->Visible) { // refs2 ?>
        <td <?= $Page->refs2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_questions_library_refs2" class="questions_library_refs2">
<span<?= $Page->refs2->viewAttributes() ?>>
<?= $Page->refs2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Activation_status->Visible) { // Activation_status ?>
        <td <?= $Page->Activation_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_questions_library_Activation_status" class="questions_library_Activation_status">
<span<?= $Page->Activation_status->viewAttributes() ?>>
<?= $Page->Activation_status->getViewValue() ?></span>
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
