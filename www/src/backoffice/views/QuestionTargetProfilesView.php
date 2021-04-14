<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionTargetProfilesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestion_target_profilesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fquestion_target_profilesview = currentForm = new ew.Form("fquestion_target_profilesview", "view");
    loadjs.done("fquestion_target_profilesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.question_target_profiles) ew.vars.tables.question_target_profiles = <?= JsonEncode(GetClientVar("tables", "question_target_profiles")) ?>;
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
<form name="fquestion_target_profilesview" id="fquestion_target_profilesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_target_profiles">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_target_profiles_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_question_target_profiles_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->libelle->Visible) { // libelle ?>
    <tr id="r_libelle">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_target_profiles_libelle"><?= $Page->libelle->caption() ?></span></td>
        <td data-name="libelle" <?= $Page->libelle->cellAttributes() ?>>
<span id="el_question_target_profiles_libelle">
<span<?= $Page->libelle->viewAttributes() ?>>
<?= $Page->libelle->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_first->Visible) { // control_first ?>
    <tr id="r_control_first">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_target_profiles_control_first"><?= $Page->control_first->caption() ?></span></td>
        <td data-name="control_first" <?= $Page->control_first->cellAttributes() ?>>
<span id="el_question_target_profiles_control_first">
<span<?= $Page->control_first->viewAttributes() ?>>
<?= $Page->control_first->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_second->Visible) { // control_second ?>
    <tr id="r_control_second">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_target_profiles_control_second"><?= $Page->control_second->caption() ?></span></td>
        <td data-name="control_second" <?= $Page->control_second->cellAttributes() ?>>
<span id="el_question_target_profiles_control_second">
<span<?= $Page->control_second->viewAttributes() ?>>
<?= $Page->control_second->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_target_profiles_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_question_target_profiles_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_question_target_profiles_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_question_target_profiles_updated_at">
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
