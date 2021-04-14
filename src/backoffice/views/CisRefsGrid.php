<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("CisRefsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcis_refsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fcis_refsgrid = new ew.Form("fcis_refsgrid", "grid");
    fcis_refsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "cis_refs")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.cis_refs)
        ew.vars.tables.cis_refs = currentTable;
    fcis_refsgrid.addFields([
        ["Nidentifier", [fields.Nidentifier.visible && fields.Nidentifier.required ? ew.Validators.required(fields.Nidentifier.caption) : null], fields.Nidentifier.isInvalid],
        ["Control_Family_id", [fields.Control_Family_id.visible && fields.Control_Family_id.required ? ew.Validators.required(fields.Control_Family_id.caption) : null], fields.Control_Family_id.isInvalid],
        ["control_Name", [fields.control_Name.visible && fields.control_Name.required ? ew.Validators.required(fields.control_Name.caption) : null], fields.control_Name.isInvalid],
        ["impl_group1", [fields.impl_group1.visible && fields.impl_group1.required ? ew.Validators.required(fields.impl_group1.caption) : null], fields.impl_group1.isInvalid],
        ["impl_group2", [fields.impl_group2.visible && fields.impl_group2.required ? ew.Validators.required(fields.impl_group2.caption) : null], fields.impl_group2.isInvalid],
        ["impl_group3", [fields.impl_group3.visible && fields.impl_group3.required ? ew.Validators.required(fields.impl_group3.caption) : null], fields.impl_group3.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcis_refsgrid,
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
    fcis_refsgrid.validate = function () {
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
    fcis_refsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "Nidentifier", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Control_Family_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "control_Name", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "impl_group1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "impl_group2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "impl_group3", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fcis_refsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcis_refsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcis_refsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> cis_refs">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fcis_refsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_cis_refs" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_cis_refsgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->Nidentifier->Visible) { // Nidentifier ?>
        <th data-name="Nidentifier" class="<?= $Grid->Nidentifier->headerCellClass() ?>"><div id="elh_cis_refs_Nidentifier" class="cis_refs_Nidentifier"><?= $Grid->renderSort($Grid->Nidentifier) ?></div></th>
<?php } ?>
<?php if ($Grid->Control_Family_id->Visible) { // Control_Family_id ?>
        <th data-name="Control_Family_id" class="<?= $Grid->Control_Family_id->headerCellClass() ?>"><div id="elh_cis_refs_Control_Family_id" class="cis_refs_Control_Family_id"><?= $Grid->renderSort($Grid->Control_Family_id) ?></div></th>
<?php } ?>
<?php if ($Grid->control_Name->Visible) { // control_Name ?>
        <th data-name="control_Name" class="<?= $Grid->control_Name->headerCellClass() ?>"><div id="elh_cis_refs_control_Name" class="cis_refs_control_Name"><?= $Grid->renderSort($Grid->control_Name) ?></div></th>
<?php } ?>
<?php if ($Grid->impl_group1->Visible) { // impl_group1 ?>
        <th data-name="impl_group1" class="<?= $Grid->impl_group1->headerCellClass() ?>"><div id="elh_cis_refs_impl_group1" class="cis_refs_impl_group1"><?= $Grid->renderSort($Grid->impl_group1) ?></div></th>
<?php } ?>
<?php if ($Grid->impl_group2->Visible) { // impl_group2 ?>
        <th data-name="impl_group2" class="<?= $Grid->impl_group2->headerCellClass() ?>"><div id="elh_cis_refs_impl_group2" class="cis_refs_impl_group2"><?= $Grid->renderSort($Grid->impl_group2) ?></div></th>
<?php } ?>
<?php if ($Grid->impl_group3->Visible) { // impl_group3 ?>
        <th data-name="impl_group3" class="<?= $Grid->impl_group3->headerCellClass() ?>"><div id="elh_cis_refs_impl_group3" class="cis_refs_impl_group3"><?= $Grid->renderSort($Grid->impl_group3) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_cis_refs", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->Nidentifier->Visible) { // Nidentifier ?>
        <td data-name="Nidentifier" <?= $Grid->Nidentifier->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_Nidentifier" class="form-group">
<input type="<?= $Grid->Nidentifier->getInputTextType() ?>" data-table="cis_refs" data-field="x_Nidentifier" name="x<?= $Grid->RowIndex ?>_Nidentifier" id="x<?= $Grid->RowIndex ?>_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Grid->Nidentifier->getPlaceHolder()) ?>" value="<?= $Grid->Nidentifier->EditValue ?>"<?= $Grid->Nidentifier->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nidentifier->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_Nidentifier" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Nidentifier" id="o<?= $Grid->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Grid->Nidentifier->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->Nidentifier->getInputTextType() ?>" data-table="cis_refs" data-field="x_Nidentifier" name="x<?= $Grid->RowIndex ?>_Nidentifier" id="x<?= $Grid->RowIndex ?>_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Grid->Nidentifier->getPlaceHolder()) ?>" value="<?= $Grid->Nidentifier->EditValue ?>"<?= $Grid->Nidentifier->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nidentifier->getErrorMessage() ?></div>
<input type="hidden" data-table="cis_refs" data-field="x_Nidentifier" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Nidentifier" id="o<?= $Grid->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Grid->Nidentifier->OldValue ?? $Grid->Nidentifier->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_Nidentifier">
<span<?= $Grid->Nidentifier->viewAttributes() ?>>
<?= $Grid->Nidentifier->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="cis_refs" data-field="x_Nidentifier" data-hidden="1" name="fcis_refsgrid$x<?= $Grid->RowIndex ?>_Nidentifier" id="fcis_refsgrid$x<?= $Grid->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Grid->Nidentifier->FormValue) ?>">
<input type="hidden" data-table="cis_refs" data-field="x_Nidentifier" data-hidden="1" name="fcis_refsgrid$o<?= $Grid->RowIndex ?>_Nidentifier" id="fcis_refsgrid$o<?= $Grid->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Grid->Nidentifier->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="cis_refs" data-field="x_Nidentifier" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Nidentifier" id="x<?= $Grid->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Grid->Nidentifier->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->Control_Family_id->Visible) { // Control_Family_id ?>
        <td data-name="Control_Family_id" <?= $Grid->Control_Family_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->Control_Family_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_Control_Family_id" class="form-group">
<span<?= $Grid->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Control_Family_id->getDisplayValue($Grid->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Control_Family_id" name="x<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_Control_Family_id" class="form-group">
<input type="<?= $Grid->Control_Family_id->getInputTextType() ?>" data-table="cis_refs" data-field="x_Control_Family_id" name="x<?= $Grid->RowIndex ?>_Control_Family_id" id="x<?= $Grid->RowIndex ?>_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Grid->Control_Family_id->EditValue ?>"<?= $Grid->Control_Family_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="cis_refs" data-field="x_Control_Family_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Control_Family_id" id="o<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->Control_Family_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_Control_Family_id" class="form-group">
<span<?= $Grid->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Control_Family_id->getDisplayValue($Grid->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Control_Family_id" name="x<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_Control_Family_id" class="form-group">
<input type="<?= $Grid->Control_Family_id->getInputTextType() ?>" data-table="cis_refs" data-field="x_Control_Family_id" name="x<?= $Grid->RowIndex ?>_Control_Family_id" id="x<?= $Grid->RowIndex ?>_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Grid->Control_Family_id->EditValue ?>"<?= $Grid->Control_Family_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_Control_Family_id">
<span<?= $Grid->Control_Family_id->viewAttributes() ?>>
<?= $Grid->Control_Family_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="cis_refs" data-field="x_Control_Family_id" data-hidden="1" name="fcis_refsgrid$x<?= $Grid->RowIndex ?>_Control_Family_id" id="fcis_refsgrid$x<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->FormValue) ?>">
<input type="hidden" data-table="cis_refs" data-field="x_Control_Family_id" data-hidden="1" name="fcis_refsgrid$o<?= $Grid->RowIndex ?>_Control_Family_id" id="fcis_refsgrid$o<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->control_Name->Visible) { // control_Name ?>
        <td data-name="control_Name" <?= $Grid->control_Name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_control_Name" class="form-group">
<input type="<?= $Grid->control_Name->getInputTextType() ?>" data-table="cis_refs" data-field="x_control_Name" name="x<?= $Grid->RowIndex ?>_control_Name" id="x<?= $Grid->RowIndex ?>_control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->control_Name->getPlaceHolder()) ?>" value="<?= $Grid->control_Name->EditValue ?>"<?= $Grid->control_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->control_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_control_Name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_control_Name" id="o<?= $Grid->RowIndex ?>_control_Name" value="<?= HtmlEncode($Grid->control_Name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_control_Name" class="form-group">
<input type="<?= $Grid->control_Name->getInputTextType() ?>" data-table="cis_refs" data-field="x_control_Name" name="x<?= $Grid->RowIndex ?>_control_Name" id="x<?= $Grid->RowIndex ?>_control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->control_Name->getPlaceHolder()) ?>" value="<?= $Grid->control_Name->EditValue ?>"<?= $Grid->control_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->control_Name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_control_Name">
<span<?= $Grid->control_Name->viewAttributes() ?>>
<?= $Grid->control_Name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="cis_refs" data-field="x_control_Name" data-hidden="1" name="fcis_refsgrid$x<?= $Grid->RowIndex ?>_control_Name" id="fcis_refsgrid$x<?= $Grid->RowIndex ?>_control_Name" value="<?= HtmlEncode($Grid->control_Name->FormValue) ?>">
<input type="hidden" data-table="cis_refs" data-field="x_control_Name" data-hidden="1" name="fcis_refsgrid$o<?= $Grid->RowIndex ?>_control_Name" id="fcis_refsgrid$o<?= $Grid->RowIndex ?>_control_Name" value="<?= HtmlEncode($Grid->control_Name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->impl_group1->Visible) { // impl_group1 ?>
        <td data-name="impl_group1" <?= $Grid->impl_group1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group1" class="form-group">
<input type="<?= $Grid->impl_group1->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group1" name="x<?= $Grid->RowIndex ?>_impl_group1" id="x<?= $Grid->RowIndex ?>_impl_group1" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group1->getPlaceHolder()) ?>" value="<?= $Grid->impl_group1->EditValue ?>"<?= $Grid->impl_group1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_impl_group1" id="o<?= $Grid->RowIndex ?>_impl_group1" value="<?= HtmlEncode($Grid->impl_group1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group1" class="form-group">
<input type="<?= $Grid->impl_group1->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group1" name="x<?= $Grid->RowIndex ?>_impl_group1" id="x<?= $Grid->RowIndex ?>_impl_group1" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group1->getPlaceHolder()) ?>" value="<?= $Grid->impl_group1->EditValue ?>"<?= $Grid->impl_group1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group1">
<span<?= $Grid->impl_group1->viewAttributes() ?>>
<?= $Grid->impl_group1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group1" data-hidden="1" name="fcis_refsgrid$x<?= $Grid->RowIndex ?>_impl_group1" id="fcis_refsgrid$x<?= $Grid->RowIndex ?>_impl_group1" value="<?= HtmlEncode($Grid->impl_group1->FormValue) ?>">
<input type="hidden" data-table="cis_refs" data-field="x_impl_group1" data-hidden="1" name="fcis_refsgrid$o<?= $Grid->RowIndex ?>_impl_group1" id="fcis_refsgrid$o<?= $Grid->RowIndex ?>_impl_group1" value="<?= HtmlEncode($Grid->impl_group1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->impl_group2->Visible) { // impl_group2 ?>
        <td data-name="impl_group2" <?= $Grid->impl_group2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group2" class="form-group">
<input type="<?= $Grid->impl_group2->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group2" name="x<?= $Grid->RowIndex ?>_impl_group2" id="x<?= $Grid->RowIndex ?>_impl_group2" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group2->getPlaceHolder()) ?>" value="<?= $Grid->impl_group2->EditValue ?>"<?= $Grid->impl_group2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_impl_group2" id="o<?= $Grid->RowIndex ?>_impl_group2" value="<?= HtmlEncode($Grid->impl_group2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group2" class="form-group">
<input type="<?= $Grid->impl_group2->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group2" name="x<?= $Grid->RowIndex ?>_impl_group2" id="x<?= $Grid->RowIndex ?>_impl_group2" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group2->getPlaceHolder()) ?>" value="<?= $Grid->impl_group2->EditValue ?>"<?= $Grid->impl_group2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group2">
<span<?= $Grid->impl_group2->viewAttributes() ?>>
<?= $Grid->impl_group2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group2" data-hidden="1" name="fcis_refsgrid$x<?= $Grid->RowIndex ?>_impl_group2" id="fcis_refsgrid$x<?= $Grid->RowIndex ?>_impl_group2" value="<?= HtmlEncode($Grid->impl_group2->FormValue) ?>">
<input type="hidden" data-table="cis_refs" data-field="x_impl_group2" data-hidden="1" name="fcis_refsgrid$o<?= $Grid->RowIndex ?>_impl_group2" id="fcis_refsgrid$o<?= $Grid->RowIndex ?>_impl_group2" value="<?= HtmlEncode($Grid->impl_group2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->impl_group3->Visible) { // impl_group3 ?>
        <td data-name="impl_group3" <?= $Grid->impl_group3->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group3" class="form-group">
<input type="<?= $Grid->impl_group3->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group3" name="x<?= $Grid->RowIndex ?>_impl_group3" id="x<?= $Grid->RowIndex ?>_impl_group3" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group3->getPlaceHolder()) ?>" value="<?= $Grid->impl_group3->EditValue ?>"<?= $Grid->impl_group3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group3" data-hidden="1" name="o<?= $Grid->RowIndex ?>_impl_group3" id="o<?= $Grid->RowIndex ?>_impl_group3" value="<?= HtmlEncode($Grid->impl_group3->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group3" class="form-group">
<input type="<?= $Grid->impl_group3->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group3" name="x<?= $Grid->RowIndex ?>_impl_group3" id="x<?= $Grid->RowIndex ?>_impl_group3" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group3->getPlaceHolder()) ?>" value="<?= $Grid->impl_group3->EditValue ?>"<?= $Grid->impl_group3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_cis_refs_impl_group3">
<span<?= $Grid->impl_group3->viewAttributes() ?>>
<?= $Grid->impl_group3->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group3" data-hidden="1" name="fcis_refsgrid$x<?= $Grid->RowIndex ?>_impl_group3" id="fcis_refsgrid$x<?= $Grid->RowIndex ?>_impl_group3" value="<?= HtmlEncode($Grid->impl_group3->FormValue) ?>">
<input type="hidden" data-table="cis_refs" data-field="x_impl_group3" data-hidden="1" name="fcis_refsgrid$o<?= $Grid->RowIndex ?>_impl_group3" id="fcis_refsgrid$o<?= $Grid->RowIndex ?>_impl_group3" value="<?= HtmlEncode($Grid->impl_group3->OldValue) ?>">
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
loadjs.ready(["fcis_refsgrid","load"], function () {
    fcis_refsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_cis_refs", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->Nidentifier->Visible) { // Nidentifier ?>
        <td data-name="Nidentifier">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_cis_refs_Nidentifier" class="form-group cis_refs_Nidentifier">
<input type="<?= $Grid->Nidentifier->getInputTextType() ?>" data-table="cis_refs" data-field="x_Nidentifier" name="x<?= $Grid->RowIndex ?>_Nidentifier" id="x<?= $Grid->RowIndex ?>_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Grid->Nidentifier->getPlaceHolder()) ?>" value="<?= $Grid->Nidentifier->EditValue ?>"<?= $Grid->Nidentifier->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nidentifier->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_cis_refs_Nidentifier" class="form-group cis_refs_Nidentifier">
<span<?= $Grid->Nidentifier->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Nidentifier->getDisplayValue($Grid->Nidentifier->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_Nidentifier" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Nidentifier" id="x<?= $Grid->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Grid->Nidentifier->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cis_refs" data-field="x_Nidentifier" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Nidentifier" id="o<?= $Grid->RowIndex ?>_Nidentifier" value="<?= HtmlEncode($Grid->Nidentifier->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Control_Family_id->Visible) { // Control_Family_id ?>
        <td data-name="Control_Family_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->Control_Family_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_cis_refs_Control_Family_id" class="form-group cis_refs_Control_Family_id">
<span<?= $Grid->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Control_Family_id->getDisplayValue($Grid->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Control_Family_id" name="x<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_cis_refs_Control_Family_id" class="form-group cis_refs_Control_Family_id">
<input type="<?= $Grid->Control_Family_id->getInputTextType() ?>" data-table="cis_refs" data-field="x_Control_Family_id" name="x<?= $Grid->RowIndex ?>_Control_Family_id" id="x<?= $Grid->RowIndex ?>_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Grid->Control_Family_id->EditValue ?>"<?= $Grid->Control_Family_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cis_refs_Control_Family_id" class="form-group cis_refs_Control_Family_id">
<span<?= $Grid->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Control_Family_id->getDisplayValue($Grid->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_Control_Family_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Control_Family_id" id="x<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cis_refs" data-field="x_Control_Family_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Control_Family_id" id="o<?= $Grid->RowIndex ?>_Control_Family_id" value="<?= HtmlEncode($Grid->Control_Family_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->control_Name->Visible) { // control_Name ?>
        <td data-name="control_Name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_cis_refs_control_Name" class="form-group cis_refs_control_Name">
<input type="<?= $Grid->control_Name->getInputTextType() ?>" data-table="cis_refs" data-field="x_control_Name" name="x<?= $Grid->RowIndex ?>_control_Name" id="x<?= $Grid->RowIndex ?>_control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->control_Name->getPlaceHolder()) ?>" value="<?= $Grid->control_Name->EditValue ?>"<?= $Grid->control_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->control_Name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_cis_refs_control_Name" class="form-group cis_refs_control_Name">
<span<?= $Grid->control_Name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->control_Name->getDisplayValue($Grid->control_Name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_control_Name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_control_Name" id="x<?= $Grid->RowIndex ?>_control_Name" value="<?= HtmlEncode($Grid->control_Name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cis_refs" data-field="x_control_Name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_control_Name" id="o<?= $Grid->RowIndex ?>_control_Name" value="<?= HtmlEncode($Grid->control_Name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->impl_group1->Visible) { // impl_group1 ?>
        <td data-name="impl_group1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_cis_refs_impl_group1" class="form-group cis_refs_impl_group1">
<input type="<?= $Grid->impl_group1->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group1" name="x<?= $Grid->RowIndex ?>_impl_group1" id="x<?= $Grid->RowIndex ?>_impl_group1" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group1->getPlaceHolder()) ?>" value="<?= $Grid->impl_group1->EditValue ?>"<?= $Grid->impl_group1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_cis_refs_impl_group1" class="form-group cis_refs_impl_group1">
<span<?= $Grid->impl_group1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->impl_group1->getDisplayValue($Grid->impl_group1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_impl_group1" id="x<?= $Grid->RowIndex ?>_impl_group1" value="<?= HtmlEncode($Grid->impl_group1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_impl_group1" id="o<?= $Grid->RowIndex ?>_impl_group1" value="<?= HtmlEncode($Grid->impl_group1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->impl_group2->Visible) { // impl_group2 ?>
        <td data-name="impl_group2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_cis_refs_impl_group2" class="form-group cis_refs_impl_group2">
<input type="<?= $Grid->impl_group2->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group2" name="x<?= $Grid->RowIndex ?>_impl_group2" id="x<?= $Grid->RowIndex ?>_impl_group2" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group2->getPlaceHolder()) ?>" value="<?= $Grid->impl_group2->EditValue ?>"<?= $Grid->impl_group2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_cis_refs_impl_group2" class="form-group cis_refs_impl_group2">
<span<?= $Grid->impl_group2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->impl_group2->getDisplayValue($Grid->impl_group2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_impl_group2" id="x<?= $Grid->RowIndex ?>_impl_group2" value="<?= HtmlEncode($Grid->impl_group2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_impl_group2" id="o<?= $Grid->RowIndex ?>_impl_group2" value="<?= HtmlEncode($Grid->impl_group2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->impl_group3->Visible) { // impl_group3 ?>
        <td data-name="impl_group3">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_cis_refs_impl_group3" class="form-group cis_refs_impl_group3">
<input type="<?= $Grid->impl_group3->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group3" name="x<?= $Grid->RowIndex ?>_impl_group3" id="x<?= $Grid->RowIndex ?>_impl_group3" size="30" maxlength="2" placeholder="<?= HtmlEncode($Grid->impl_group3->getPlaceHolder()) ?>" value="<?= $Grid->impl_group3->EditValue ?>"<?= $Grid->impl_group3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impl_group3->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_cis_refs_impl_group3" class="form-group cis_refs_impl_group3">
<span<?= $Grid->impl_group3->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->impl_group3->getDisplayValue($Grid->impl_group3->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group3" data-hidden="1" name="x<?= $Grid->RowIndex ?>_impl_group3" id="x<?= $Grid->RowIndex ?>_impl_group3" value="<?= HtmlEncode($Grid->impl_group3->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cis_refs" data-field="x_impl_group3" data-hidden="1" name="o<?= $Grid->RowIndex ?>_impl_group3" id="o<?= $Grid->RowIndex ?>_impl_group3" value="<?= HtmlEncode($Grid->impl_group3->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fcis_refsgrid","load"], function() {
    fcis_refsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fcis_refsgrid">
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
    ew.addEventHandlers("cis_refs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
