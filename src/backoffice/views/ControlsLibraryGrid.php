<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Set up and run Grid object
$Grid = Container("ControlsLibraryGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcontrols_librarygrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fcontrols_librarygrid = new ew.Form("fcontrols_librarygrid", "grid");
    fcontrols_librarygrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "controls_library")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.controls_library)
        ew.vars.tables.controls_library = currentTable;
    fcontrols_librarygrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["nist_subcategory_id", [fields.nist_subcategory_id.visible && fields.nist_subcategory_id.required ? ew.Validators.required(fields.nist_subcategory_id.caption) : null, ew.Validators.integer], fields.nist_subcategory_id.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcontrols_librarygrid,
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
    fcontrols_librarygrid.validate = function () {
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
        return true;
    }

    // Check empty row
    fcontrols_librarygrid.emptyRow = function (rowIndex) {
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
    fcontrols_librarygrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcontrols_librarygrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcontrols_librarygrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> controls_library">
<div id="fcontrols_librarygrid" class="ew-form ew-list-form form-inline">
<div id="gmp_controls_library" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_controls_librarygrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_controls_library_id" class="controls_library_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <th data-name="nist_subcategory_id" class="<?= $Grid->nist_subcategory_id->headerCellClass() ?>"><div id="elh_controls_library_nist_subcategory_id" class="controls_library_nist_subcategory_id"><?= $Grid->renderSort($Grid->nist_subcategory_id) ?></div></th>
<?php } ?>
<?php if ($Grid->title->Visible) { // title ?>
        <th data-name="title" class="<?= $Grid->title->headerCellClass() ?>"><div id="elh_controls_library_title" class="controls_library_title"><?= $Grid->renderSort($Grid->title) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_controls_library_created_at" class="controls_library_created_at"><?= $Grid->renderSort($Grid->created_at) ?></div></th>
<?php } ?>
<?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Grid->updated_at->headerCellClass() ?>"><div id="elh_controls_library_updated_at" class="controls_library_updated_at"><?= $Grid->renderSort($Grid->updated_at) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_controls_library", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id" <?= $Grid->id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_id" class="form-group"></span>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_id" id="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_id" id="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <td data-name="nist_subcategory_id" <?= $Grid->nist_subcategory_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->nist_subcategory_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_nist_subcategory_id" class="form-group">
<span<?= $Grid->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nist_subcategory_id->getDisplayValue($Grid->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_nist_subcategory_id" name="x<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_nist_subcategory_id" class="form-group">
<input type="<?= $Grid->nist_subcategory_id->getInputTextType() ?>" data-table="controls_library" data-field="x_nist_subcategory_id" name="x<?= $Grid->RowIndex ?>_nist_subcategory_id" id="x<?= $Grid->RowIndex ?>_nist_subcategory_id" size="30" placeholder="<?= HtmlEncode($Grid->nist_subcategory_id->getPlaceHolder()) ?>" value="<?= $Grid->nist_subcategory_id->EditValue ?>"<?= $Grid->nist_subcategory_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nist_subcategory_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nist_subcategory_id" id="o<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->nist_subcategory_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_nist_subcategory_id" class="form-group">
<span<?= $Grid->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nist_subcategory_id->getDisplayValue($Grid->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_nist_subcategory_id" name="x<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_nist_subcategory_id" class="form-group">
<input type="<?= $Grid->nist_subcategory_id->getInputTextType() ?>" data-table="controls_library" data-field="x_nist_subcategory_id" name="x<?= $Grid->RowIndex ?>_nist_subcategory_id" id="x<?= $Grid->RowIndex ?>_nist_subcategory_id" size="30" placeholder="<?= HtmlEncode($Grid->nist_subcategory_id->getPlaceHolder()) ?>" value="<?= $Grid->nist_subcategory_id->EditValue ?>"<?= $Grid->nist_subcategory_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nist_subcategory_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_nist_subcategory_id">
<span<?= $Grid->nist_subcategory_id->viewAttributes() ?>>
<?= $Grid->nist_subcategory_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_nist_subcategory_id" id="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->FormValue) ?>">
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_nist_subcategory_id" id="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->title->Visible) { // title ?>
        <td data-name="title" <?= $Grid->title->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_title" class="form-group">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="controls_library" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_title" id="o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_title" class="form-group">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="controls_library" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_title">
<span<?= $Grid->title->viewAttributes() ?>>
<?= $Grid->title->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_title" id="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->FormValue) ?>">
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_title" id="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="controls_library" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarygrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarygrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="controls_library" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarygrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarygrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_created_at" id="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_created_at" id="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at" <?= $Grid->updated_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_updated_at" class="form-group">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="controls_library" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarygrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarygrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_updated_at" id="o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_updated_at" class="form-group">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="controls_library" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarygrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarygrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_controls_library_updated_at">
<span<?= $Grid->updated_at->viewAttributes() ?>>
<?= $Grid->updated_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_updated_at" id="fcontrols_librarygrid$x<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->FormValue) ?>">
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_updated_at" id="fcontrols_librarygrid$o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fcontrols_librarygrid","load"], function () {
    fcontrols_librarygrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_controls_library", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_controls_library_id" class="form-group controls_library_id"></span>
<?php } else { ?>
<span id="el$rowindex$_controls_library_id" class="form-group controls_library_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <td data-name="nist_subcategory_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->nist_subcategory_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_controls_library_nist_subcategory_id" class="form-group controls_library_nist_subcategory_id">
<span<?= $Grid->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nist_subcategory_id->getDisplayValue($Grid->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_nist_subcategory_id" name="x<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_controls_library_nist_subcategory_id" class="form-group controls_library_nist_subcategory_id">
<input type="<?= $Grid->nist_subcategory_id->getInputTextType() ?>" data-table="controls_library" data-field="x_nist_subcategory_id" name="x<?= $Grid->RowIndex ?>_nist_subcategory_id" id="x<?= $Grid->RowIndex ?>_nist_subcategory_id" size="30" placeholder="<?= HtmlEncode($Grid->nist_subcategory_id->getPlaceHolder()) ?>" value="<?= $Grid->nist_subcategory_id->EditValue ?>"<?= $Grid->nist_subcategory_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nist_subcategory_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_controls_library_nist_subcategory_id" class="form-group controls_library_nist_subcategory_id">
<span<?= $Grid->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nist_subcategory_id->getDisplayValue($Grid->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nist_subcategory_id" id="x<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_nist_subcategory_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nist_subcategory_id" id="o<?= $Grid->RowIndex ?>_nist_subcategory_id" value="<?= HtmlEncode($Grid->nist_subcategory_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->title->Visible) { // title ?>
        <td data-name="title">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_controls_library_title" class="form-group controls_library_title">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="controls_library" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_controls_library_title" class="form-group controls_library_title">
<span<?= $Grid->title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->title->getDisplayValue($Grid->title->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_title" id="o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_controls_library_created_at" class="form-group controls_library_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="controls_library" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarygrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarygrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_controls_library_created_at" class="form-group controls_library_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_at->getDisplayValue($Grid->created_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_controls_library_updated_at" class="form-group controls_library_updated_at">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="controls_library" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_librarygrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_librarygrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_controls_library_updated_at" class="form-group controls_library_updated_at">
<span<?= $Grid->updated_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->updated_at->getDisplayValue($Grid->updated_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="controls_library" data-field="x_updated_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_updated_at" id="o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fcontrols_librarygrid","load"], function() {
    fcontrols_librarygrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcontrols_librarygrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
