<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistRefsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnist_refslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnist_refslist = currentForm = new ew.Form("fnist_refslist", "list");
    fnist_refslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "nist_refs")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.nist_refs)
        ew.vars.tables.nist_refs = currentTable;
    fnist_refslist.addFields([
        ["Nidentifier", [fields.Nidentifier.visible && fields.Nidentifier.required ? ew.Validators.required(fields.Nidentifier.caption) : null], fields.Nidentifier.isInvalid],
        ["N_ordre", [fields.N_ordre.visible && fields.N_ordre.required ? ew.Validators.required(fields.N_ordre.caption) : null, ew.Validators.integer], fields.N_ordre.isInvalid],
        ["Control_Family_id", [fields.Control_Family_id.visible && fields.Control_Family_id.required ? ew.Validators.required(fields.Control_Family_id.caption) : null], fields.Control_Family_id.isInvalid],
        ["Control_Name", [fields.Control_Name.visible && fields.Control_Name.required ? ew.Validators.required(fields.Control_Name.caption) : null], fields.Control_Name.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnist_refslist,
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
    fnist_refslist.validate = function () {
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
    fnist_refslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "Nidentifier", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "N_ordre", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Control_Family_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Control_Name", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnist_refslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnist_refslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnist_refslist");
});
var fnist_refslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnist_refslistsrch = currentSearchForm = new ew.Form("fnist_refslistsrch");

    // Dynamic selection lists

    // Filters
    fnist_refslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnist_refslistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "nist_refs_controlfamily") {
    if ($Page->MasterRecordExists) {
        include_once "views/NistRefsControlfamilyMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fnist_refslistsrch" id="fnist_refslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fnist_refslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="nist_refs">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> nist_refs">
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
<form name="fnist_refslist" id="fnist_refslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_refs">
<?php if ($Page->getCurrentMasterTable() == "nist_refs_controlfamily" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nist_refs_controlfamily">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->Control_Family_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_nist_refs" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_nist_refslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="Nidentifier" class="<?= $Page->Nidentifier->headerCellClass() ?>"><div id="elh_nist_refs_Nidentifier" class="nist_refs_Nidentifier"><?= $Page->renderSort($Page->Nidentifier) ?></div></th>
<?php } ?>
<?php if ($Page->N_ordre->Visible) { // N_ordre ?>
        <th data-name="N_ordre" class="<?= $Page->N_ordre->headerCellClass() ?>"><div id="elh_nist_refs_N_ordre" class="nist_refs_N_ordre"><?= $Page->renderSort($Page->N_ordre) ?></div></th>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <th data-name="Control_Family_id" class="<?= $Page->Control_Family_id->headerCellClass() ?>"><div id="elh_nist_refs_Control_Family_id" class="nist_refs_Control_Family_id"><?= $Page->renderSort($Page->Control_Family_id) ?></div></th>
<?php } ?>
<?php if ($Page->Control_Name->Visible) { // Control_Name ?>
        <th data-name="Control_Name" class="<?= $Page->Control_Name->headerCellClass() ?>"><div id="elh_nist_refs_Control_Name" class="nist_refs_Control_Name"><?= $Page->renderSort($Page->Control_Name) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_nist_refs", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
        <td data-name="Nidentifier">
<span id="el<?= $Page->RowCount ?>_nist_refs_Nidentifier" class="form-group nist_refs_Nidentifier">
<input type="<?= $Page->Nidentifier->getInputTextType() ?>" data-table="nist_refs" data-field="x_Nidentifier" name="x<?= $Page->RowIndex ?>_Nidentifier" id="x<?= $Page->RowIndex ?>_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->Nidentifier->getPlaceHolder()) ?>" value="<?= $Page->Nidentifier->EditValue ?>"<?= $Page->Nidentifier->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nidentifier->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_Nidentifier" data-hidden="1" name="o<?= $Page->RowIndex ?>_Nidentifier" id="o<?= $Page->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Page->Nidentifier->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->N_ordre->Visible) { // N_ordre ?>
        <td data-name="N_ordre">
<span id="el<?= $Page->RowCount ?>_nist_refs_N_ordre" class="form-group nist_refs_N_ordre">
<input type="<?= $Page->N_ordre->getInputTextType() ?>" data-table="nist_refs" data-field="x_N_ordre" name="x<?= $Page->RowIndex ?>_N_ordre" id="x<?= $Page->RowIndex ?>_N_ordre" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->N_ordre->getPlaceHolder()) ?>" value="<?= $Page->N_ordre->EditValue ?>"<?= $Page->N_ordre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->N_ordre->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_N_ordre" data-hidden="1" name="o<?= $Page->RowIndex ?>_N_ordre" id="o<?= $Page->RowIndex ?>_N_ordre" value="<?= HtmlEncode($Page->N_ordre->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <td data-name="Control_Family_id">
<?php if ($Page->Control_Family_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Family_id" class="form-group nist_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Control_Family_id->getDisplayValue($Page->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Control_Family_id" name="x<?= $Page->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Family_id" class="form-group nist_refs_Control_Family_id">
<input type="<?= $Page->Control_Family_id->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Family_id" name="x<?= $Page->RowIndex ?>_Control_Family_id" id="x<?= $Page->RowIndex ?>_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Page->Control_Family_id->EditValue ?>"<?= $Page->Control_Family_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="nist_refs" data-field="x_Control_Family_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_Control_Family_id" id="o<?= $Page->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Control_Name->Visible) { // Control_Name ?>
        <td data-name="Control_Name">
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Name" class="form-group nist_refs_Control_Name">
<input type="<?= $Page->Control_Name->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Name" name="x<?= $Page->RowIndex ?>_Control_Name" id="x<?= $Page->RowIndex ?>_Control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Control_Name->getPlaceHolder()) ?>" value="<?= $Page->Control_Name->EditValue ?>"<?= $Page->Control_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Control_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_Control_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Control_Name" id="o<?= $Page->RowIndex ?>_Control_Name" value="<?= HtmlEncode($Page->Control_Name->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fnist_refslist","load"], function() {
    fnist_refslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_nist_refs", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
        <td data-name="Nidentifier" <?= $Page->Nidentifier->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Nidentifier" class="form-group">
<input type="<?= $Page->Nidentifier->getInputTextType() ?>" data-table="nist_refs" data-field="x_Nidentifier" name="x<?= $Page->RowIndex ?>_Nidentifier" id="x<?= $Page->RowIndex ?>_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->Nidentifier->getPlaceHolder()) ?>" value="<?= $Page->Nidentifier->EditValue ?>"<?= $Page->Nidentifier->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nidentifier->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_Nidentifier" data-hidden="1" name="o<?= $Page->RowIndex ?>_Nidentifier" id="o<?= $Page->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Page->Nidentifier->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Nidentifier">
<span<?= $Page->Nidentifier->viewAttributes() ?>>
<?= $Page->Nidentifier->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->N_ordre->Visible) { // N_ordre ?>
        <td data-name="N_ordre" <?= $Page->N_ordre->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_N_ordre" class="form-group">
<input type="<?= $Page->N_ordre->getInputTextType() ?>" data-table="nist_refs" data-field="x_N_ordre" name="x<?= $Page->RowIndex ?>_N_ordre" id="x<?= $Page->RowIndex ?>_N_ordre" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->N_ordre->getPlaceHolder()) ?>" value="<?= $Page->N_ordre->EditValue ?>"<?= $Page->N_ordre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->N_ordre->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_N_ordre" data-hidden="1" name="o<?= $Page->RowIndex ?>_N_ordre" id="o<?= $Page->RowIndex ?>_N_ordre" value="<?= HtmlEncode($Page->N_ordre->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_N_ordre">
<span<?= $Page->N_ordre->viewAttributes() ?>>
<?= $Page->N_ordre->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <td data-name="Control_Family_id" <?= $Page->Control_Family_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->Control_Family_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Family_id" class="form-group">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Control_Family_id->getDisplayValue($Page->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Control_Family_id" name="x<?= $Page->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Family_id" class="form-group">
<input type="<?= $Page->Control_Family_id->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Family_id" name="x<?= $Page->RowIndex ?>_Control_Family_id" id="x<?= $Page->RowIndex ?>_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Page->Control_Family_id->EditValue ?>"<?= $Page->Control_Family_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="nist_refs" data-field="x_Control_Family_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_Control_Family_id" id="o<?= $Page->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<?= $Page->Control_Family_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Control_Name->Visible) { // Control_Name ?>
        <td data-name="Control_Name" <?= $Page->Control_Name->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Name" class="form-group">
<input type="<?= $Page->Control_Name->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Name" name="x<?= $Page->RowIndex ?>_Control_Name" id="x<?= $Page->RowIndex ?>_Control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Control_Name->getPlaceHolder()) ?>" value="<?= $Page->Control_Name->EditValue ?>"<?= $Page->Control_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Control_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_Control_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Control_Name" id="o<?= $Page->RowIndex ?>_Control_Name" value="<?= HtmlEncode($Page->Control_Name->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_nist_refs_Control_Name">
<span<?= $Page->Control_Name->viewAttributes() ?>>
<?= $Page->Control_Name->getViewValue() ?></span>
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
loadjs.ready(["fnist_refslist","load"], function () {
    fnist_refslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_nist_refs", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
        <td data-name="Nidentifier">
<span id="el$rowindex$_nist_refs_Nidentifier" class="form-group nist_refs_Nidentifier">
<input type="<?= $Page->Nidentifier->getInputTextType() ?>" data-table="nist_refs" data-field="x_Nidentifier" name="x<?= $Page->RowIndex ?>_Nidentifier" id="x<?= $Page->RowIndex ?>_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->Nidentifier->getPlaceHolder()) ?>" value="<?= $Page->Nidentifier->EditValue ?>"<?= $Page->Nidentifier->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nidentifier->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_Nidentifier" data-hidden="1" name="o<?= $Page->RowIndex ?>_Nidentifier" id="o<?= $Page->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Page->Nidentifier->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->N_ordre->Visible) { // N_ordre ?>
        <td data-name="N_ordre">
<span id="el$rowindex$_nist_refs_N_ordre" class="form-group nist_refs_N_ordre">
<input type="<?= $Page->N_ordre->getInputTextType() ?>" data-table="nist_refs" data-field="x_N_ordre" name="x<?= $Page->RowIndex ?>_N_ordre" id="x<?= $Page->RowIndex ?>_N_ordre" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->N_ordre->getPlaceHolder()) ?>" value="<?= $Page->N_ordre->EditValue ?>"<?= $Page->N_ordre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->N_ordre->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_N_ordre" data-hidden="1" name="o<?= $Page->RowIndex ?>_N_ordre" id="o<?= $Page->RowIndex ?>_N_ordre" value="<?= HtmlEncode($Page->N_ordre->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
        <td data-name="Control_Family_id">
<?php if ($Page->Control_Family_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_nist_refs_Control_Family_id" class="form-group nist_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Control_Family_id->getDisplayValue($Page->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Control_Family_id" name="x<?= $Page->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_nist_refs_Control_Family_id" class="form-group nist_refs_Control_Family_id">
<input type="<?= $Page->Control_Family_id->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Family_id" name="x<?= $Page->RowIndex ?>_Control_Family_id" id="x<?= $Page->RowIndex ?>_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Page->Control_Family_id->EditValue ?>"<?= $Page->Control_Family_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="nist_refs" data-field="x_Control_Family_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_Control_Family_id" id="o<?= $Page->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Control_Name->Visible) { // Control_Name ?>
        <td data-name="Control_Name">
<span id="el$rowindex$_nist_refs_Control_Name" class="form-group nist_refs_Control_Name">
<input type="<?= $Page->Control_Name->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Name" name="x<?= $Page->RowIndex ?>_Control_Name" id="x<?= $Page->RowIndex ?>_Control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Control_Name->getPlaceHolder()) ?>" value="<?= $Page->Control_Name->EditValue ?>"<?= $Page->Control_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Control_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_refs" data-field="x_Control_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Control_Name" id="o<?= $Page->RowIndex ?>_Control_Name" value="<?= HtmlEncode($Page->Control_Name->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fnist_refslist","load"], function() {
    fnist_refslist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("nist_refs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
