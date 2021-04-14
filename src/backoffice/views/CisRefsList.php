<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$CisRefsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcis_refslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fcis_refslist = currentForm = new ew.Form("fcis_refslist", "list");
    fcis_refslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fcis_refslist");
});
var fcis_refslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fcis_refslistsrch = currentSearchForm = new ew.Form("fcis_refslistsrch");

    // Dynamic selection lists

    // Filters
    fcis_refslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fcis_refslistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "cis_refs_controlfamily") {
    if ($Page->MasterRecordExists) {
        include_once "views/CisRefsControlfamilyMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fcis_refslistsrch" id="fcis_refslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fcis_refslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cis_refs">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> cis_refs">
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
<form name="fcis_refslist" id="fcis_refslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cis_refs">
<?php if ($Page->getCurrentMasterTable() == "cis_refs_controlfamily" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cis_refs_controlfamily">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->Control_Family_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_cis_refs" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_cis_refslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
        <th data-name="Nidentifier" class="<?= $Page->Nidentifier->headerCellClass() ?>"><div id="elh_cis_refs_Nidentifier" class="cis_refs_Nidentifier"><?= $Page->renderSort($Page->Nidentifier) ?></div></th>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <th data-name="Control_Family_id" class="<?= $Page->Control_Family_id->headerCellClass() ?>"><div id="elh_cis_refs_Control_Family_id" class="cis_refs_Control_Family_id"><?= $Page->renderSort($Page->Control_Family_id) ?></div></th>
<?php } ?>
<?php if ($Page->control_Name->Visible) { // control_Name ?>
        <th data-name="control_Name" class="<?= $Page->control_Name->headerCellClass() ?>"><div id="elh_cis_refs_control_Name" class="cis_refs_control_Name"><?= $Page->renderSort($Page->control_Name) ?></div></th>
<?php } ?>
<?php if ($Page->impl_group1->Visible) { // impl_group1 ?>
        <th data-name="impl_group1" class="<?= $Page->impl_group1->headerCellClass() ?>"><div id="elh_cis_refs_impl_group1" class="cis_refs_impl_group1"><?= $Page->renderSort($Page->impl_group1) ?></div></th>
<?php } ?>
<?php if ($Page->impl_group2->Visible) { // impl_group2 ?>
        <th data-name="impl_group2" class="<?= $Page->impl_group2->headerCellClass() ?>"><div id="elh_cis_refs_impl_group2" class="cis_refs_impl_group2"><?= $Page->renderSort($Page->impl_group2) ?></div></th>
<?php } ?>
<?php if ($Page->impl_group3->Visible) { // impl_group3 ?>
        <th data-name="impl_group3" class="<?= $Page->impl_group3->headerCellClass() ?>"><div id="elh_cis_refs_impl_group3" class="cis_refs_impl_group3"><?= $Page->renderSort($Page->impl_group3) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_cis_refs", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
        <td data-name="Nidentifier" <?= $Page->Nidentifier->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_Nidentifier">
<span<?= $Page->Nidentifier->viewAttributes() ?>>
<?= $Page->Nidentifier->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <td data-name="Control_Family_id" <?= $Page->Control_Family_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<?= $Page->Control_Family_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->control_Name->Visible) { // control_Name ?>
        <td data-name="control_Name" <?= $Page->control_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_control_Name">
<span<?= $Page->control_Name->viewAttributes() ?>>
<?= $Page->control_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->impl_group1->Visible) { // impl_group1 ?>
        <td data-name="impl_group1" <?= $Page->impl_group1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_impl_group1">
<span<?= $Page->impl_group1->viewAttributes() ?>>
<?= $Page->impl_group1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->impl_group2->Visible) { // impl_group2 ?>
        <td data-name="impl_group2" <?= $Page->impl_group2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_impl_group2">
<span<?= $Page->impl_group2->viewAttributes() ?>>
<?= $Page->impl_group2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->impl_group3->Visible) { // impl_group3 ?>
        <td data-name="impl_group3" <?= $Page->impl_group3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cis_refs_impl_group3">
<span<?= $Page->impl_group3->viewAttributes() ?>>
<?= $Page->impl_group3->getViewValue() ?></span>
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
    ew.addEventHandlers("cis_refs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
