<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionControlobjectivesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestion_controlobjectiveslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fquestion_controlobjectiveslist = currentForm = new ew.Form("fquestion_controlobjectiveslist", "list");
    fquestion_controlobjectiveslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fquestion_controlobjectiveslist");
});
var fquestion_controlobjectiveslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fquestion_controlobjectiveslistsrch = currentSearchForm = new ew.Form("fquestion_controlobjectiveslistsrch");

    // Dynamic selection lists

    // Filters
    fquestion_controlobjectiveslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fquestion_controlobjectiveslistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "question_domains") {
    if ($Page->MasterRecordExists) {
        include_once "views/QuestionDomainsMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "layers") {
    if ($Page->MasterRecordExists) {
        include_once "views/LayersMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "functions") {
    if ($Page->MasterRecordExists) {
        include_once "views/FunctionsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fquestion_controlobjectiveslistsrch" id="fquestion_controlobjectiveslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fquestion_controlobjectiveslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="question_controlobjectives">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> question_controlobjectives">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fquestion_controlobjectiveslist" id="fquestion_controlobjectiveslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_controlobjectives">
<?php if ($Page->getCurrentMasterTable() == "question_domains" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="question_domains">
<input type="hidden" name="fk_domain_name" value="<?= HtmlEncode($Page->question_domain_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "layers" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="layers">
<input type="hidden" name="fk_name" value="<?= HtmlEncode($Page->layer_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "functions" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="functions">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->function_csf->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_question_controlobjectives" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_question_controlobjectiveslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->num_ordre->Visible) { // num_ordre ?>
        <th data-name="num_ordre" class="<?= $Page->num_ordre->headerCellClass() ?>"><div id="elh_question_controlobjectives_num_ordre" class="question_controlobjectives_num_ordre"><?= $Page->renderSort($Page->num_ordre) ?></div></th>
<?php } ?>
<?php if ($Page->controlObj_name->Visible) { // controlObj_name ?>
        <th data-name="controlObj_name" class="<?= $Page->controlObj_name->headerCellClass() ?>"><div id="elh_question_controlobjectives_controlObj_name" class="question_controlobjectives_controlObj_name"><?= $Page->renderSort($Page->controlObj_name) ?></div></th>
<?php } ?>
<?php if ($Page->question_domain_id->Visible) { // question_domain_id ?>
        <th data-name="question_domain_id" class="<?= $Page->question_domain_id->headerCellClass() ?>"><div id="elh_question_controlobjectives_question_domain_id" class="question_controlobjectives_question_domain_id"><?= $Page->renderSort($Page->question_domain_id) ?></div></th>
<?php } ?>
<?php if ($Page->layer_id->Visible) { // layer_id ?>
        <th data-name="layer_id" class="<?= $Page->layer_id->headerCellClass() ?>"><div id="elh_question_controlobjectives_layer_id" class="question_controlobjectives_layer_id"><?= $Page->renderSort($Page->layer_id) ?></div></th>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
        <th data-name="function_csf" class="<?= $Page->function_csf->headerCellClass() ?>"><div id="elh_question_controlobjectives_function_csf" class="question_controlobjectives_function_csf"><?= $Page->renderSort($Page->function_csf) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_question_controlobjectives_created_at" class="question_controlobjectives_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Page->updated_at->headerCellClass() ?>"><div id="elh_question_controlobjectives_updated_at" class="question_controlobjectives_updated_at"><?= $Page->renderSort($Page->updated_at) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_question_controlobjectives", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->num_ordre->Visible) { // num_ordre ?>
        <td data-name="num_ordre" <?= $Page->num_ordre->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_num_ordre">
<span<?= $Page->num_ordre->viewAttributes() ?>>
<?= $Page->num_ordre->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->controlObj_name->Visible) { // controlObj_name ?>
        <td data-name="controlObj_name" <?= $Page->controlObj_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_controlObj_name">
<span<?= $Page->controlObj_name->viewAttributes() ?>>
<?= $Page->controlObj_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->question_domain_id->Visible) { // question_domain_id ?>
        <td data-name="question_domain_id" <?= $Page->question_domain_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_question_domain_id">
<span<?= $Page->question_domain_id->viewAttributes() ?>>
<?= $Page->question_domain_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->layer_id->Visible) { // layer_id ?>
        <td data-name="layer_id" <?= $Page->layer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_layer_id">
<span<?= $Page->layer_id->viewAttributes() ?>>
<?= $Page->layer_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf" <?= $Page->function_csf->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<?= $Page->function_csf->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_question_controlobjectives_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("question_controlobjectives");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
