<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubcatCisLinksDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsubcat_cis_linksdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsubcat_cis_linksdelete = currentForm = new ew.Form("fsubcat_cis_linksdelete", "delete");
    loadjs.done("fsubcat_cis_linksdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.subcat_cis_links) ew.vars.tables.subcat_cis_links = <?= JsonEncode(GetClientVar("tables", "subcat_cis_links")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsubcat_cis_linksdelete" id="fsubcat_cis_linksdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subcat_cis_links">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_subcat_cis_links_id" class="subcat_cis_links_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
        <th class="<?= $Page->subcat_id->headerCellClass() ?>"><span id="elh_subcat_cis_links_subcat_id" class="subcat_cis_links_subcat_id"><?= $Page->subcat_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cisrefs_id->Visible) { // cisrefs_id ?>
        <th class="<?= $Page->cisrefs_id->headerCellClass() ?>"><span id="elh_subcat_cis_links_cisrefs_id" class="subcat_cis_links_cisrefs_id"><?= $Page->cisrefs_id->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subcat_cis_links_id" class="subcat_cis_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
        <td <?= $Page->subcat_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subcat_cis_links_subcat_id" class="subcat_cis_links_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<?= $Page->subcat_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cisrefs_id->Visible) { // cisrefs_id ?>
        <td <?= $Page->cisrefs_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subcat_cis_links_cisrefs_id" class="subcat_cis_links_cisrefs_id">
<span<?= $Page->cisrefs_id->viewAttributes() ?>>
<?= $Page->cisrefs_id->getViewValue() ?></span>
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
