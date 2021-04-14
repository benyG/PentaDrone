<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionTargetProfilesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestion_target_profilesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fquestion_target_profilesdelete = currentForm = new ew.Form("fquestion_target_profilesdelete", "delete");
    loadjs.done("fquestion_target_profilesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.question_target_profiles) ew.vars.tables.question_target_profiles = <?= JsonEncode(GetClientVar("tables", "question_target_profiles")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fquestion_target_profilesdelete" id="fquestion_target_profilesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_target_profiles">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_question_target_profiles_id" class="question_target_profiles_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->control_first->Visible) { // control_first ?>
        <th class="<?= $Page->control_first->headerCellClass() ?>"><span id="elh_question_target_profiles_control_first" class="question_target_profiles_control_first"><?= $Page->control_first->caption() ?></span></th>
<?php } ?>
<?php if ($Page->control_second->Visible) { // control_second ?>
        <th class="<?= $Page->control_second->headerCellClass() ?>"><span id="elh_question_target_profiles_control_second" class="question_target_profiles_control_second"><?= $Page->control_second->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_question_target_profiles_created_at" class="question_target_profiles_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_question_target_profiles_updated_at" class="question_target_profiles_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_question_target_profiles_id" class="question_target_profiles_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->control_first->Visible) { // control_first ?>
        <td <?= $Page->control_first->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_target_profiles_control_first" class="question_target_profiles_control_first">
<span<?= $Page->control_first->viewAttributes() ?>>
<?= $Page->control_first->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->control_second->Visible) { // control_second ?>
        <td <?= $Page->control_second->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_target_profiles_control_second" class="question_target_profiles_control_second">
<span<?= $Page->control_second->viewAttributes() ?>>
<?= $Page->control_second->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_target_profiles_created_at" class="question_target_profiles_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_target_profiles_updated_at" class="question_target_profiles_updated_at">
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
