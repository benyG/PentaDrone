<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$LayerQuestionLinksView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var flayer_question_linksview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    flayer_question_linksview = currentForm = new ew.Form("flayer_question_linksview", "view");
    loadjs.done("flayer_question_linksview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.layer_question_links) ew.vars.tables.layer_question_links = <?= JsonEncode(GetClientVar("tables", "layer_question_links")) ?>;
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
<form name="flayer_question_linksview" id="flayer_question_linksview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="layer_question_links">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_layer_question_links_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_layer_question_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->layer_foreign_id->Visible) { // layer_foreign_id ?>
    <tr id="r_layer_foreign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_layer_question_links_layer_foreign_id"><?= $Page->layer_foreign_id->caption() ?></span></td>
        <td data-name="layer_foreign_id" <?= $Page->layer_foreign_id->cellAttributes() ?>>
<span id="el_layer_question_links_layer_foreign_id">
<span<?= $Page->layer_foreign_id->viewAttributes() ?>>
<?= $Page->layer_foreign_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->question_foreign_id->Visible) { // question_foreign_id ?>
    <tr id="r_question_foreign_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_layer_question_links_question_foreign_id"><?= $Page->question_foreign_id->caption() ?></span></td>
        <td data-name="question_foreign_id" <?= $Page->question_foreign_id->cellAttributes() ?>>
<span id="el_layer_question_links_question_foreign_id">
<span<?= $Page->question_foreign_id->viewAttributes() ?>>
<?= $Page->question_foreign_id->getViewValue() ?></span>
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