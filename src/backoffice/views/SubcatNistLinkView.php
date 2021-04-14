<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$SubcatNistLinkView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsubcat_nist_linkview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fsubcat_nist_linkview = currentForm = new ew.Form("fsubcat_nist_linkview", "view");
    loadjs.done("fsubcat_nist_linkview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.subcat_nist_link) ew.vars.tables.subcat_nist_link = <?= JsonEncode(GetClientVar("tables", "subcat_nist_link")) ?>;
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
<form name="fsubcat_nist_linkview" id="fsubcat_nist_linkview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subcat_nist_link">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subcat_nist_link_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_subcat_nist_link_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
    <tr id="r_subcat_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subcat_nist_link_subcat_id"><?= $Page->subcat_id->caption() ?></span></td>
        <td data-name="subcat_id" <?= $Page->subcat_id->cellAttributes() ?>>
<span id="el_subcat_nist_link_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<?= $Page->subcat_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nistrefs_id->Visible) { // nistrefs_id ?>
    <tr id="r_nistrefs_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subcat_nist_link_nistrefs_id"><?= $Page->nistrefs_id->caption() ?></span></td>
        <td data-name="nistrefs_id" <?= $Page->nistrefs_id->cellAttributes() ?>>
<span id="el_subcat_nist_link_nistrefs_id">
<span<?= $Page->nistrefs_id->viewAttributes() ?>>
<?= $Page->nistrefs_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
