<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubCategoriesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_categorieslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsub_categorieslist = currentForm = new ew.Form("fsub_categorieslist", "list");
    fsub_categorieslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_categories")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_categories)
        ew.vars.tables.sub_categories = currentTable;
    fsub_categorieslist.addFields([
        ["code_nist", [fields.code_nist.visible && fields.code_nist.required ? ew.Validators.required(fields.code_nist.caption) : null], fields.code_nist.isInvalid],
        ["statement", [fields.statement.visible && fields.statement.required ? ew.Validators.required(fields.statement.caption) : null], fields.statement.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_categorieslist,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fsub_categorieslist.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        if (gridinsert && addcnt == 0) { // No row added
            ew.alert(ew.language.phrase("NoAddRecord"));
            return false;
        }
        return true;
    }

    // Check empty row
    fsub_categorieslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "code_nist", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "statement", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsub_categorieslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_categorieslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsub_categorieslist");
});
var fsub_categorieslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fsub_categorieslistsrch = currentSearchForm = new ew.Form("fsub_categorieslistsrch");

    // Dynamic selection lists

    // Filters
    fsub_categorieslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fsub_categorieslistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "categories") {
    if ($Page->MasterRecordExists) {
        include_once "views/CategoriesMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fsub_categorieslistsrch" id="fsub_categorieslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fsub_categorieslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="sub_categories">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sub_categories">
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
<form name="fsub_categorieslist" id="fsub_categorieslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sub_categories">
<?php if ($Page->getCurrentMasterTable() == "categories" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="categories">
<input type="hidden" name="fk_code_nist" value="<?= HtmlEncode($Page->fk_id_categories->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_sub_categories" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_sub_categorieslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->code_nist->Visible) { // code_nist ?>
        <th data-name="code_nist" class="<?= $Page->code_nist->headerCellClass() ?>"><div id="elh_sub_categories_code_nist" class="sub_categories_code_nist"><?= $Page->renderSort($Page->code_nist) ?></div></th>
<?php } ?>
<?php if ($Page->statement->Visible) { // statement ?>
        <th data-name="statement" class="<?= $Page->statement->headerCellClass() ?>"><div id="elh_sub_categories_statement" class="sub_categories_statement"><?= $Page->renderSort($Page->statement) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
    if ($Page->isAdd() || $Page->isCopy()) {
        $Page->RowIndex = 0;
        $Page->KeyCount = $Page->RowIndex;
        if ($Page->isAdd())
            $Page->loadRowValues();
        if ($Page->EventCancelled) // Insert failed
            $Page->restoreFormValues(); // Restore form values

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_sub_categories", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->code_nist->Visible) { // code_nist ?>
        <td data-name="code_nist">
<span id="el<?= $Page->RowCount ?>_sub_categories_code_nist" class="form-group sub_categories_code_nist">
<input type="<?= $Page->code_nist->getInputTextType() ?>" data-table="sub_categories" data-field="x_code_nist" name="x<?= $Page->RowIndex ?>_code_nist" id="x<?= $Page->RowIndex ?>_code_nist" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code_nist->getPlaceHolder()) ?>" value="<?= $Page->code_nist->EditValue ?>"<?= $Page->code_nist->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->code_nist->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="o<?= $Page->RowIndex ?>_code_nist" id="o<?= $Page->RowIndex ?>_code_nist" value="<?= HtmlEncode($Page->code_nist->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->statement->Visible) { // statement ?>
        <td data-name="statement">
<span id="el<?= $Page->RowCount ?>_sub_categories_statement" class="form-group sub_categories_statement">
<input type="<?= $Page->statement->getInputTextType() ?>" data-table="sub_categories" data-field="x_statement" name="x<?= $Page->RowIndex ?>_statement" id="x<?= $Page->RowIndex ?>_statement" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statement->getPlaceHolder()) ?>" value="<?= $Page->statement->EditValue ?>"<?= $Page->statement->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->statement->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="o<?= $Page->RowIndex ?>_statement" id="o<?= $Page->RowIndex ?>_statement" value="<?= HtmlEncode($Page->statement->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fsub_categorieslist","load"], function() {
    fsub_categorieslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
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

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
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
if ($Page->isGridAdd())
    $Page->RowIndex = 0;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

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
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_sub_categories", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Page->RowAction != "delete" && $Page->RowAction != "insertdelete" && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->code_nist->Visible) { // code_nist ?>
        <td data-name="code_nist" <?= $Page->code_nist->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_categories_code_nist" class="form-group">
<input type="<?= $Page->code_nist->getInputTextType() ?>" data-table="sub_categories" data-field="x_code_nist" name="x<?= $Page->RowIndex ?>_code_nist" id="x<?= $Page->RowIndex ?>_code_nist" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code_nist->getPlaceHolder()) ?>" value="<?= $Page->code_nist->EditValue ?>"<?= $Page->code_nist->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->code_nist->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="o<?= $Page->RowIndex ?>_code_nist" id="o<?= $Page->RowIndex ?>_code_nist" value="<?= HtmlEncode($Page->code_nist->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_categories_code_nist">
<span<?= $Page->code_nist->viewAttributes() ?>>
<?= $Page->code_nist->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->statement->Visible) { // statement ?>
        <td data-name="statement" <?= $Page->statement->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_sub_categories_statement" class="form-group">
<input type="<?= $Page->statement->getInputTextType() ?>" data-table="sub_categories" data-field="x_statement" name="x<?= $Page->RowIndex ?>_statement" id="x<?= $Page->RowIndex ?>_statement" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statement->getPlaceHolder()) ?>" value="<?= $Page->statement->EditValue ?>"<?= $Page->statement->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->statement->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="o<?= $Page->RowIndex ?>_statement" id="o<?= $Page->RowIndex ?>_statement" value="<?= HtmlEncode($Page->statement->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_sub_categories_statement">
<span<?= $Page->statement->viewAttributes() ?>>
<?= $Page->statement->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fsub_categorieslist","load"], function () {
    fsub_categorieslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
    if ($Page->isGridAdd() || $Page->isGridEdit()) {
        $Page->RowIndex = '$rowindex$';
        $Page->loadRowValues();

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_sub_categories", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowAttrs->appendClass("ew-template");
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->code_nist->Visible) { // code_nist ?>
        <td data-name="code_nist">
<span id="el$rowindex$_sub_categories_code_nist" class="form-group sub_categories_code_nist">
<input type="<?= $Page->code_nist->getInputTextType() ?>" data-table="sub_categories" data-field="x_code_nist" name="x<?= $Page->RowIndex ?>_code_nist" id="x<?= $Page->RowIndex ?>_code_nist" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code_nist->getPlaceHolder()) ?>" value="<?= $Page->code_nist->EditValue ?>"<?= $Page->code_nist->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->code_nist->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="o<?= $Page->RowIndex ?>_code_nist" id="o<?= $Page->RowIndex ?>_code_nist" value="<?= HtmlEncode($Page->code_nist->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->statement->Visible) { // statement ?>
        <td data-name="statement">
<span id="el$rowindex$_sub_categories_statement" class="form-group sub_categories_statement">
<input type="<?= $Page->statement->getInputTextType() ?>" data-table="sub_categories" data-field="x_statement" name="x<?= $Page->RowIndex ?>_statement" id="x<?= $Page->RowIndex ?>_statement" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statement->getPlaceHolder()) ?>" value="<?= $Page->statement->EditValue ?>"<?= $Page->statement->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->statement->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="o<?= $Page->RowIndex ?>_statement" id="o<?= $Page->RowIndex ?>_statement" value="<?= HtmlEncode($Page->statement->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fsub_categorieslist","load"], function() {
    fsub_categorieslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
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
    ew.addEventHandlers("sub_categories");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
