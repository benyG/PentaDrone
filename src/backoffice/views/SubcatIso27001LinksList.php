<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubcatIso27001LinksList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsubcat_iso27001_linkslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsubcat_iso27001_linkslist = currentForm = new ew.Form("fsubcat_iso27001_linkslist", "list");
    fsubcat_iso27001_linkslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subcat_iso27001_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subcat_iso27001_links)
        ew.vars.tables.subcat_iso27001_links = currentTable;
    fsubcat_iso27001_linkslist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["iso27001_code", [fields.iso27001_code.visible && fields.iso27001_code.required ? ew.Validators.required(fields.iso27001_code.caption) : null], fields.iso27001_code.isInvalid],
        ["subcat_id", [fields.subcat_id.visible && fields.subcat_id.required ? ew.Validators.required(fields.subcat_id.caption) : null], fields.subcat_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubcat_iso27001_linkslist,
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
    fsubcat_iso27001_linkslist.validate = function () {
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
    fsubcat_iso27001_linkslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "iso27001_code", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "subcat_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsubcat_iso27001_linkslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubcat_iso27001_linkslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsubcat_iso27001_linkslist.lists.iso27001_code = <?= $Page->iso27001_code->toClientList($Page) ?>;
    fsubcat_iso27001_linkslist.lists.subcat_id = <?= $Page->subcat_id->toClientList($Page) ?>;
    loadjs.done("fsubcat_iso27001_linkslist");
});
var fsubcat_iso27001_linkslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fsubcat_iso27001_linkslistsrch = currentSearchForm = new ew.Form("fsubcat_iso27001_linkslistsrch");

    // Dynamic selection lists

    // Filters
    fsubcat_iso27001_linkslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fsubcat_iso27001_linkslistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "iso27001_refs") {
    if ($Page->MasterRecordExists) {
        include_once "views/Iso27001RefsMaster.php";
    }
}
?>
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
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fsubcat_iso27001_linkslistsrch" id="fsubcat_iso27001_linkslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fsubcat_iso27001_linkslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="subcat_iso27001_links">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> subcat_iso27001_links">
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
<form name="fsubcat_iso27001_linkslist" id="fsubcat_iso27001_linkslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subcat_iso27001_links">
<?php if ($Page->getCurrentMasterTable() == "iso27001_refs" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="iso27001_refs">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->iso27001_code->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "sub_categories" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sub_categories">
<input type="hidden" name="fk_code_nist" value="<?= HtmlEncode($Page->subcat_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_subcat_iso27001_links" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_subcat_iso27001_linkslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_subcat_iso27001_links_id" class="subcat_iso27001_links_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->iso27001_code->Visible) { // iso27001_code ?>
        <th data-name="iso27001_code" class="<?= $Page->iso27001_code->headerCellClass() ?>"><div id="elh_subcat_iso27001_links_iso27001_code" class="subcat_iso27001_links_iso27001_code"><?= $Page->renderSort($Page->iso27001_code) ?></div></th>
<?php } ?>
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
        <th data-name="subcat_id" class="<?= $Page->subcat_id->headerCellClass() ?>"><div id="elh_subcat_iso27001_links_subcat_id" class="subcat_iso27001_links_subcat_id"><?= $Page->renderSort($Page->subcat_id) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_subcat_iso27001_links", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_id" class="form-group subcat_iso27001_links_id"></span>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->iso27001_code->Visible) { // iso27001_code ?>
        <td data-name="iso27001_code">
<?php if ($Page->iso27001_code->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_iso27001_code" class="form-group subcat_iso27001_links_iso27001_code">
<span<?= $Page->iso27001_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iso27001_code->getDisplayValue($Page->iso27001_code->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_iso27001_code" name="x<?= $Page->RowIndex ?>_iso27001_code" value="<?= HtmlEncode($Page->iso27001_code->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_iso27001_code" class="form-group subcat_iso27001_links_iso27001_code">
    <select
        id="x<?= $Page->RowIndex ?>_iso27001_code"
        name="x<?= $Page->RowIndex ?>_iso27001_code"
        class="form-control ew-select<?= $Page->iso27001_code->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code"
        data-table="subcat_iso27001_links"
        data-field="x_iso27001_code"
        data-value-separator="<?= $Page->iso27001_code->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->iso27001_code->getPlaceHolder()) ?>"
        <?= $Page->iso27001_code->editAttributes() ?>>
        <?= $Page->iso27001_code->selectOptionListHtml("x{$Page->RowIndex}_iso27001_code") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->iso27001_code->getErrorMessage() ?></div>
<?= $Page->iso27001_code->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_iso27001_code") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code']"),
        options = { name: "x<?= $Page->RowIndex ?>_iso27001_code", selectId: "subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.iso27001_code.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_iso27001_code" data-hidden="1" name="o<?= $Page->RowIndex ?>_iso27001_code" id="o<?= $Page->RowIndex ?>_iso27001_code" value="<?= HtmlEncode($Page->iso27001_code->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->subcat_id->Visible) { // subcat_id ?>
        <td data-name="subcat_id">
<?php if ($Page->subcat_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_subcat_id" class="form-group subcat_iso27001_links_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subcat_id->getDisplayValue($Page->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_subcat_id" name="x<?= $Page->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Page->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_subcat_id" class="form-group subcat_iso27001_links_subcat_id">
    <select
        id="x<?= $Page->RowIndex ?>_subcat_id"
        name="x<?= $Page->RowIndex ?>_subcat_id"
        class="form-control ew-select<?= $Page->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id"
        data-table="subcat_iso27001_links"
        data-field="x_subcat_id"
        data-value-separator="<?= $Page->subcat_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subcat_id->getPlaceHolder()) ?>"
        <?= $Page->subcat_id->editAttributes() ?>>
        <?= $Page->subcat_id->selectOptionListHtml("x{$Page->RowIndex}_subcat_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->subcat_id->getErrorMessage() ?></div>
<?= $Page->subcat_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_subcat_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_subcat_id", selectId: "subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_subcat_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_subcat_id" id="o<?= $Page->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Page->subcat_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fsubcat_iso27001_linkslist","load"], function() {
    fsubcat_iso27001_linkslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_subcat_iso27001_links", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_id" class="form-group"></span>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->iso27001_code->Visible) { // iso27001_code ?>
        <td data-name="iso27001_code" <?= $Page->iso27001_code->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->iso27001_code->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_iso27001_code" class="form-group">
<span<?= $Page->iso27001_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iso27001_code->getDisplayValue($Page->iso27001_code->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_iso27001_code" name="x<?= $Page->RowIndex ?>_iso27001_code" value="<?= HtmlEncode($Page->iso27001_code->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_iso27001_code" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_iso27001_code"
        name="x<?= $Page->RowIndex ?>_iso27001_code"
        class="form-control ew-select<?= $Page->iso27001_code->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code"
        data-table="subcat_iso27001_links"
        data-field="x_iso27001_code"
        data-value-separator="<?= $Page->iso27001_code->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->iso27001_code->getPlaceHolder()) ?>"
        <?= $Page->iso27001_code->editAttributes() ?>>
        <?= $Page->iso27001_code->selectOptionListHtml("x{$Page->RowIndex}_iso27001_code") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->iso27001_code->getErrorMessage() ?></div>
<?= $Page->iso27001_code->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_iso27001_code") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code']"),
        options = { name: "x<?= $Page->RowIndex ?>_iso27001_code", selectId: "subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.iso27001_code.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_iso27001_code" data-hidden="1" name="o<?= $Page->RowIndex ?>_iso27001_code" id="o<?= $Page->RowIndex ?>_iso27001_code" value="<?= HtmlEncode($Page->iso27001_code->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_iso27001_code">
<span<?= $Page->iso27001_code->viewAttributes() ?>>
<?= $Page->iso27001_code->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->subcat_id->Visible) { // subcat_id ?>
        <td data-name="subcat_id" <?= $Page->subcat_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->subcat_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_subcat_id" class="form-group">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subcat_id->getDisplayValue($Page->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_subcat_id" name="x<?= $Page->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Page->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_subcat_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_subcat_id"
        name="x<?= $Page->RowIndex ?>_subcat_id"
        class="form-control ew-select<?= $Page->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id"
        data-table="subcat_iso27001_links"
        data-field="x_subcat_id"
        data-value-separator="<?= $Page->subcat_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subcat_id->getPlaceHolder()) ?>"
        <?= $Page->subcat_id->editAttributes() ?>>
        <?= $Page->subcat_id->selectOptionListHtml("x{$Page->RowIndex}_subcat_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->subcat_id->getErrorMessage() ?></div>
<?= $Page->subcat_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_subcat_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_subcat_id", selectId: "subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_subcat_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_subcat_id" id="o<?= $Page->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Page->subcat_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_subcat_iso27001_links_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<?= $Page->subcat_id->getViewValue() ?></span>
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
loadjs.ready(["fsubcat_iso27001_linkslist","load"], function () {
    fsubcat_iso27001_linkslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_subcat_iso27001_links", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_subcat_iso27001_links_id" class="form-group subcat_iso27001_links_id"></span>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->iso27001_code->Visible) { // iso27001_code ?>
        <td data-name="iso27001_code">
<?php if ($Page->iso27001_code->getSessionValue() != "") { ?>
<span id="el$rowindex$_subcat_iso27001_links_iso27001_code" class="form-group subcat_iso27001_links_iso27001_code">
<span<?= $Page->iso27001_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iso27001_code->getDisplayValue($Page->iso27001_code->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_iso27001_code" name="x<?= $Page->RowIndex ?>_iso27001_code" value="<?= HtmlEncode($Page->iso27001_code->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_subcat_iso27001_links_iso27001_code" class="form-group subcat_iso27001_links_iso27001_code">
    <select
        id="x<?= $Page->RowIndex ?>_iso27001_code"
        name="x<?= $Page->RowIndex ?>_iso27001_code"
        class="form-control ew-select<?= $Page->iso27001_code->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code"
        data-table="subcat_iso27001_links"
        data-field="x_iso27001_code"
        data-value-separator="<?= $Page->iso27001_code->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->iso27001_code->getPlaceHolder()) ?>"
        <?= $Page->iso27001_code->editAttributes() ?>>
        <?= $Page->iso27001_code->selectOptionListHtml("x{$Page->RowIndex}_iso27001_code") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->iso27001_code->getErrorMessage() ?></div>
<?= $Page->iso27001_code->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_iso27001_code") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code']"),
        options = { name: "x<?= $Page->RowIndex ?>_iso27001_code", selectId: "subcat_iso27001_links_x<?= $Page->RowIndex ?>_iso27001_code", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.iso27001_code.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_iso27001_code" data-hidden="1" name="o<?= $Page->RowIndex ?>_iso27001_code" id="o<?= $Page->RowIndex ?>_iso27001_code" value="<?= HtmlEncode($Page->iso27001_code->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->subcat_id->Visible) { // subcat_id ?>
        <td data-name="subcat_id">
<?php if ($Page->subcat_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_subcat_iso27001_links_subcat_id" class="form-group subcat_iso27001_links_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subcat_id->getDisplayValue($Page->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_subcat_id" name="x<?= $Page->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Page->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_subcat_iso27001_links_subcat_id" class="form-group subcat_iso27001_links_subcat_id">
    <select
        id="x<?= $Page->RowIndex ?>_subcat_id"
        name="x<?= $Page->RowIndex ?>_subcat_id"
        class="form-control ew-select<?= $Page->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id"
        data-table="subcat_iso27001_links"
        data-field="x_subcat_id"
        data-value-separator="<?= $Page->subcat_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subcat_id->getPlaceHolder()) ?>"
        <?= $Page->subcat_id->editAttributes() ?>>
        <?= $Page->subcat_id->selectOptionListHtml("x{$Page->RowIndex}_subcat_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->subcat_id->getErrorMessage() ?></div>
<?= $Page->subcat_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_subcat_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_subcat_id", selectId: "subcat_iso27001_links_x<?= $Page->RowIndex ?>_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_subcat_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_subcat_id" id="o<?= $Page->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Page->subcat_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fsubcat_iso27001_linkslist","load"], function() {
    fsubcat_iso27001_linkslist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("subcat_iso27001_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>