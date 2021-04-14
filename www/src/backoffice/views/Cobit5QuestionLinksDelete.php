<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$Cobit5QuestionLinksDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcobit5_question_linksdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcobit5_question_linksdelete = currentForm = new ew.Form("fcobit5_question_linksdelete", "delete");
    loadjs.done("fcobit5_question_linksdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.cobit5_question_links) ew.vars.tables.cobit5_question_links = <?= JsonEncode(GetClientVar("tables", "cobit5_question_links")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcobit5_question_linksdelete" id="fcobit5_question_linksdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cobit5_question_links">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_cobit5_question_links_id" class="cobit5_question_links_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->question_foreign_id->Visible) { // question_foreign_id ?>
        <th class="<?= $Page->question_foreign_id->headerCellClass() ?>"><span id="elh_cobit5_question_links_question_foreign_id" class="cobit5_question_links_question_foreign_id"><?= $Page->question_foreign_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cobit5refs_id->Visible) { // cobit5refs_id ?>
        <th class="<?= $Page->cobit5refs_id->headerCellClass() ?>"><span id="elh_cobit5_question_links_cobit5refs_id" class="cobit5_question_links_cobit5refs_id"><?= $Page->cobit5refs_id->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_cobit5_question_links_id" class="cobit5_question_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->question_foreign_id->Visible) { // question_foreign_id ?>
        <td <?= $Page->question_foreign_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cobit5_question_links_question_foreign_id" class="cobit5_question_links_question_foreign_id">
<span<?= $Page->question_foreign_id->viewAttributes() ?>>
<?= $Page->question_foreign_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cobit5refs_id->Visible) { // cobit5refs_id ?>
        <td <?= $Page->cobit5refs_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cobit5_question_links_cobit5refs_id" class="cobit5_question_links_cobit5refs_id">
<span<?= $Page->cobit5refs_id->viewAttributes() ?>>
<?= $Page->cobit5refs_id->getViewValue() ?></span>
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
