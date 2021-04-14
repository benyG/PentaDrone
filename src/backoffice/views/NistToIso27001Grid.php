<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("NistToIso27001Grid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnist_to_iso27001grid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnist_to_iso27001grid = new ew.Form("fnist_to_iso27001grid", "grid");
    fnist_to_iso27001grid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "nist_to_iso27001")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.nist_to_iso27001)
        ew.vars.tables.nist_to_iso27001 = currentTable;
    fnist_to_iso27001grid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["nistrefs_family", [fields.nistrefs_family.visible && fields.nistrefs_family.required ? ew.Validators.required(fields.nistrefs_family.caption) : null], fields.nistrefs_family.isInvalid],
        ["isorefs", [fields.isorefs.visible && fields.isorefs.required ? ew.Validators.required(fields.isorefs.caption) : null], fields.isorefs.isInvalid],
        ["just_for_question_link", [fields.just_for_question_link.visible && fields.just_for_question_link.required ? ew.Validators.required(fields.just_for_question_link.caption) : null], fields.just_for_question_link.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnist_to_iso27001grid,
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
    fnist_to_iso27001grid.validate = function () {
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
    fnist_to_iso27001grid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "nistrefs_family", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "isorefs", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "just_for_question_link", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnist_to_iso27001grid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnist_to_iso27001grid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnist_to_iso27001grid.lists.nistrefs_family = <?= $Grid->nistrefs_family->toClientList($Grid) ?>;
    fnist_to_iso27001grid.lists.isorefs = <?= $Grid->isorefs->toClientList($Grid) ?>;
    loadjs.done("fnist_to_iso27001grid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> nist_to_iso27001">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fnist_to_iso27001grid" class="ew-form ew-list-form form-inline">
<div id="gmp_nist_to_iso27001" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_nist_to_iso27001grid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_nist_to_iso27001_id" class="nist_to_iso27001_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->nistrefs_family->Visible) { // nistrefs_family ?>
        <th data-name="nistrefs_family" class="<?= $Grid->nistrefs_family->headerCellClass() ?>"><div id="elh_nist_to_iso27001_nistrefs_family" class="nist_to_iso27001_nistrefs_family"><?= $Grid->renderSort($Grid->nistrefs_family) ?></div></th>
<?php } ?>
<?php if ($Grid->isorefs->Visible) { // isorefs ?>
        <th data-name="isorefs" class="<?= $Grid->isorefs->headerCellClass() ?>"><div id="elh_nist_to_iso27001_isorefs" class="nist_to_iso27001_isorefs"><?= $Grid->renderSort($Grid->isorefs) ?></div></th>
<?php } ?>
<?php if ($Grid->just_for_question_link->Visible) { // just_for_question_link ?>
        <th data-name="just_for_question_link" class="<?= $Grid->just_for_question_link->headerCellClass() ?>"><div id="elh_nist_to_iso27001_just_for_question_link" class="nist_to_iso27001_just_for_question_link"><?= $Grid->renderSort($Grid->just_for_question_link) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_nist_to_iso27001", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_id" class="form-group"></span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_id" id="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_id" id="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->nistrefs_family->Visible) { // nistrefs_family ?>
        <td data-name="nistrefs_family" <?= $Grid->nistrefs_family->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->nistrefs_family->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_nistrefs_family" class="form-group">
<span<?= $Grid->nistrefs_family->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nistrefs_family->getDisplayValue($Grid->nistrefs_family->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_nistrefs_family" name="x<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_nistrefs_family" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_nistrefs_family"
        name="x<?= $Grid->RowIndex ?>_nistrefs_family"
        class="form-control ew-select<?= $Grid->nistrefs_family->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family"
        data-table="nist_to_iso27001"
        data-field="x_nistrefs_family"
        data-value-separator="<?= $Grid->nistrefs_family->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nistrefs_family->getPlaceHolder()) ?>"
        <?= $Grid->nistrefs_family->editAttributes() ?>>
        <?= $Grid->nistrefs_family->selectOptionListHtml("x{$Grid->RowIndex}_nistrefs_family") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nistrefs_family->getErrorMessage() ?></div>
<?= $Grid->nistrefs_family->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nistrefs_family") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family']"),
        options = { name: "x<?= $Grid->RowIndex ?>_nistrefs_family", selectId: "nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.nistrefs_family.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_nistrefs_family" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nistrefs_family" id="o<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->nistrefs_family->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_nistrefs_family" class="form-group">
<span<?= $Grid->nistrefs_family->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nistrefs_family->getDisplayValue($Grid->nistrefs_family->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_nistrefs_family" name="x<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_nistrefs_family" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_nistrefs_family"
        name="x<?= $Grid->RowIndex ?>_nistrefs_family"
        class="form-control ew-select<?= $Grid->nistrefs_family->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family"
        data-table="nist_to_iso27001"
        data-field="x_nistrefs_family"
        data-value-separator="<?= $Grid->nistrefs_family->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nistrefs_family->getPlaceHolder()) ?>"
        <?= $Grid->nistrefs_family->editAttributes() ?>>
        <?= $Grid->nistrefs_family->selectOptionListHtml("x{$Grid->RowIndex}_nistrefs_family") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nistrefs_family->getErrorMessage() ?></div>
<?= $Grid->nistrefs_family->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nistrefs_family") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family']"),
        options = { name: "x<?= $Grid->RowIndex ?>_nistrefs_family", selectId: "nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.nistrefs_family.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_nistrefs_family">
<span<?= $Grid->nistrefs_family->viewAttributes() ?>>
<?= $Grid->nistrefs_family->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_nistrefs_family" data-hidden="1" name="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_nistrefs_family" id="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->FormValue) ?>">
<input type="hidden" data-table="nist_to_iso27001" data-field="x_nistrefs_family" data-hidden="1" name="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_nistrefs_family" id="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isorefs->Visible) { // isorefs ?>
        <td data-name="isorefs" <?= $Grid->isorefs->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->isorefs->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_isorefs" class="form-group">
<span<?= $Grid->isorefs->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isorefs->getDisplayValue($Grid->isorefs->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_isorefs" name="x<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_isorefs" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_isorefs"
        name="x<?= $Grid->RowIndex ?>_isorefs"
        class="form-control ew-select<?= $Grid->isorefs->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs"
        data-table="nist_to_iso27001"
        data-field="x_isorefs"
        data-value-separator="<?= $Grid->isorefs->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->isorefs->getPlaceHolder()) ?>"
        <?= $Grid->isorefs->editAttributes() ?>>
        <?= $Grid->isorefs->selectOptionListHtml("x{$Grid->RowIndex}_isorefs") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->isorefs->getErrorMessage() ?></div>
<?= $Grid->isorefs->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_isorefs") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs']"),
        options = { name: "x<?= $Grid->RowIndex ?>_isorefs", selectId: "nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.isorefs.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_isorefs" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isorefs" id="o<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->isorefs->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_isorefs" class="form-group">
<span<?= $Grid->isorefs->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isorefs->getDisplayValue($Grid->isorefs->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_isorefs" name="x<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_isorefs" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_isorefs"
        name="x<?= $Grid->RowIndex ?>_isorefs"
        class="form-control ew-select<?= $Grid->isorefs->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs"
        data-table="nist_to_iso27001"
        data-field="x_isorefs"
        data-value-separator="<?= $Grid->isorefs->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->isorefs->getPlaceHolder()) ?>"
        <?= $Grid->isorefs->editAttributes() ?>>
        <?= $Grid->isorefs->selectOptionListHtml("x{$Grid->RowIndex}_isorefs") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->isorefs->getErrorMessage() ?></div>
<?= $Grid->isorefs->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_isorefs") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs']"),
        options = { name: "x<?= $Grid->RowIndex ?>_isorefs", selectId: "nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.isorefs.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_isorefs">
<span<?= $Grid->isorefs->viewAttributes() ?>>
<?= $Grid->isorefs->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_isorefs" data-hidden="1" name="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_isorefs" id="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->FormValue) ?>">
<input type="hidden" data-table="nist_to_iso27001" data-field="x_isorefs" data-hidden="1" name="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_isorefs" id="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->just_for_question_link->Visible) { // just_for_question_link ?>
        <td data-name="just_for_question_link" <?= $Grid->just_for_question_link->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_just_for_question_link" class="form-group">
<input type="<?= $Grid->just_for_question_link->getInputTextType() ?>" data-table="nist_to_iso27001" data-field="x_just_for_question_link" name="x<?= $Grid->RowIndex ?>_just_for_question_link" id="x<?= $Grid->RowIndex ?>_just_for_question_link" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->just_for_question_link->getPlaceHolder()) ?>" value="<?= $Grid->just_for_question_link->EditValue ?>"<?= $Grid->just_for_question_link->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->just_for_question_link->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_just_for_question_link" data-hidden="1" name="o<?= $Grid->RowIndex ?>_just_for_question_link" id="o<?= $Grid->RowIndex ?>_just_for_question_link" value="<?= HtmlEncode($Grid->just_for_question_link->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_just_for_question_link" class="form-group">
<input type="<?= $Grid->just_for_question_link->getInputTextType() ?>" data-table="nist_to_iso27001" data-field="x_just_for_question_link" name="x<?= $Grid->RowIndex ?>_just_for_question_link" id="x<?= $Grid->RowIndex ?>_just_for_question_link" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->just_for_question_link->getPlaceHolder()) ?>" value="<?= $Grid->just_for_question_link->EditValue ?>"<?= $Grid->just_for_question_link->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->just_for_question_link->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_nist_to_iso27001_just_for_question_link">
<span<?= $Grid->just_for_question_link->viewAttributes() ?>>
<?= $Grid->just_for_question_link->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_just_for_question_link" data-hidden="1" name="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_just_for_question_link" id="fnist_to_iso27001grid$x<?= $Grid->RowIndex ?>_just_for_question_link" value="<?= HtmlEncode($Grid->just_for_question_link->FormValue) ?>">
<input type="hidden" data-table="nist_to_iso27001" data-field="x_just_for_question_link" data-hidden="1" name="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_just_for_question_link" id="fnist_to_iso27001grid$o<?= $Grid->RowIndex ?>_just_for_question_link" value="<?= HtmlEncode($Grid->just_for_question_link->OldValue) ?>">
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
loadjs.ready(["fnist_to_iso27001grid","load"], function () {
    fnist_to_iso27001grid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_nist_to_iso27001", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_nist_to_iso27001_id" class="form-group nist_to_iso27001_id"></span>
<?php } else { ?>
<span id="el$rowindex$_nist_to_iso27001_id" class="form-group nist_to_iso27001_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nistrefs_family->Visible) { // nistrefs_family ?>
        <td data-name="nistrefs_family">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->nistrefs_family->getSessionValue() != "") { ?>
<span id="el$rowindex$_nist_to_iso27001_nistrefs_family" class="form-group nist_to_iso27001_nistrefs_family">
<span<?= $Grid->nistrefs_family->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nistrefs_family->getDisplayValue($Grid->nistrefs_family->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_nistrefs_family" name="x<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_nist_to_iso27001_nistrefs_family" class="form-group nist_to_iso27001_nistrefs_family">
    <select
        id="x<?= $Grid->RowIndex ?>_nistrefs_family"
        name="x<?= $Grid->RowIndex ?>_nistrefs_family"
        class="form-control ew-select<?= $Grid->nistrefs_family->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family"
        data-table="nist_to_iso27001"
        data-field="x_nistrefs_family"
        data-value-separator="<?= $Grid->nistrefs_family->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nistrefs_family->getPlaceHolder()) ?>"
        <?= $Grid->nistrefs_family->editAttributes() ?>>
        <?= $Grid->nistrefs_family->selectOptionListHtml("x{$Grid->RowIndex}_nistrefs_family") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nistrefs_family->getErrorMessage() ?></div>
<?= $Grid->nistrefs_family->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nistrefs_family") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family']"),
        options = { name: "x<?= $Grid->RowIndex ?>_nistrefs_family", selectId: "nist_to_iso27001_x<?= $Grid->RowIndex ?>_nistrefs_family", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.nistrefs_family.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_nist_to_iso27001_nistrefs_family" class="form-group nist_to_iso27001_nistrefs_family">
<span<?= $Grid->nistrefs_family->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nistrefs_family->getDisplayValue($Grid->nistrefs_family->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_nistrefs_family" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nistrefs_family" id="x<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_nistrefs_family" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nistrefs_family" id="o<?= $Grid->RowIndex ?>_nistrefs_family" value="<?= HtmlEncode($Grid->nistrefs_family->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isorefs->Visible) { // isorefs ?>
        <td data-name="isorefs">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->isorefs->getSessionValue() != "") { ?>
<span id="el$rowindex$_nist_to_iso27001_isorefs" class="form-group nist_to_iso27001_isorefs">
<span<?= $Grid->isorefs->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isorefs->getDisplayValue($Grid->isorefs->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_isorefs" name="x<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_nist_to_iso27001_isorefs" class="form-group nist_to_iso27001_isorefs">
    <select
        id="x<?= $Grid->RowIndex ?>_isorefs"
        name="x<?= $Grid->RowIndex ?>_isorefs"
        class="form-control ew-select<?= $Grid->isorefs->isInvalidClass() ?>"
        data-select2-id="nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs"
        data-table="nist_to_iso27001"
        data-field="x_isorefs"
        data-value-separator="<?= $Grid->isorefs->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->isorefs->getPlaceHolder()) ?>"
        <?= $Grid->isorefs->editAttributes() ?>>
        <?= $Grid->isorefs->selectOptionListHtml("x{$Grid->RowIndex}_isorefs") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->isorefs->getErrorMessage() ?></div>
<?= $Grid->isorefs->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_isorefs") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs']"),
        options = { name: "x<?= $Grid->RowIndex ?>_isorefs", selectId: "nist_to_iso27001_x<?= $Grid->RowIndex ?>_isorefs", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.nist_to_iso27001.fields.isorefs.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_nist_to_iso27001_isorefs" class="form-group nist_to_iso27001_isorefs">
<span<?= $Grid->isorefs->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isorefs->getDisplayValue($Grid->isorefs->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_isorefs" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isorefs" id="x<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_isorefs" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isorefs" id="o<?= $Grid->RowIndex ?>_isorefs" value="<?= HtmlEncode($Grid->isorefs->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->just_for_question_link->Visible) { // just_for_question_link ?>
        <td data-name="just_for_question_link">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_nist_to_iso27001_just_for_question_link" class="form-group nist_to_iso27001_just_for_question_link">
<input type="<?= $Grid->just_for_question_link->getInputTextType() ?>" data-table="nist_to_iso27001" data-field="x_just_for_question_link" name="x<?= $Grid->RowIndex ?>_just_for_question_link" id="x<?= $Grid->RowIndex ?>_just_for_question_link" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->just_for_question_link->getPlaceHolder()) ?>" value="<?= $Grid->just_for_question_link->EditValue ?>"<?= $Grid->just_for_question_link->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->just_for_question_link->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_nist_to_iso27001_just_for_question_link" class="form-group nist_to_iso27001_just_for_question_link">
<span<?= $Grid->just_for_question_link->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->just_for_question_link->getDisplayValue($Grid->just_for_question_link->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_just_for_question_link" data-hidden="1" name="x<?= $Grid->RowIndex ?>_just_for_question_link" id="x<?= $Grid->RowIndex ?>_just_for_question_link" value="<?= HtmlEncode($Grid->just_for_question_link->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="nist_to_iso27001" data-field="x_just_for_question_link" data-hidden="1" name="o<?= $Grid->RowIndex ?>_just_for_question_link" id="o<?= $Grid->RowIndex ?>_just_for_question_link" value="<?= HtmlEncode($Grid->just_for_question_link->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnist_to_iso27001grid","load"], function() {
    fnist_to_iso27001grid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fnist_to_iso27001grid">
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
    ew.addEventHandlers("nist_to_iso27001");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
