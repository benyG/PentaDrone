<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionsLibraryList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestions_librarylist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fquestions_librarylist = currentForm = new ew.Form("fquestions_librarylist", "list");
    fquestions_librarylist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "questions_library")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.questions_library)
        ew.vars.tables.questions_library = currentTable;
    fquestions_librarylist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["libelle", [fields.libelle.visible && fields.libelle.required ? ew.Validators.required(fields.libelle.caption) : null], fields.libelle.isInvalid],
        ["controlObj_id", [fields.controlObj_id.visible && fields.controlObj_id.required ? ew.Validators.required(fields.controlObj_id.caption) : null], fields.controlObj_id.isInvalid],
        ["refs1", [fields.refs1.visible && fields.refs1.required ? ew.Validators.required(fields.refs1.caption) : null], fields.refs1.isInvalid],
        ["refs2", [fields.refs2.visible && fields.refs2.required ? ew.Validators.required(fields.refs2.caption) : null], fields.refs2.isInvalid],
        ["Activation_status", [fields.Activation_status.visible && fields.Activation_status.required ? ew.Validators.required(fields.Activation_status.caption) : null, ew.Validators.integer], fields.Activation_status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestions_librarylist,
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
    fquestions_librarylist.validate = function () {
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
    fquestions_librarylist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "libelle", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "controlObj_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "refs1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "refs2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Activation_status", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fquestions_librarylist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestions_librarylist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fquestions_librarylist.lists.controlObj_id = <?= $Page->controlObj_id->toClientList($Page) ?>;
    loadjs.done("fquestions_librarylist");
});
var fquestions_librarylistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fquestions_librarylistsrch = currentSearchForm = new ew.Form("fquestions_librarylistsrch");

    // Dynamic selection lists

    // Filters
    fquestions_librarylistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fquestions_librarylistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "nist_to_iso27001") {
    if ($Page->MasterRecordExists) {
        include_once "views/NistToIso27001Master.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "question_controlobjectives") {
    if ($Page->MasterRecordExists) {
        include_once "views/QuestionControlobjectivesMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fquestions_librarylistsrch" id="fquestions_librarylistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fquestions_librarylistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="questions_library">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> questions_library">
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
<form name="fquestions_librarylist" id="fquestions_librarylist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="questions_library">
<?php if ($Page->getCurrentMasterTable() == "iso27001_refs" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="iso27001_refs">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->refs1->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "nist_to_iso27001" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nist_to_iso27001">
<input type="hidden" name="fk_just_for_question_link" value="<?= HtmlEncode($Page->refs1->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "question_controlobjectives" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="question_controlobjectives">
<input type="hidden" name="fk_controlObj_name" value="<?= HtmlEncode($Page->controlObj_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_questions_library" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_questions_librarylist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_questions_library_id" class="questions_library_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->libelle->Visible) { // libelle ?>
        <th data-name="libelle" class="<?= $Page->libelle->headerCellClass() ?>"><div id="elh_questions_library_libelle" class="questions_library_libelle"><?= $Page->renderSort($Page->libelle) ?></div></th>
<?php } ?>
<?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
        <th data-name="controlObj_id" class="<?= $Page->controlObj_id->headerCellClass() ?>"><div id="elh_questions_library_controlObj_id" class="questions_library_controlObj_id"><?= $Page->renderSort($Page->controlObj_id) ?></div></th>
<?php } ?>
<?php if ($Page->refs1->Visible) { // refs1 ?>
        <th data-name="refs1" class="<?= $Page->refs1->headerCellClass() ?>"><div id="elh_questions_library_refs1" class="questions_library_refs1"><?= $Page->renderSort($Page->refs1) ?></div></th>
<?php } ?>
<?php if ($Page->refs2->Visible) { // refs2 ?>
        <th data-name="refs2" class="<?= $Page->refs2->headerCellClass() ?>"><div id="elh_questions_library_refs2" class="questions_library_refs2"><?= $Page->renderSort($Page->refs2) ?></div></th>
<?php } ?>
<?php if ($Page->Activation_status->Visible) { // Activation_status ?>
        <th data-name="Activation_status" class="<?= $Page->Activation_status->headerCellClass() ?>"><div id="elh_questions_library_Activation_status" class="questions_library_Activation_status"><?= $Page->renderSort($Page->Activation_status) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_questions_library", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el<?= $Page->RowCount ?>_questions_library_id" class="form-group questions_library_id"></span>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->libelle->Visible) { // libelle ?>
        <td data-name="libelle">
<span id="el<?= $Page->RowCount ?>_questions_library_libelle" class="form-group questions_library_libelle">
<input type="<?= $Page->libelle->getInputTextType() ?>" data-table="questions_library" data-field="x_libelle" name="x<?= $Page->RowIndex ?>_libelle" id="x<?= $Page->RowIndex ?>_libelle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->libelle->getPlaceHolder()) ?>" value="<?= $Page->libelle->EditValue ?>"<?= $Page->libelle->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->libelle->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="o<?= $Page->RowIndex ?>_libelle" id="o<?= $Page->RowIndex ?>_libelle" value="<?= HtmlEncode($Page->libelle->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
        <td data-name="controlObj_id">
<?php if ($Page->controlObj_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_controlObj_id" class="form-group questions_library_controlObj_id">
<span<?= $Page->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->controlObj_id->getDisplayValue($Page->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_controlObj_id" name="x<?= $Page->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Page->controlObj_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_controlObj_id" class="form-group questions_library_controlObj_id">
    <select
        id="x<?= $Page->RowIndex ?>_controlObj_id"
        name="x<?= $Page->RowIndex ?>_controlObj_id"
        class="form-control ew-select<?= $Page->controlObj_id->isInvalidClass() ?>"
        data-select2-id="questions_library_x<?= $Page->RowIndex ?>_controlObj_id"
        data-table="questions_library"
        data-field="x_controlObj_id"
        data-value-separator="<?= $Page->controlObj_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->controlObj_id->getPlaceHolder()) ?>"
        <?= $Page->controlObj_id->editAttributes() ?>>
        <?= $Page->controlObj_id->selectOptionListHtml("x{$Page->RowIndex}_controlObj_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->controlObj_id->getErrorMessage() ?></div>
<?= $Page->controlObj_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_controlObj_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='questions_library_x<?= $Page->RowIndex ?>_controlObj_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_controlObj_id", selectId: "questions_library_x<?= $Page->RowIndex ?>_controlObj_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.questions_library.fields.controlObj_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_controlObj_id" id="o<?= $Page->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Page->controlObj_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->refs1->Visible) { // refs1 ?>
        <td data-name="refs1">
<?php if ($Page->refs1->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_refs1" class="form-group questions_library_refs1">
<span<?= $Page->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->refs1->getDisplayValue($Page->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_refs1" name="x<?= $Page->RowIndex ?>_refs1" value="<?= HtmlEncode($Page->refs1->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_refs1" class="form-group questions_library_refs1">
<input type="<?= $Page->refs1->getInputTextType() ?>" data-table="questions_library" data-field="x_refs1" name="x<?= $Page->RowIndex ?>_refs1" id="x<?= $Page->RowIndex ?>_refs1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs1->getPlaceHolder()) ?>" value="<?= $Page->refs1->EditValue ?>"<?= $Page->refs1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->refs1->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="o<?= $Page->RowIndex ?>_refs1" id="o<?= $Page->RowIndex ?>_refs1" value="<?= HtmlEncode($Page->refs1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->refs2->Visible) { // refs2 ?>
        <td data-name="refs2">
<span id="el<?= $Page->RowCount ?>_questions_library_refs2" class="form-group questions_library_refs2">
<input type="<?= $Page->refs2->getInputTextType() ?>" data-table="questions_library" data-field="x_refs2" name="x<?= $Page->RowIndex ?>_refs2" id="x<?= $Page->RowIndex ?>_refs2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs2->getPlaceHolder()) ?>" value="<?= $Page->refs2->EditValue ?>"<?= $Page->refs2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->refs2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="o<?= $Page->RowIndex ?>_refs2" id="o<?= $Page->RowIndex ?>_refs2" value="<?= HtmlEncode($Page->refs2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Activation_status->Visible) { // Activation_status ?>
        <td data-name="Activation_status">
<span id="el<?= $Page->RowCount ?>_questions_library_Activation_status" class="form-group questions_library_Activation_status">
<input type="<?= $Page->Activation_status->getInputTextType() ?>" data-table="questions_library" data-field="x_Activation_status" name="x<?= $Page->RowIndex ?>_Activation_status" id="x<?= $Page->RowIndex ?>_Activation_status" size="30" placeholder="<?= HtmlEncode($Page->Activation_status->getPlaceHolder()) ?>" value="<?= $Page->Activation_status->EditValue ?>"<?= $Page->Activation_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Activation_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="o<?= $Page->RowIndex ?>_Activation_status" id="o<?= $Page->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Page->Activation_status->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fquestions_librarylist","load"], function() {
    fquestions_librarylist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_questions_library", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_questions_library_id" class="form-group"></span>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->libelle->Visible) { // libelle ?>
        <td data-name="libelle" <?= $Page->libelle->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_libelle" class="form-group">
<input type="<?= $Page->libelle->getInputTextType() ?>" data-table="questions_library" data-field="x_libelle" name="x<?= $Page->RowIndex ?>_libelle" id="x<?= $Page->RowIndex ?>_libelle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->libelle->getPlaceHolder()) ?>" value="<?= $Page->libelle->EditValue ?>"<?= $Page->libelle->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->libelle->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="o<?= $Page->RowIndex ?>_libelle" id="o<?= $Page->RowIndex ?>_libelle" value="<?= HtmlEncode($Page->libelle->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_libelle">
<span<?= $Page->libelle->viewAttributes() ?>>
<?= $Page->libelle->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
        <td data-name="controlObj_id" <?= $Page->controlObj_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->controlObj_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_controlObj_id" class="form-group">
<span<?= $Page->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->controlObj_id->getDisplayValue($Page->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_controlObj_id" name="x<?= $Page->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Page->controlObj_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_controlObj_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_controlObj_id"
        name="x<?= $Page->RowIndex ?>_controlObj_id"
        class="form-control ew-select<?= $Page->controlObj_id->isInvalidClass() ?>"
        data-select2-id="questions_library_x<?= $Page->RowIndex ?>_controlObj_id"
        data-table="questions_library"
        data-field="x_controlObj_id"
        data-value-separator="<?= $Page->controlObj_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->controlObj_id->getPlaceHolder()) ?>"
        <?= $Page->controlObj_id->editAttributes() ?>>
        <?= $Page->controlObj_id->selectOptionListHtml("x{$Page->RowIndex}_controlObj_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->controlObj_id->getErrorMessage() ?></div>
<?= $Page->controlObj_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_controlObj_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='questions_library_x<?= $Page->RowIndex ?>_controlObj_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_controlObj_id", selectId: "questions_library_x<?= $Page->RowIndex ?>_controlObj_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.questions_library.fields.controlObj_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_controlObj_id" id="o<?= $Page->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Page->controlObj_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_controlObj_id">
<span<?= $Page->controlObj_id->viewAttributes() ?>>
<?= $Page->controlObj_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->refs1->Visible) { // refs1 ?>
        <td data-name="refs1" <?= $Page->refs1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->refs1->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_refs1" class="form-group">
<span<?= $Page->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->refs1->getDisplayValue($Page->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_refs1" name="x<?= $Page->RowIndex ?>_refs1" value="<?= HtmlEncode($Page->refs1->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_questions_library_refs1" class="form-group">
<input type="<?= $Page->refs1->getInputTextType() ?>" data-table="questions_library" data-field="x_refs1" name="x<?= $Page->RowIndex ?>_refs1" id="x<?= $Page->RowIndex ?>_refs1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs1->getPlaceHolder()) ?>" value="<?= $Page->refs1->EditValue ?>"<?= $Page->refs1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->refs1->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="o<?= $Page->RowIndex ?>_refs1" id="o<?= $Page->RowIndex ?>_refs1" value="<?= HtmlEncode($Page->refs1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_refs1">
<span<?= $Page->refs1->viewAttributes() ?>>
<?= $Page->refs1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->refs2->Visible) { // refs2 ?>
        <td data-name="refs2" <?= $Page->refs2->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_refs2" class="form-group">
<input type="<?= $Page->refs2->getInputTextType() ?>" data-table="questions_library" data-field="x_refs2" name="x<?= $Page->RowIndex ?>_refs2" id="x<?= $Page->RowIndex ?>_refs2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs2->getPlaceHolder()) ?>" value="<?= $Page->refs2->EditValue ?>"<?= $Page->refs2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->refs2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="o<?= $Page->RowIndex ?>_refs2" id="o<?= $Page->RowIndex ?>_refs2" value="<?= HtmlEncode($Page->refs2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_refs2">
<span<?= $Page->refs2->viewAttributes() ?>>
<?= $Page->refs2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Activation_status->Visible) { // Activation_status ?>
        <td data-name="Activation_status" <?= $Page->Activation_status->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_Activation_status" class="form-group">
<input type="<?= $Page->Activation_status->getInputTextType() ?>" data-table="questions_library" data-field="x_Activation_status" name="x<?= $Page->RowIndex ?>_Activation_status" id="x<?= $Page->RowIndex ?>_Activation_status" size="30" placeholder="<?= HtmlEncode($Page->Activation_status->getPlaceHolder()) ?>" value="<?= $Page->Activation_status->EditValue ?>"<?= $Page->Activation_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Activation_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="o<?= $Page->RowIndex ?>_Activation_status" id="o<?= $Page->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Page->Activation_status->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_questions_library_Activation_status">
<span<?= $Page->Activation_status->viewAttributes() ?>>
<?= $Page->Activation_status->getViewValue() ?></span>
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
loadjs.ready(["fquestions_librarylist","load"], function () {
    fquestions_librarylist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_questions_library", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_questions_library_id" class="form-group questions_library_id"></span>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->libelle->Visible) { // libelle ?>
        <td data-name="libelle">
<span id="el$rowindex$_questions_library_libelle" class="form-group questions_library_libelle">
<input type="<?= $Page->libelle->getInputTextType() ?>" data-table="questions_library" data-field="x_libelle" name="x<?= $Page->RowIndex ?>_libelle" id="x<?= $Page->RowIndex ?>_libelle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->libelle->getPlaceHolder()) ?>" value="<?= $Page->libelle->EditValue ?>"<?= $Page->libelle->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->libelle->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="o<?= $Page->RowIndex ?>_libelle" id="o<?= $Page->RowIndex ?>_libelle" value="<?= HtmlEncode($Page->libelle->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
        <td data-name="controlObj_id">
<?php if ($Page->controlObj_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_questions_library_controlObj_id" class="form-group questions_library_controlObj_id">
<span<?= $Page->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->controlObj_id->getDisplayValue($Page->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_controlObj_id" name="x<?= $Page->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Page->controlObj_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_questions_library_controlObj_id" class="form-group questions_library_controlObj_id">
    <select
        id="x<?= $Page->RowIndex ?>_controlObj_id"
        name="x<?= $Page->RowIndex ?>_controlObj_id"
        class="form-control ew-select<?= $Page->controlObj_id->isInvalidClass() ?>"
        data-select2-id="questions_library_x<?= $Page->RowIndex ?>_controlObj_id"
        data-table="questions_library"
        data-field="x_controlObj_id"
        data-value-separator="<?= $Page->controlObj_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->controlObj_id->getPlaceHolder()) ?>"
        <?= $Page->controlObj_id->editAttributes() ?>>
        <?= $Page->controlObj_id->selectOptionListHtml("x{$Page->RowIndex}_controlObj_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->controlObj_id->getErrorMessage() ?></div>
<?= $Page->controlObj_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_controlObj_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='questions_library_x<?= $Page->RowIndex ?>_controlObj_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_controlObj_id", selectId: "questions_library_x<?= $Page->RowIndex ?>_controlObj_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.questions_library.fields.controlObj_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_controlObj_id" id="o<?= $Page->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Page->controlObj_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->refs1->Visible) { // refs1 ?>
        <td data-name="refs1">
<?php if ($Page->refs1->getSessionValue() != "") { ?>
<span id="el$rowindex$_questions_library_refs1" class="form-group questions_library_refs1">
<span<?= $Page->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->refs1->getDisplayValue($Page->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_refs1" name="x<?= $Page->RowIndex ?>_refs1" value="<?= HtmlEncode($Page->refs1->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_questions_library_refs1" class="form-group questions_library_refs1">
<input type="<?= $Page->refs1->getInputTextType() ?>" data-table="questions_library" data-field="x_refs1" name="x<?= $Page->RowIndex ?>_refs1" id="x<?= $Page->RowIndex ?>_refs1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs1->getPlaceHolder()) ?>" value="<?= $Page->refs1->EditValue ?>"<?= $Page->refs1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->refs1->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="o<?= $Page->RowIndex ?>_refs1" id="o<?= $Page->RowIndex ?>_refs1" value="<?= HtmlEncode($Page->refs1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->refs2->Visible) { // refs2 ?>
        <td data-name="refs2">
<span id="el$rowindex$_questions_library_refs2" class="form-group questions_library_refs2">
<input type="<?= $Page->refs2->getInputTextType() ?>" data-table="questions_library" data-field="x_refs2" name="x<?= $Page->RowIndex ?>_refs2" id="x<?= $Page->RowIndex ?>_refs2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs2->getPlaceHolder()) ?>" value="<?= $Page->refs2->EditValue ?>"<?= $Page->refs2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->refs2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="o<?= $Page->RowIndex ?>_refs2" id="o<?= $Page->RowIndex ?>_refs2" value="<?= HtmlEncode($Page->refs2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Activation_status->Visible) { // Activation_status ?>
        <td data-name="Activation_status">
<span id="el$rowindex$_questions_library_Activation_status" class="form-group questions_library_Activation_status">
<input type="<?= $Page->Activation_status->getInputTextType() ?>" data-table="questions_library" data-field="x_Activation_status" name="x<?= $Page->RowIndex ?>_Activation_status" id="x<?= $Page->RowIndex ?>_Activation_status" size="30" placeholder="<?= HtmlEncode($Page->Activation_status->getPlaceHolder()) ?>" value="<?= $Page->Activation_status->EditValue ?>"<?= $Page->Activation_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Activation_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="o<?= $Page->RowIndex ?>_Activation_status" id="o<?= $Page->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Page->Activation_status->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fquestions_librarylist","load"], function() {
    fquestions_librarylist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("questions_library");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
