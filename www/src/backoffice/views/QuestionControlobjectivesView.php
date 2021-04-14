<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionControlobjectivesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestion_controlobjectivesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fquestion_controlobjectivesview = currentForm = new ew.Form("fquestion_controlobjectivesview", "view");
    loadjs.done("fquestion_controlobjectivesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.question_controlobjectives) ew.vars.tables.question_controlobjectives = <?= JsonEncode(GetClientVar("tables", "question_controlobjectives")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fquestion_controlobjectivesview" id="fquestion_controlobjectivesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_controlobjectives">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->num_ordre->Visible) { // num_ordre ?>
    <tr id="r_num_ordre">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_controlobjectives_num_ordre"><?= $Page->num_ordre->caption() ?></span></td>
        <td data-name="num_ordre" <?= $Page->num_ordre->cellAttributes() ?>>
<span id="el_question_controlobjectives_num_ordre">
<span<?= $Page->num_ordre->viewAttributes() ?>>
<?= $Page->num_ordre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->controlObj_name->Visible) { // controlObj_name ?>
    <tr id="r_controlObj_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_controlobjectives_controlObj_name"><?= $Page->controlObj_name->caption() ?></span></td>
        <td data-name="controlObj_name" <?= $Page->controlObj_name->cellAttributes() ?>>
<span id="el_question_controlobjectives_controlObj_name">
<span<?= $Page->controlObj_name->viewAttributes() ?>>
<?= $Page->controlObj_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->question_domain_id->Visible) { // question_domain_id ?>
    <tr id="r_question_domain_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_controlobjectives_question_domain_id"><?= $Page->question_domain_id->caption() ?></span></td>
        <td data-name="question_domain_id" <?= $Page->question_domain_id->cellAttributes() ?>>
<span id="el_question_controlobjectives_question_domain_id">
<span<?= $Page->question_domain_id->viewAttributes() ?>>
<?= $Page->question_domain_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->layer_id->Visible) { // layer_id ?>
    <tr id="r_layer_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_controlobjectives_layer_id"><?= $Page->layer_id->caption() ?></span></td>
        <td data-name="layer_id" <?= $Page->layer_id->cellAttributes() ?>>
<span id="el_question_controlobjectives_layer_id">
<span<?= $Page->layer_id->viewAttributes() ?>>
<?= $Page->layer_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
    <tr id="r_function_csf">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_controlobjectives_function_csf"><?= $Page->function_csf->caption() ?></span></td>
        <td data-name="function_csf" <?= $Page->function_csf->cellAttributes() ?>>
<span id="el_question_controlobjectives_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<?= $Page->function_csf->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_controlobjectives_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_question_controlobjectives_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_controlobjectives_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_question_controlobjectives_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
<?php
    if (in_array("questions_library", explode(",", $Page->getCurrentDetailTable())) && $questions_library->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("questions_library", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "QuestionsLibraryGrid.php" ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
