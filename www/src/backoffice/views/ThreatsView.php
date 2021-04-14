<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$ThreatsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fthreatsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fthreatsview = currentForm = new ew.Form("fthreatsview", "view");
    loadjs.done("fthreatsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.threats) ew.vars.tables.threats = <?= JsonEncode(GetClientVar("tables", "threats")) ?>;
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
<form name="fthreatsview" id="fthreatsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="threats">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_threats_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_threats_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
    <tr id="r_Confidentiality">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_threats_Confidentiality"><?= $Page->Confidentiality->caption() ?></span></td>
        <td data-name="Confidentiality" <?= $Page->Confidentiality->cellAttributes() ?>>
<span id="el_threats_Confidentiality">
<span<?= $Page->Confidentiality->viewAttributes() ?>>
<?= $Page->Confidentiality->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
    <tr id="r_Integrity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_threats_Integrity"><?= $Page->Integrity->caption() ?></span></td>
        <td data-name="Integrity" <?= $Page->Integrity->cellAttributes() ?>>
<span id="el_threats_Integrity">
<span<?= $Page->Integrity->viewAttributes() ?>>
<?= $Page->Integrity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
    <tr id="r_Availability">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_threats_Availability"><?= $Page->Availability->caption() ?></span></td>
        <td data-name="Availability" <?= $Page->Availability->cellAttributes() ?>>
<span id="el_threats_Availability">
<span<?= $Page->Availability->viewAttributes() ?>>
<?= $Page->Availability->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
    <tr id="r_Efficiency">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_threats_Efficiency"><?= $Page->Efficiency->caption() ?></span></td>
        <td data-name="Efficiency" <?= $Page->Efficiency->cellAttributes() ?>>
<span id="el_threats_Efficiency">
<span<?= $Page->Efficiency->viewAttributes() ?>>
<?= $Page->Efficiency->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_threats_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_threats_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_threats_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_threats_updated_at">
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
