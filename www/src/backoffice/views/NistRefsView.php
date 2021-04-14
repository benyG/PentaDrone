<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistRefsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnist_refsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnist_refsview = currentForm = new ew.Form("fnist_refsview", "view");
    loadjs.done("fnist_refsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.nist_refs) ew.vars.tables.nist_refs = <?= JsonEncode(GetClientVar("tables", "nist_refs")) ?>;
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
<form name="fnist_refsview" id="fnist_refsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_refs">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
    <tr id="r_Nidentifier">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_Nidentifier"><?= $Page->Nidentifier->caption() ?></span></td>
        <td data-name="Nidentifier" <?= $Page->Nidentifier->cellAttributes() ?>>
<span id="el_nist_refs_Nidentifier">
<span<?= $Page->Nidentifier->viewAttributes() ?>>
<?= $Page->Nidentifier->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->N_ordre->Visible) { // N_ordre ?>
    <tr id="r_N_ordre">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_N_ordre"><?= $Page->N_ordre->caption() ?></span></td>
        <td data-name="N_ordre" <?= $Page->N_ordre->cellAttributes() ?>>
<span id="el_nist_refs_N_ordre">
<span<?= $Page->N_ordre->viewAttributes() ?>>
<?= $Page->N_ordre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
    <tr id="r_Control_Family_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_Control_Family_id"><?= $Page->Control_Family_id->caption() ?></span></td>
        <td data-name="Control_Family_id" <?= $Page->Control_Family_id->cellAttributes() ?>>
<span id="el_nist_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<?= $Page->Control_Family_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Control_Name->Visible) { // Control_Name ?>
    <tr id="r_Control_Name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_Control_Name"><?= $Page->Control_Name->caption() ?></span></td>
        <td data-name="Control_Name" <?= $Page->Control_Name->cellAttributes() ?>>
<span id="el_nist_refs_Control_Name">
<span<?= $Page->Control_Name->viewAttributes() ?>>
<?= $Page->Control_Name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->control_description->Visible) { // control_description ?>
    <tr id="r_control_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_control_description"><?= $Page->control_description->caption() ?></span></td>
        <td data-name="control_description" <?= $Page->control_description->cellAttributes() ?>>
<span id="el_nist_refs_control_description">
<span<?= $Page->control_description->viewAttributes() ?>>
<?= $Page->control_description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->discussion->Visible) { // discussion ?>
    <tr id="r_discussion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_discussion"><?= $Page->discussion->caption() ?></span></td>
        <td data-name="discussion" <?= $Page->discussion->cellAttributes() ?>>
<span id="el_nist_refs_discussion">
<span<?= $Page->discussion->viewAttributes() ?>>
<?= $Page->discussion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->related_controls->Visible) { // related_controls ?>
    <tr id="r_related_controls">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nist_refs_related_controls"><?= $Page->related_controls->caption() ?></span></td>
        <td data-name="related_controls" <?= $Page->related_controls->cellAttributes() ?>>
<span id="el_nist_refs_related_controls">
<span<?= $Page->related_controls->viewAttributes() ?>>
<?= $Page->related_controls->getViewValue() ?></span>
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
