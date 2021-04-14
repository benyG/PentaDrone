<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$RiskLibrairiesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var frisk_librairiesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    frisk_librairiesview = currentForm = new ew.Form("frisk_librairiesview", "view");
    loadjs.done("frisk_librairiesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.risk_librairies) ew.vars.tables.risk_librairies = <?= JsonEncode(GetClientVar("tables", "risk_librairies")) ?>;
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
<form name="frisk_librairiesview" id="frisk_librairiesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_librairies">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_risk_librairies_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <tr id="r_title">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_title"><?= $Page->title->caption() ?></span></td>
        <td data-name="title" <?= $Page->title->cellAttributes() ?>>
<span id="el_risk_librairies_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->layer->Visible) { // layer ?>
    <tr id="r_layer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_layer"><?= $Page->layer->caption() ?></span></td>
        <td data-name="layer" <?= $Page->layer->cellAttributes() ?>>
<span id="el_risk_librairies_layer">
<span<?= $Page->layer->viewAttributes() ?>>
<?= $Page->layer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
    <tr id="r_function_csf">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_function_csf"><?= $Page->function_csf->caption() ?></span></td>
        <td data-name="function_csf" <?= $Page->function_csf->cellAttributes() ?>>
<span id="el_risk_librairies_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<?= $Page->function_csf->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
    <tr id="r_tag">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_tag"><?= $Page->tag->caption() ?></span></td>
        <td data-name="tag" <?= $Page->tag->cellAttributes() ?>>
<span id="el_risk_librairies_tag">
<span<?= $Page->tag->viewAttributes() ?>>
<?= $Page->tag->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
    <tr id="r_Confidentiality">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_Confidentiality"><?= $Page->Confidentiality->caption() ?></span></td>
        <td data-name="Confidentiality" <?= $Page->Confidentiality->cellAttributes() ?>>
<span id="el_risk_librairies_Confidentiality">
<span<?= $Page->Confidentiality->viewAttributes() ?>>
<?= $Page->Confidentiality->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
    <tr id="r_Integrity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_Integrity"><?= $Page->Integrity->caption() ?></span></td>
        <td data-name="Integrity" <?= $Page->Integrity->cellAttributes() ?>>
<span id="el_risk_librairies_Integrity">
<span<?= $Page->Integrity->viewAttributes() ?>>
<?= $Page->Integrity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
    <tr id="r_Availability">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_Availability"><?= $Page->Availability->caption() ?></span></td>
        <td data-name="Availability" <?= $Page->Availability->cellAttributes() ?>>
<span id="el_risk_librairies_Availability">
<span<?= $Page->Availability->viewAttributes() ?>>
<?= $Page->Availability->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
    <tr id="r_Efficiency">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_Efficiency"><?= $Page->Efficiency->caption() ?></span></td>
        <td data-name="Efficiency" <?= $Page->Efficiency->cellAttributes() ?>>
<span id="el_risk_librairies_Efficiency">
<span<?= $Page->Efficiency->viewAttributes() ?>>
<?= $Page->Efficiency->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_risk_librairies_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risk_librairies_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_risk_librairies_updated_at">
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
