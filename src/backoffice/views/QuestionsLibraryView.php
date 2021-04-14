<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionsLibraryView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestions_libraryview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fquestions_libraryview = currentForm = new ew.Form("fquestions_libraryview", "view");
    loadjs.done("fquestions_libraryview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.questions_library) ew.vars.tables.questions_library = <?= JsonEncode(GetClientVar("tables", "questions_library")) ?>;
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
<form name="fquestions_libraryview" id="fquestions_libraryview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="questions_library">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_questions_library_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->libelle->Visible) { // libelle ?>
    <tr id="r_libelle">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_libelle"><?= $Page->libelle->caption() ?></span></td>
        <td data-name="libelle" <?= $Page->libelle->cellAttributes() ?>>
<span id="el_questions_library_libelle">
<span<?= $Page->libelle->viewAttributes() ?>>
<?= $Page->libelle->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Evidence_to_request->Visible) { // Evidence_to_request ?>
    <tr id="r_Evidence_to_request">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_Evidence_to_request"><?= $Page->Evidence_to_request->caption() ?></span></td>
        <td data-name="Evidence_to_request" <?= $Page->Evidence_to_request->cellAttributes() ?>>
<span id="el_questions_library_Evidence_to_request">
<span<?= $Page->Evidence_to_request->viewAttributes() ?>>
<?= $Page->Evidence_to_request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
    <tr id="r_controlObj_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_controlObj_id"><?= $Page->controlObj_id->caption() ?></span></td>
        <td data-name="controlObj_id" <?= $Page->controlObj_id->cellAttributes() ?>>
<span id="el_questions_library_controlObj_id">
<span<?= $Page->controlObj_id->viewAttributes() ?>>
<?= $Page->controlObj_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_questions_library_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_questions_library_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->refs1->Visible) { // refs1 ?>
    <tr id="r_refs1">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_refs1"><?= $Page->refs1->caption() ?></span></td>
        <td data-name="refs1" <?= $Page->refs1->cellAttributes() ?>>
<span id="el_questions_library_refs1">
<span<?= $Page->refs1->viewAttributes() ?>>
<?= $Page->refs1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->refs2->Visible) { // refs2 ?>
    <tr id="r_refs2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_refs2"><?= $Page->refs2->caption() ?></span></td>
        <td data-name="refs2" <?= $Page->refs2->cellAttributes() ?>>
<span id="el_questions_library_refs2">
<span<?= $Page->refs2->viewAttributes() ?>>
<?= $Page->refs2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Activation_status->Visible) { // Activation_status ?>
    <tr id="r_Activation_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_questions_library_Activation_status"><?= $Page->Activation_status->caption() ?></span></td>
        <td data-name="Activation_status" <?= $Page->Activation_status->cellAttributes() ?>>
<span id="el_questions_library_Activation_status">
<span<?= $Page->Activation_status->viewAttributes() ?>>
<?= $Page->Activation_status->getViewValue() ?></span>
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
