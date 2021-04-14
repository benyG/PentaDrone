<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionControlobjectivesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestion_controlobjectivesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fquestion_controlobjectivesdelete = currentForm = new ew.Form("fquestion_controlobjectivesdelete", "delete");
    loadjs.done("fquestion_controlobjectivesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.question_controlobjectives) ew.vars.tables.question_controlobjectives = <?= JsonEncode(GetClientVar("tables", "question_controlobjectives")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fquestion_controlobjectivesdelete" id="fquestion_controlobjectivesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_controlobjectives">
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
<?php if ($Page->num_ordre->Visible) { // num_ordre ?>
        <th class="<?= $Page->num_ordre->headerCellClass() ?>"><span id="elh_question_controlobjectives_num_ordre" class="question_controlobjectives_num_ordre"><?= $Page->num_ordre->caption() ?></span></th>
<?php } ?>
<?php if ($Page->controlObj_name->Visible) { // controlObj_name ?>
        <th class="<?= $Page->controlObj_name->headerCellClass() ?>"><span id="elh_question_controlobjectives_controlObj_name" class="question_controlobjectives_controlObj_name"><?= $Page->controlObj_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->question_domain_id->Visible) { // question_domain_id ?>
        <th class="<?= $Page->question_domain_id->headerCellClass() ?>"><span id="elh_question_controlobjectives_question_domain_id" class="question_controlobjectives_question_domain_id"><?= $Page->question_domain_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->layer_id->Visible) { // layer_id ?>
        <th class="<?= $Page->layer_id->headerCellClass() ?>"><span id="elh_question_controlobjectives_layer_id" class="question_controlobjectives_layer_id"><?= $Page->layer_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
        <th class="<?= $Page->function_csf->headerCellClass() ?>"><span id="elh_question_controlobjectives_function_csf" class="question_controlobjectives_function_csf"><?= $Page->function_csf->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_question_controlobjectives_created_at" class="question_controlobjectives_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_question_controlobjectives_updated_at" class="question_controlobjectives_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<?php if ($Page->num_ordre->Visible) { // num_ordre ?>
        <td <?= $Page->num_ordre->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_num_ordre" class="question_controlobjectives_num_ordre">
<span<?= $Page->num_ordre->viewAttributes() ?>>
<?= $Page->num_ordre->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->controlObj_name->Visible) { // controlObj_name ?>
        <td <?= $Page->controlObj_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_controlObj_name" class="question_controlobjectives_controlObj_name">
<span<?= $Page->controlObj_name->viewAttributes() ?>>
<?= $Page->controlObj_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->question_domain_id->Visible) { // question_domain_id ?>
        <td <?= $Page->question_domain_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_question_domain_id" class="question_controlobjectives_question_domain_id">
<span<?= $Page->question_domain_id->viewAttributes() ?>>
<?= $Page->question_domain_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->layer_id->Visible) { // layer_id ?>
        <td <?= $Page->layer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_layer_id" class="question_controlobjectives_layer_id">
<span<?= $Page->layer_id->viewAttributes() ?>>
<?= $Page->layer_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
        <td <?= $Page->function_csf->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_function_csf" class="question_controlobjectives_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<?= $Page->function_csf->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_created_at" class="question_controlobjectives_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_updated_at" class="question_controlobjectives_updated_at">
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
