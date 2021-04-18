<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("Iso27001FamilyGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fiso27001_familygrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fiso27001_familygrid = new ew.Form("fiso27001_familygrid", "grid");
    fiso27001_familygrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "iso27001_family")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.iso27001_family)
        ew.vars.tables.iso27001_family = currentTable;
    fiso27001_familygrid.addFields([
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["control_area_id", [fields.control_area_id.visible && fields.control_area_id.required ? ew.Validators.required(fields.control_area_id.caption) : null], fields.control_area_id.isInvalid],
        ["control_familyName", [fields.control_familyName.visible && fields.control_familyName.required ? ew.Validators.required(fields.control_familyName.caption) : null], fields.control_familyName.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fiso27001_familygrid,
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
    fiso27001_familygrid.validate = function () {
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
    fiso27001_familygrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "code", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "control_area_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "control_familyName", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fiso27001_familygrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fiso27001_familygrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fiso27001_familygrid.lists.control_area_id = <?= $Grid->control_area_id->toClientList($Grid) ?>;
    loadjs.done("fiso27001_familygrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> iso27001_family">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fiso27001_familygrid" class="ew-form ew-list-form form-inline">
<div id="gmp_iso27001_family" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_iso27001_familygrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->code->Visible) { // code ?>
        <th data-name="code" class="<?= $Grid->code->headerCellClass() ?>"><div id="elh_iso27001_family_code" class="iso27001_family_code"><?= $Grid->renderSort($Grid->code) ?></div></th>
<?php } ?>
<?php if ($Grid->control_area_id->Visible) { // control_area_id ?>
        <th data-name="control_area_id" class="<?= $Grid->control_area_id->headerCellClass() ?>"><div id="elh_iso27001_family_control_area_id" class="iso27001_family_control_area_id"><?= $Grid->renderSort($Grid->control_area_id) ?></div></th>
<?php } ?>
<?php if ($Grid->control_familyName->Visible) { // control_familyName ?>
        <th data-name="control_familyName" class="<?= $Grid->control_familyName->headerCellClass() ?>"><div id="elh_iso27001_family_control_familyName" class="iso27001_family_control_familyName"><?= $Grid->renderSort($Grid->control_familyName) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_iso27001_family", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->code->Visible) { // code ?>
        <td data-name="code" <?= $Grid->code->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_code" class="form-group">
<input type="<?= $Grid->code->getInputTextType() ?>" data-table="iso27001_family" data-field="x_code" name="x<?= $Grid->RowIndex ?>_code" id="x<?= $Grid->RowIndex ?>_code" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->code->getPlaceHolder()) ?>" value="<?= $Grid->code->EditValue ?>"<?= $Grid->code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->code->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="iso27001_family" data-field="x_code" data-hidden="1" name="o<?= $Grid->RowIndex ?>_code" id="o<?= $Grid->RowIndex ?>_code" value="<?= HtmlEncode($Grid->code->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_code" class="form-group">
<input type="<?= $Grid->code->getInputTextType() ?>" data-table="iso27001_family" data-field="x_code" name="x<?= $Grid->RowIndex ?>_code" id="x<?= $Grid->RowIndex ?>_code" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->code->getPlaceHolder()) ?>" value="<?= $Grid->code->EditValue ?>"<?= $Grid->code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->code->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_code">
<span<?= $Grid->code->viewAttributes() ?>>
<?= $Grid->code->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="iso27001_family" data-field="x_code" data-hidden="1" name="fiso27001_familygrid$x<?= $Grid->RowIndex ?>_code" id="fiso27001_familygrid$x<?= $Grid->RowIndex ?>_code" value="<?= HtmlEncode($Grid->code->FormValue) ?>">
<input type="hidden" data-table="iso27001_family" data-field="x_code" data-hidden="1" name="fiso27001_familygrid$o<?= $Grid->RowIndex ?>_code" id="fiso27001_familygrid$o<?= $Grid->RowIndex ?>_code" value="<?= HtmlEncode($Grid->code->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->control_area_id->Visible) { // control_area_id ?>
        <td data-name="control_area_id" <?= $Grid->control_area_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->control_area_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_control_area_id" class="form-group">
<span<?= $Grid->control_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->control_area_id->getDisplayValue($Grid->control_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_control_area_id" name="x<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_control_area_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_control_area_id"
        name="x<?= $Grid->RowIndex ?>_control_area_id"
        class="form-control ew-select<?= $Grid->control_area_id->isInvalidClass() ?>"
        data-select2-id="iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id"
        data-table="iso27001_family"
        data-field="x_control_area_id"
        data-value-separator="<?= $Grid->control_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->control_area_id->getPlaceHolder()) ?>"
        <?= $Grid->control_area_id->editAttributes() ?>>
        <?= $Grid->control_area_id->selectOptionListHtml("x{$Grid->RowIndex}_control_area_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->control_area_id->getErrorMessage() ?></div>
<?= $Grid->control_area_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_control_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_control_area_id", selectId: "iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.iso27001_family.fields.control_area_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="iso27001_family" data-field="x_control_area_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_control_area_id" id="o<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->control_area_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_control_area_id" class="form-group">
<span<?= $Grid->control_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->control_area_id->getDisplayValue($Grid->control_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_control_area_id" name="x<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_control_area_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_control_area_id"
        name="x<?= $Grid->RowIndex ?>_control_area_id"
        class="form-control ew-select<?= $Grid->control_area_id->isInvalidClass() ?>"
        data-select2-id="iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id"
        data-table="iso27001_family"
        data-field="x_control_area_id"
        data-value-separator="<?= $Grid->control_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->control_area_id->getPlaceHolder()) ?>"
        <?= $Grid->control_area_id->editAttributes() ?>>
        <?= $Grid->control_area_id->selectOptionListHtml("x{$Grid->RowIndex}_control_area_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->control_area_id->getErrorMessage() ?></div>
<?= $Grid->control_area_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_control_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_control_area_id", selectId: "iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.iso27001_family.fields.control_area_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_control_area_id">
<span<?= $Grid->control_area_id->viewAttributes() ?>>
<?= $Grid->control_area_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="iso27001_family" data-field="x_control_area_id" data-hidden="1" name="fiso27001_familygrid$x<?= $Grid->RowIndex ?>_control_area_id" id="fiso27001_familygrid$x<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->FormValue) ?>">
<input type="hidden" data-table="iso27001_family" data-field="x_control_area_id" data-hidden="1" name="fiso27001_familygrid$o<?= $Grid->RowIndex ?>_control_area_id" id="fiso27001_familygrid$o<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->control_familyName->Visible) { // control_familyName ?>
        <td data-name="control_familyName" <?= $Grid->control_familyName->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_control_familyName" class="form-group">
<input type="<?= $Grid->control_familyName->getInputTextType() ?>" data-table="iso27001_family" data-field="x_control_familyName" name="x<?= $Grid->RowIndex ?>_control_familyName" id="x<?= $Grid->RowIndex ?>_control_familyName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->control_familyName->getPlaceHolder()) ?>" value="<?= $Grid->control_familyName->EditValue ?>"<?= $Grid->control_familyName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->control_familyName->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_control_familyName" id="o<?= $Grid->RowIndex ?>_control_familyName" value="<?= HtmlEncode($Grid->control_familyName->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->control_familyName->getInputTextType() ?>" data-table="iso27001_family" data-field="x_control_familyName" name="x<?= $Grid->RowIndex ?>_control_familyName" id="x<?= $Grid->RowIndex ?>_control_familyName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->control_familyName->getPlaceHolder()) ?>" value="<?= $Grid->control_familyName->EditValue ?>"<?= $Grid->control_familyName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->control_familyName->getErrorMessage() ?></div>
<input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_control_familyName" id="o<?= $Grid->RowIndex ?>_control_familyName" value="<?= HtmlEncode($Grid->control_familyName->OldValue ?? $Grid->control_familyName->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_iso27001_family_control_familyName">
<span<?= $Grid->control_familyName->viewAttributes() ?>>
<?= $Grid->control_familyName->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="fiso27001_familygrid$x<?= $Grid->RowIndex ?>_control_familyName" id="fiso27001_familygrid$x<?= $Grid->RowIndex ?>_control_familyName" value="<?= HtmlEncode($Grid->control_familyName->FormValue) ?>">
<input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="fiso27001_familygrid$o<?= $Grid->RowIndex ?>_control_familyName" id="fiso27001_familygrid$o<?= $Grid->RowIndex ?>_control_familyName" value="<?= HtmlEncode($Grid->control_familyName->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="x<?= $Grid->RowIndex ?>_control_familyName" id="x<?= $Grid->RowIndex ?>_control_familyName" value="<?= HtmlEncode($Grid->control_familyName->CurrentValue) ?>">
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fiso27001_familygrid","load"], function () {
    fiso27001_familygrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_iso27001_family", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->code->Visible) { // code ?>
        <td data-name="code">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_iso27001_family_code" class="form-group iso27001_family_code">
<input type="<?= $Grid->code->getInputTextType() ?>" data-table="iso27001_family" data-field="x_code" name="x<?= $Grid->RowIndex ?>_code" id="x<?= $Grid->RowIndex ?>_code" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->code->getPlaceHolder()) ?>" value="<?= $Grid->code->EditValue ?>"<?= $Grid->code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->code->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_iso27001_family_code" class="form-group iso27001_family_code">
<span<?= $Grid->code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->code->getDisplayValue($Grid->code->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="iso27001_family" data-field="x_code" data-hidden="1" name="x<?= $Grid->RowIndex ?>_code" id="x<?= $Grid->RowIndex ?>_code" value="<?= HtmlEncode($Grid->code->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="iso27001_family" data-field="x_code" data-hidden="1" name="o<?= $Grid->RowIndex ?>_code" id="o<?= $Grid->RowIndex ?>_code" value="<?= HtmlEncode($Grid->code->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->control_area_id->Visible) { // control_area_id ?>
        <td data-name="control_area_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->control_area_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_iso27001_family_control_area_id" class="form-group iso27001_family_control_area_id">
<span<?= $Grid->control_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->control_area_id->getDisplayValue($Grid->control_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_control_area_id" name="x<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_iso27001_family_control_area_id" class="form-group iso27001_family_control_area_id">
    <select
        id="x<?= $Grid->RowIndex ?>_control_area_id"
        name="x<?= $Grid->RowIndex ?>_control_area_id"
        class="form-control ew-select<?= $Grid->control_area_id->isInvalidClass() ?>"
        data-select2-id="iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id"
        data-table="iso27001_family"
        data-field="x_control_area_id"
        data-value-separator="<?= $Grid->control_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->control_area_id->getPlaceHolder()) ?>"
        <?= $Grid->control_area_id->editAttributes() ?>>
        <?= $Grid->control_area_id->selectOptionListHtml("x{$Grid->RowIndex}_control_area_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->control_area_id->getErrorMessage() ?></div>
<?= $Grid->control_area_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_control_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_control_area_id", selectId: "iso27001_family_x<?= $Grid->RowIndex ?>_control_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.iso27001_family.fields.control_area_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_iso27001_family_control_area_id" class="form-group iso27001_family_control_area_id">
<span<?= $Grid->control_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->control_area_id->getDisplayValue($Grid->control_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="iso27001_family" data-field="x_control_area_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_control_area_id" id="x<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="iso27001_family" data-field="x_control_area_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_control_area_id" id="o<?= $Grid->RowIndex ?>_control_area_id" value="<?= HtmlEncode($Grid->control_area_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->control_familyName->Visible) { // control_familyName ?>
        <td data-name="control_familyName">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_iso27001_family_control_familyName" class="form-group iso27001_family_control_familyName">
<input type="<?= $Grid->control_familyName->getInputTextType() ?>" data-table="iso27001_family" data-field="x_control_familyName" name="x<?= $Grid->RowIndex ?>_control_familyName" id="x<?= $Grid->RowIndex ?>_control_familyName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->control_familyName->getPlaceHolder()) ?>" value="<?= $Grid->control_familyName->EditValue ?>"<?= $Grid->control_familyName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->control_familyName->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_iso27001_family_control_familyName" class="form-group iso27001_family_control_familyName">
<span<?= $Grid->control_familyName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->control_familyName->getDisplayValue($Grid->control_familyName->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="x<?= $Grid->RowIndex ?>_control_familyName" id="x<?= $Grid->RowIndex ?>_control_familyName" value="<?= HtmlEncode($Grid->control_familyName->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="iso27001_family" data-field="x_control_familyName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_control_familyName" id="o<?= $Grid->RowIndex ?>_control_familyName" value="<?= HtmlEncode($Grid->control_familyName->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fiso27001_familygrid","load"], function() {
    fiso27001_familygrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fiso27001_familygrid">
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
    ew.addEventHandlers("iso27001_family");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>