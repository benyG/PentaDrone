<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistToIso27001View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnist_to_iso27001view;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnist_to_iso27001view = currentForm = new ew.Form("fnist_to_iso27001view", "view");
    loadjs.done("fnist_to_iso27001view");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.nist_to_iso27001) ew.vars.tables.nist_to_iso27001 = <?= JsonEncode(GetClientVar("tables", "nist_to_iso27001")) ?>;
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
<form name="fnist_to_iso27001view" id="fnist_to_iso27001view" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_to_iso27001">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_to_iso27001_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_nist_to_iso27001_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nistrefs_family->Visible) { // nistrefs_family ?>
    <tr id="r_nistrefs_family">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_to_iso27001_nistrefs_family"><?= $Page->nistrefs_family->caption() ?></span></td>
        <td data-name="nistrefs_family" <?= $Page->nistrefs_family->cellAttributes() ?>>
<span id="el_nist_to_iso27001_nistrefs_family">
<span<?= $Page->nistrefs_family->viewAttributes() ?>>
<?= $Page->nistrefs_family->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isorefs->Visible) { // isorefs ?>
    <tr id="r_isorefs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_to_iso27001_isorefs"><?= $Page->isorefs->caption() ?></span></td>
        <td data-name="isorefs" <?= $Page->isorefs->cellAttributes() ?>>
<span id="el_nist_to_iso27001_isorefs">
<span<?= $Page->isorefs->viewAttributes() ?>>
<?= $Page->isorefs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_to_iso27001_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_nist_to_iso27001_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_to_iso27001_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_nist_to_iso27001_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->just_for_question_link->Visible) { // just_for_question_link ?>
    <tr id="r_just_for_question_link">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_to_iso27001_just_for_question_link"><?= $Page->just_for_question_link->caption() ?></span></td>
        <td data-name="just_for_question_link" <?= $Page->just_for_question_link->cellAttributes() ?>>
<span id="el_nist_to_iso27001_just_for_question_link">
<span<?= $Page->just_for_question_link->viewAttributes() ?>>
<?= $Page->just_for_question_link->getViewValue() ?></span>
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
