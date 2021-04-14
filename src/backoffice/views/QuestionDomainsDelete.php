<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionDomainsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestion_domainsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fquestion_domainsdelete = currentForm = new ew.Form("fquestion_domainsdelete", "delete");
    loadjs.done("fquestion_domainsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.question_domains) ew.vars.tables.question_domains = <?= JsonEncode(GetClientVar("tables", "question_domains")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fquestion_domainsdelete" id="fquestion_domainsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_domains">
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
<?php if ($Page->domain_name->Visible) { // domain_name ?>
        <th class="<?= $Page->domain_name->headerCellClass() ?>"><span id="elh_question_domains_domain_name" class="question_domains_domain_name"><?= $Page->domain_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->question_area_id->Visible) { // question_area_id ?>
        <th class="<?= $Page->question_area_id->headerCellClass() ?>"><span id="elh_question_domains_question_area_id" class="question_domains_question_area_id"><?= $Page->question_area_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_question_domains_created_at" class="question_domains_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_question_domains_updated_at" class="question_domains_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<?php if ($Page->domain_name->Visible) { // domain_name ?>
        <td <?= $Page->domain_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_domains_domain_name" class="question_domains_domain_name">
<span<?= $Page->domain_name->viewAttributes() ?>>
<?= $Page->domain_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->question_area_id->Visible) { // question_area_id ?>
        <td <?= $Page->question_area_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_domains_question_area_id" class="question_domains_question_area_id">
<span<?= $Page->question_area_id->viewAttributes() ?>>
<?= $Page->question_area_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_domains_created_at" class="question_domains_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_domains_updated_at" class="question_domains_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
