<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$ControlsLibraryList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcontrols_librarylist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fcontrols_librarylist = currentForm = new ew.Form("fcontrols_librarylist", "list");
    fcontrols_librarylist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "controls_library")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.controls_library)
        ew.vars.tables.controls_library = currentTable;
    fcontrols_librarylist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["nist_subcategory_id", [fields.nist_subcategory_id.visible && fields.nist_subcategory_id.required ? ew.Validators.required(fields.nist_subcategory_id.caption) : null, ew.Validators.integer], fields.nist_subcategory_id.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcontrols_librarylist,
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
    fcontrols_librarylist.validate = function () {
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
    fcontrols_librarylist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "nist_subcategory_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "title", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_at", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "updated_at", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fcontrols_librarylist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcontrols_librarylist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcontrols_librarylist");
});
var fcontrols_librarylistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fcontrols_librarylistsrch = currentSearchForm = new ew.Form("fcontrols_librarylistsrch");

    // Dynamic selection lists

    // Filters
    fcontrols_librarylistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fcontrols_librarylistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "sub_categories") {
    if ($Page->MasterRecordExists) {
        include_once "views/SubCategoriesMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fcontrols_librarylistsrch" id="fcontrols_librarylistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fcontrols_librarylistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="controls_library">
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> controls_library">
<form name="fcontrols_librarylist" id="fcontrols_librarylist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="controls_library">
<?php if ($Page->getCurrentMasterTable() == "sub_categories" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sub_categories">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->nist_subcategory_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_controls_library" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_controls_librarylist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_controls_library_id" class="controls_library_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <th data-name="nist_subcategory_id" class="<?= $Page->nist_subcategory_id->headerCellClass() ?>"><div id="elh_controls_library_nist_subcategory_id" class="controls_library_nist_subcategory_id"><?= $Page->renderSort($Page->nist_subcategory_id) ?></div></th>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <th data-name="title" class="<?= $Page->title->headerCellClass() ?>"><div id="elh_controls_library_title" class="controls_library_title"><?= $Page->renderSort($Page->title) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_controls_library_created_at" class="controls_library_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Page->updated_at->headerCellClass() ?>"><div id="elh_controls_library_updated_at" class="controls_library_updated_at"><?= $Page->renderSort($Page->updated_at) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_controls_library", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el<?= $Page->RowCount ?>_controls_library_id" class="form-group controls_library_id"></span>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <td data-name="nist_subcategory_id">
<?php if ($Page->nist_subcategory_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_controls_library_nist_subcategory_id" class="form-group controls_library_nist_subcategory_id">
<span<?= $Page->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nist_subcategory_id->getDisplayValue($Page->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_nist_subcategory_id" name="x<?= $Page->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Page->nist_subcategory_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_controls_library_nist_subcategory_id" class="form-group controls_library_nist_subcategory_id">
<input type="<?= $Page->nist_subcategory_id->getInputTextType() ?>" data-table="controls_library" data-field="x_nist_subcategory_id" name="x<?= $Page->RowIndex ?>_nist_subcategory_id" id="x<?= $Page->RowIndex ?>_nist_subcategory_id" size="30" placeholder="<?= HtmlEncode($Page->nist_subcategory_id->getPlaceHolder()) ?>" value="<?= $Page->nist_subcategory_id->EditValue ?>"<?= $Page->nist_subcategory_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nist_subcategory_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_nist_subcategory_id" id="o<?= $Page->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Page->nist_subcategory_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->title->Visible) { // title ?>
        <td data-name="title">
<span id="el<?= $Page->RowCount ?>_controls_library_title" class="form-group controls_library_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="controls_library" data-field="x_title" name="x<?= $Page->RowIndex ?>_title" id="x<?= $Page->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="o<?= $Page->RowIndex ?>_title" id="o<?= $Page->RowIndex ?>_title" value="<?= HtmlEncode($Page->title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<span id="el<?= $Page->RowCount ?>_controls_library_created_at" class="form-group controls_library_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="controls_library" data-field="x_created_at" name="x<?= $Page->RowIndex ?>_created_at" id="x<?= $Page->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarylist", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarylist", "x<?= $Page->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="o<?= $Page->RowIndex ?>_created_at" id="o<?= $Page->RowIndex ?>_created_at" value="<?= HtmlEncode($Page->created_at->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at">
<span id="el<?= $Page->RowCount ?>_controls_library_updated_at" class="form-group controls_library_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="controls_library" data-field="x_updated_at" name="x<?= $Page->RowIndex ?>_updated_at" id="x<?= $Page->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarylist", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarylist", "x<?= $Page->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="o<?= $Page->RowIndex ?>_updated_at" id="o<?= $Page->RowIndex ?>_updated_at" value="<?= HtmlEncode($Page->updated_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fcontrols_librarylist","load"], function() {
    fcontrols_librarylist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_controls_library", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_id" class="form-group"></span>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <td data-name="nist_subcategory_id" <?= $Page->nist_subcategory_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->nist_subcategory_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_controls_library_nist_subcategory_id" class="form-group">
<span<?= $Page->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nist_subcategory_id->getDisplayValue($Page->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_nist_subcategory_id" name="x<?= $Page->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Page->nist_subcategory_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_controls_library_nist_subcategory_id" class="form-group">
<input type="<?= $Page->nist_subcategory_id->getInputTextType() ?>" data-table="controls_library" data-field="x_nist_subcategory_id" name="x<?= $Page->RowIndex ?>_nist_subcategory_id" id="x<?= $Page->RowIndex ?>_nist_subcategory_id" size="30" placeholder="<?= HtmlEncode($Page->nist_subcategory_id->getPlaceHolder()) ?>" value="<?= $Page->nist_subcategory_id->EditValue ?>"<?= $Page->nist_subcategory_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nist_subcategory_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_nist_subcategory_id" id="o<?= $Page->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Page->nist_subcategory_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_nist_subcategory_id">
<span<?= $Page->nist_subcategory_id->viewAttributes() ?>>
<?= $Page->nist_subcategory_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->title->Visible) { // title ?>
        <td data-name="title" <?= $Page->title->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_title" class="form-group">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="controls_library" data-field="x_title" name="x<?= $Page->RowIndex ?>_title" id="x<?= $Page->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="o<?= $Page->RowIndex ?>_title" id="o<?= $Page->RowIndex ?>_title" value="<?= HtmlEncode($Page->title->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_created_at" class="form-group">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="controls_library" data-field="x_created_at" name="x<?= $Page->RowIndex ?>_created_at" id="x<?= $Page->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarylist", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarylist", "x<?= $Page->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="o<?= $Page->RowIndex ?>_created_at" id="o<?= $Page->RowIndex ?>_created_at" value="<?= HtmlEncode($Page->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_updated_at" class="form-group">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="controls_library" data-field="x_updated_at" name="x<?= $Page->RowIndex ?>_updated_at" id="x<?= $Page->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarylist", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarylist", "x<?= $Page->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="o<?= $Page->RowIndex ?>_updated_at" id="o<?= $Page->RowIndex ?>_updated_at" value="<?= HtmlEncode($Page->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_controls_library_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
loadjs.ready(["fcontrols_librarylist","load"], function () {
    fcontrols_librarylist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_controls_library", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el$rowindex$_controls_library_id" class="form-group controls_library_id"></span>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <td data-name="nist_subcategory_id">
<?php if ($Page->nist_subcategory_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_controls_library_nist_subcategory_id" class="form-group controls_library_nist_subcategory_id">
<span<?= $Page->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nist_subcategory_id->getDisplayValue($Page->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_nist_subcategory_id" name="x<?= $Page->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Page->nist_subcategory_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_controls_library_nist_subcategory_id" class="form-group controls_library_nist_subcategory_id">
<input type="<?= $Page->nist_subcategory_id->getInputTextType() ?>" data-table="controls_library" data-field="x_nist_subcategory_id" name="x<?= $Page->RowIndex ?>_nist_subcategory_id" id="x<?= $Page->RowIndex ?>_nist_subcategory_id" size="30" placeholder="<?= HtmlEncode($Page->nist_subcategory_id->getPlaceHolder()) ?>" value="<?= $Page->nist_subcategory_id->EditValue ?>"<?= $Page->nist_subcategory_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nist_subcategory_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_nist_subcategory_id" id="o<?= $Page->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Page->nist_subcategory_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->title->Visible) { // title ?>
        <td data-name="title">
<span id="el$rowindex$_controls_library_title" class="form-group controls_library_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="controls_library" data-field="x_title" name="x<?= $Page->RowIndex ?>_title" id="x<?= $Page->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="o<?= $Page->RowIndex ?>_title" id="o<?= $Page->RowIndex ?>_title" value="<?= HtmlEncode($Page->title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<span id="el$rowindex$_controls_library_created_at" class="form-group controls_library_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="controls_library" data-field="x_created_at" name="x<?= $Page->RowIndex ?>_created_at" id="x<?= $Page->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarylist", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarylist", "x<?= $Page->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="o<?= $Page->RowIndex ?>_created_at" id="o<?= $Page->RowIndex ?>_created_at" value="<?= HtmlEncode($Page->created_at->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at">
<span id="el$rowindex$_controls_library_updated_at" class="form-group controls_library_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="controls_library" data-field="x_updated_at" name="x<?= $Page->RowIndex ?>_updated_at" id="x<?= $Page->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarylist", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarylist", "x<?= $Page->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="o<?= $Page->RowIndex ?>_updated_at" id="o<?= $Page->RowIndex ?>_updated_at" value="<?= HtmlEncode($Page->updated_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fcontrols_librarylist","load"], function() {
    fcontrols_librarylist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("controls_library");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
