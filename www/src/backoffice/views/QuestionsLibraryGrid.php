<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("QuestionsLibraryGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestions_librarygrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fquestions_librarygrid = new ew.Form("fquestions_librarygrid", "grid");
    fquestions_librarygrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "questions_library")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.questions_library)
        ew.vars.tables.questions_library = currentTable;
    fquestions_librarygrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["libelle", [fields.libelle.visible && fields.libelle.required ? ew.Validators.required(fields.libelle.caption) : null], fields.libelle.isInvalid],
        ["controlObj_id", [fields.controlObj_id.visible && fields.controlObj_id.required ? ew.Validators.required(fields.controlObj_id.caption) : null], fields.controlObj_id.isInvalid],
        ["refs1", [fields.refs1.visible && fields.refs1.required ? ew.Validators.required(fields.refs1.caption) : null], fields.refs1.isInvalid],
        ["refs2", [fields.refs2.visible && fields.refs2.required ? ew.Validators.required(fields.refs2.caption) : null], fields.refs2.isInvalid],
        ["Activation_status", [fields.Activation_status.visible && fields.Activation_status.required ? ew.Validators.required(fields.Activation_status.caption) : null, ew.Validators.integer], fields.Activation_status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestions_librarygrid,
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
    fquestions_librarygrid.validate = function () {
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
    fquestions_librarygrid.emptyRow = function (rowIndex) {
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
    fquestions_librarygrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestions_librarygrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fquestions_librarygrid.lists.controlObj_id = <?= $Grid->controlObj_id->toClientList($Grid) ?>;
    loadjs.done("fquestions_librarygrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> questions_library">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fquestions_librarygrid" class="ew-form ew-list-form form-inline">
<div id="gmp_questions_library" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_questions_librarygrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_questions_library_id" class="questions_library_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->libelle->Visible) { // libelle ?>
        <th data-name="libelle" class="<?= $Grid->libelle->headerCellClass() ?>"><div id="elh_questions_library_libelle" class="questions_library_libelle"><?= $Grid->renderSort($Grid->libelle) ?></div></th>
<?php } ?>
<?php if ($Grid->controlObj_id->Visible) { // controlObj_id ?>
        <th data-name="controlObj_id" class="<?= $Grid->controlObj_id->headerCellClass() ?>"><div id="elh_questions_library_controlObj_id" class="questions_library_controlObj_id"><?= $Grid->renderSort($Grid->controlObj_id) ?></div></th>
<?php } ?>
<?php if ($Grid->refs1->Visible) { // refs1 ?>
        <th data-name="refs1" class="<?= $Grid->refs1->headerCellClass() ?>"><div id="elh_questions_library_refs1" class="questions_library_refs1"><?= $Grid->renderSort($Grid->refs1) ?></div></th>
<?php } ?>
<?php if ($Grid->refs2->Visible) { // refs2 ?>
        <th data-name="refs2" class="<?= $Grid->refs2->headerCellClass() ?>"><div id="elh_questions_library_refs2" class="questions_library_refs2"><?= $Grid->renderSort($Grid->refs2) ?></div></th>
<?php } ?>
<?php if ($Grid->Activation_status->Visible) { // Activation_status ?>
        <th data-name="Activation_status" class="<?= $Grid->Activation_status->headerCellClass() ?>"><div id="elh_questions_library_Activation_status" class="questions_library_Activation_status"><?= $Grid->renderSort($Grid->Activation_status) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_questions_library", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_questions_library_id" class="form-group"></span>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_id" id="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_id" id="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->libelle->Visible) { // libelle ?>
        <td data-name="libelle" <?= $Grid->libelle->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_libelle" class="form-group">
<input type="<?= $Grid->libelle->getInputTextType() ?>" data-table="questions_library" data-field="x_libelle" name="x<?= $Grid->RowIndex ?>_libelle" id="x<?= $Grid->RowIndex ?>_libelle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->libelle->getPlaceHolder()) ?>" value="<?= $Grid->libelle->EditValue ?>"<?= $Grid->libelle->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->libelle->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="o<?= $Grid->RowIndex ?>_libelle" id="o<?= $Grid->RowIndex ?>_libelle" value="<?= HtmlEncode($Grid->libelle->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_libelle" class="form-group">
<input type="<?= $Grid->libelle->getInputTextType() ?>" data-table="questions_library" data-field="x_libelle" name="x<?= $Grid->RowIndex ?>_libelle" id="x<?= $Grid->RowIndex ?>_libelle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->libelle->getPlaceHolder()) ?>" value="<?= $Grid->libelle->EditValue ?>"<?= $Grid->libelle->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->libelle->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_libelle">
<span<?= $Grid->libelle->viewAttributes() ?>>
<?= $Grid->libelle->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_libelle" id="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_libelle" value="<?= HtmlEncode($Grid->libelle->FormValue) ?>">
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_libelle" id="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_libelle" value="<?= HtmlEncode($Grid->libelle->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->controlObj_id->Visible) { // controlObj_id ?>
        <td data-name="controlObj_id" <?= $Grid->controlObj_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->controlObj_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_controlObj_id" class="form-group">
<span<?= $Grid->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->controlObj_id->getDisplayValue($Grid->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_controlObj_id" name="x<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_controlObj_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_controlObj_id"
        name="x<?= $Grid->RowIndex ?>_controlObj_id"
        class="form-control ew-select<?= $Grid->controlObj_id->isInvalidClass() ?>"
        data-select2-id="questions_library_x<?= $Grid->RowIndex ?>_controlObj_id"
        data-table="questions_library"
        data-field="x_controlObj_id"
        data-value-separator="<?= $Grid->controlObj_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->controlObj_id->getPlaceHolder()) ?>"
        <?= $Grid->controlObj_id->editAttributes() ?>>
        <?= $Grid->controlObj_id->selectOptionListHtml("x{$Grid->RowIndex}_controlObj_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->controlObj_id->getErrorMessage() ?></div>
<?= $Grid->controlObj_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_controlObj_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='questions_library_x<?= $Grid->RowIndex ?>_controlObj_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_controlObj_id", selectId: "questions_library_x<?= $Grid->RowIndex ?>_controlObj_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.questions_library.fields.controlObj_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_controlObj_id" id="o<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->controlObj_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_controlObj_id" class="form-group">
<span<?= $Grid->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->controlObj_id->getDisplayValue($Grid->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_controlObj_id" name="x<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_controlObj_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_controlObj_id"
        name="x<?= $Grid->RowIndex ?>_controlObj_id"
        class="form-control ew-select<?= $Grid->controlObj_id->isInvalidClass() ?>"
        data-select2-id="questions_library_x<?= $Grid->RowIndex ?>_controlObj_id"
        data-table="questions_library"
        data-field="x_controlObj_id"
        data-value-separator="<?= $Grid->controlObj_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->controlObj_id->getPlaceHolder()) ?>"
        <?= $Grid->controlObj_id->editAttributes() ?>>
        <?= $Grid->controlObj_id->selectOptionListHtml("x{$Grid->RowIndex}_controlObj_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->controlObj_id->getErrorMessage() ?></div>
<?= $Grid->controlObj_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_controlObj_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='questions_library_x<?= $Grid->RowIndex ?>_controlObj_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_controlObj_id", selectId: "questions_library_x<?= $Grid->RowIndex ?>_controlObj_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.questions_library.fields.controlObj_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_controlObj_id">
<span<?= $Grid->controlObj_id->viewAttributes() ?>>
<?= $Grid->controlObj_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_controlObj_id" id="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->FormValue) ?>">
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_controlObj_id" id="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->refs1->Visible) { // refs1 ?>
        <td data-name="refs1" <?= $Grid->refs1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->refs1->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs1" class="form-group">
<span<?= $Grid->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->refs1->getDisplayValue($Grid->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_refs1" name="x<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs1" class="form-group">
<input type="<?= $Grid->refs1->getInputTextType() ?>" data-table="questions_library" data-field="x_refs1" name="x<?= $Grid->RowIndex ?>_refs1" id="x<?= $Grid->RowIndex ?>_refs1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->refs1->getPlaceHolder()) ?>" value="<?= $Grid->refs1->EditValue ?>"<?= $Grid->refs1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->refs1->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_refs1" id="o<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->refs1->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs1" class="form-group">
<span<?= $Grid->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->refs1->getDisplayValue($Grid->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_refs1" name="x<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs1" class="form-group">
<input type="<?= $Grid->refs1->getInputTextType() ?>" data-table="questions_library" data-field="x_refs1" name="x<?= $Grid->RowIndex ?>_refs1" id="x<?= $Grid->RowIndex ?>_refs1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->refs1->getPlaceHolder()) ?>" value="<?= $Grid->refs1->EditValue ?>"<?= $Grid->refs1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->refs1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs1">
<span<?= $Grid->refs1->viewAttributes() ?>>
<?= $Grid->refs1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_refs1" id="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->FormValue) ?>">
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_refs1" id="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->refs2->Visible) { // refs2 ?>
        <td data-name="refs2" <?= $Grid->refs2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs2" class="form-group">
<input type="<?= $Grid->refs2->getInputTextType() ?>" data-table="questions_library" data-field="x_refs2" name="x<?= $Grid->RowIndex ?>_refs2" id="x<?= $Grid->RowIndex ?>_refs2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->refs2->getPlaceHolder()) ?>" value="<?= $Grid->refs2->EditValue ?>"<?= $Grid->refs2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->refs2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_refs2" id="o<?= $Grid->RowIndex ?>_refs2" value="<?= HtmlEncode($Grid->refs2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs2" class="form-group">
<input type="<?= $Grid->refs2->getInputTextType() ?>" data-table="questions_library" data-field="x_refs2" name="x<?= $Grid->RowIndex ?>_refs2" id="x<?= $Grid->RowIndex ?>_refs2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->refs2->getPlaceHolder()) ?>" value="<?= $Grid->refs2->EditValue ?>"<?= $Grid->refs2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->refs2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_refs2">
<span<?= $Grid->refs2->viewAttributes() ?>>
<?= $Grid->refs2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_refs2" id="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_refs2" value="<?= HtmlEncode($Grid->refs2->FormValue) ?>">
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_refs2" id="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_refs2" value="<?= HtmlEncode($Grid->refs2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Activation_status->Visible) { // Activation_status ?>
        <td data-name="Activation_status" <?= $Grid->Activation_status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_Activation_status" class="form-group">
<input type="<?= $Grid->Activation_status->getInputTextType() ?>" data-table="questions_library" data-field="x_Activation_status" name="x<?= $Grid->RowIndex ?>_Activation_status" id="x<?= $Grid->RowIndex ?>_Activation_status" size="30" placeholder="<?= HtmlEncode($Grid->Activation_status->getPlaceHolder()) ?>" value="<?= $Grid->Activation_status->EditValue ?>"<?= $Grid->Activation_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Activation_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Activation_status" id="o<?= $Grid->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Grid->Activation_status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_Activation_status" class="form-group">
<input type="<?= $Grid->Activation_status->getInputTextType() ?>" data-table="questions_library" data-field="x_Activation_status" name="x<?= $Grid->RowIndex ?>_Activation_status" id="x<?= $Grid->RowIndex ?>_Activation_status" size="30" placeholder="<?= HtmlEncode($Grid->Activation_status->getPlaceHolder()) ?>" value="<?= $Grid->Activation_status->EditValue ?>"<?= $Grid->Activation_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Activation_status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_questions_library_Activation_status">
<span<?= $Grid->Activation_status->viewAttributes() ?>>
<?= $Grid->Activation_status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_Activation_status" id="fquestions_librarygrid$x<?= $Grid->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Grid->Activation_status->FormValue) ?>">
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_Activation_status" id="fquestions_librarygrid$o<?= $Grid->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Grid->Activation_status->OldValue) ?>">
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
loadjs.ready(["fquestions_librarygrid","load"], function () {
    fquestions_librarygrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_questions_library", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_questions_library_id" class="form-group questions_library_id"></span>
<?php } else { ?>
<span id="el$rowindex$_questions_library_id" class="form-group questions_library_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->libelle->Visible) { // libelle ?>
        <td data-name="libelle">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_questions_library_libelle" class="form-group questions_library_libelle">
<input type="<?= $Grid->libelle->getInputTextType() ?>" data-table="questions_library" data-field="x_libelle" name="x<?= $Grid->RowIndex ?>_libelle" id="x<?= $Grid->RowIndex ?>_libelle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->libelle->getPlaceHolder()) ?>" value="<?= $Grid->libelle->EditValue ?>"<?= $Grid->libelle->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->libelle->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_questions_library_libelle" class="form-group questions_library_libelle">
<span<?= $Grid->libelle->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->libelle->getDisplayValue($Grid->libelle->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="x<?= $Grid->RowIndex ?>_libelle" id="x<?= $Grid->RowIndex ?>_libelle" value="<?= HtmlEncode($Grid->libelle->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_libelle" data-hidden="1" name="o<?= $Grid->RowIndex ?>_libelle" id="o<?= $Grid->RowIndex ?>_libelle" value="<?= HtmlEncode($Grid->libelle->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->controlObj_id->Visible) { // controlObj_id ?>
        <td data-name="controlObj_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->controlObj_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_questions_library_controlObj_id" class="form-group questions_library_controlObj_id">
<span<?= $Grid->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->controlObj_id->getDisplayValue($Grid->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_controlObj_id" name="x<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_questions_library_controlObj_id" class="form-group questions_library_controlObj_id">
    <select
        id="x<?= $Grid->RowIndex ?>_controlObj_id"
        name="x<?= $Grid->RowIndex ?>_controlObj_id"
        class="form-control ew-select<?= $Grid->controlObj_id->isInvalidClass() ?>"
        data-select2-id="questions_library_x<?= $Grid->RowIndex ?>_controlObj_id"
        data-table="questions_library"
        data-field="x_controlObj_id"
        data-value-separator="<?= $Grid->controlObj_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->controlObj_id->getPlaceHolder()) ?>"
        <?= $Grid->controlObj_id->editAttributes() ?>>
        <?= $Grid->controlObj_id->selectOptionListHtml("x{$Grid->RowIndex}_controlObj_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->controlObj_id->getErrorMessage() ?></div>
<?= $Grid->controlObj_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_controlObj_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='questions_library_x<?= $Grid->RowIndex ?>_controlObj_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_controlObj_id", selectId: "questions_library_x<?= $Grid->RowIndex ?>_controlObj_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.questions_library.fields.controlObj_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_questions_library_controlObj_id" class="form-group questions_library_controlObj_id">
<span<?= $Grid->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->controlObj_id->getDisplayValue($Grid->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_controlObj_id" id="x<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_controlObj_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_controlObj_id" id="o<?= $Grid->RowIndex ?>_controlObj_id" value="<?= HtmlEncode($Grid->controlObj_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->refs1->Visible) { // refs1 ?>
        <td data-name="refs1">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->refs1->getSessionValue() != "") { ?>
<span id="el$rowindex$_questions_library_refs1" class="form-group questions_library_refs1">
<span<?= $Grid->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->refs1->getDisplayValue($Grid->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_refs1" name="x<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_questions_library_refs1" class="form-group questions_library_refs1">
<input type="<?= $Grid->refs1->getInputTextType() ?>" data-table="questions_library" data-field="x_refs1" name="x<?= $Grid->RowIndex ?>_refs1" id="x<?= $Grid->RowIndex ?>_refs1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->refs1->getPlaceHolder()) ?>" value="<?= $Grid->refs1->EditValue ?>"<?= $Grid->refs1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->refs1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_questions_library_refs1" class="form-group questions_library_refs1">
<span<?= $Grid->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->refs1->getDisplayValue($Grid->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_refs1" id="x<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_refs1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_refs1" id="o<?= $Grid->RowIndex ?>_refs1" value="<?= HtmlEncode($Grid->refs1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->refs2->Visible) { // refs2 ?>
        <td data-name="refs2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_questions_library_refs2" class="form-group questions_library_refs2">
<input type="<?= $Grid->refs2->getInputTextType() ?>" data-table="questions_library" data-field="x_refs2" name="x<?= $Grid->RowIndex ?>_refs2" id="x<?= $Grid->RowIndex ?>_refs2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->refs2->getPlaceHolder()) ?>" value="<?= $Grid->refs2->EditValue ?>"<?= $Grid->refs2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->refs2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_questions_library_refs2" class="form-group questions_library_refs2">
<span<?= $Grid->refs2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->refs2->getDisplayValue($Grid->refs2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_refs2" id="x<?= $Grid->RowIndex ?>_refs2" value="<?= HtmlEncode($Grid->refs2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_refs2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_refs2" id="o<?= $Grid->RowIndex ?>_refs2" value="<?= HtmlEncode($Grid->refs2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Activation_status->Visible) { // Activation_status ?>
        <td data-name="Activation_status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_questions_library_Activation_status" class="form-group questions_library_Activation_status">
<input type="<?= $Grid->Activation_status->getInputTextType() ?>" data-table="questions_library" data-field="x_Activation_status" name="x<?= $Grid->RowIndex ?>_Activation_status" id="x<?= $Grid->RowIndex ?>_Activation_status" size="30" placeholder="<?= HtmlEncode($Grid->Activation_status->getPlaceHolder()) ?>" value="<?= $Grid->Activation_status->EditValue ?>"<?= $Grid->Activation_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Activation_status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_questions_library_Activation_status" class="form-group questions_library_Activation_status">
<span<?= $Grid->Activation_status->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Activation_status->getDisplayValue($Grid->Activation_status->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Activation_status" id="x<?= $Grid->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Grid->Activation_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="questions_library" data-field="x_Activation_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Activation_status" id="o<?= $Grid->RowIndex ?>_Activation_status" value="<?= HtmlEncode($Grid->Activation_status->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fquestions_librarygrid","load"], function() {
    fquestions_librarygrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fquestions_librarygrid">
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
    ew.addEventHandlers("questions_library");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
