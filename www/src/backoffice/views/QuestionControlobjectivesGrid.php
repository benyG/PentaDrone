<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("QuestionControlobjectivesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestion_controlobjectivesgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fquestion_controlobjectivesgrid = new ew.Form("fquestion_controlobjectivesgrid", "grid");
    fquestion_controlobjectivesgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "question_controlobjectives")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.question_controlobjectives)
        ew.vars.tables.question_controlobjectives = currentTable;
    fquestion_controlobjectivesgrid.addFields([
        ["num_ordre", [fields.num_ordre.visible && fields.num_ordre.required ? ew.Validators.required(fields.num_ordre.caption) : null, ew.Validators.integer], fields.num_ordre.isInvalid],
        ["controlObj_name", [fields.controlObj_name.visible && fields.controlObj_name.required ? ew.Validators.required(fields.controlObj_name.caption) : null], fields.controlObj_name.isInvalid],
        ["question_domain_id", [fields.question_domain_id.visible && fields.question_domain_id.required ? ew.Validators.required(fields.question_domain_id.caption) : null], fields.question_domain_id.isInvalid],
        ["layer_id", [fields.layer_id.visible && fields.layer_id.required ? ew.Validators.required(fields.layer_id.caption) : null], fields.layer_id.isInvalid],
        ["function_csf", [fields.function_csf.visible && fields.function_csf.required ? ew.Validators.required(fields.function_csf.caption) : null], fields.function_csf.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestion_controlobjectivesgrid,
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
    fquestion_controlobjectivesgrid.validate = function () {
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
    fquestion_controlobjectivesgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "num_ordre", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "controlObj_name", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "question_domain_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "layer_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "function_csf", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_at", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "updated_at", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fquestion_controlobjectivesgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestion_controlobjectivesgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fquestion_controlobjectivesgrid.lists.question_domain_id = <?= $Grid->question_domain_id->toClientList($Grid) ?>;
    fquestion_controlobjectivesgrid.lists.layer_id = <?= $Grid->layer_id->toClientList($Grid) ?>;
    fquestion_controlobjectivesgrid.lists.function_csf = <?= $Grid->function_csf->toClientList($Grid) ?>;
    loadjs.done("fquestion_controlobjectivesgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> question_controlobjectives">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fquestion_controlobjectivesgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_question_controlobjectives" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_question_controlobjectivesgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->num_ordre->Visible) { // num_ordre ?>
        <th data-name="num_ordre" class="<?= $Grid->num_ordre->headerCellClass() ?>"><div id="elh_question_controlobjectives_num_ordre" class="question_controlobjectives_num_ordre"><?= $Grid->renderSort($Grid->num_ordre) ?></div></th>
<?php } ?>
<?php if ($Grid->controlObj_name->Visible) { // controlObj_name ?>
        <th data-name="controlObj_name" class="<?= $Grid->controlObj_name->headerCellClass() ?>"><div id="elh_question_controlobjectives_controlObj_name" class="question_controlobjectives_controlObj_name"><?= $Grid->renderSort($Grid->controlObj_name) ?></div></th>
<?php } ?>
<?php if ($Grid->question_domain_id->Visible) { // question_domain_id ?>
        <th data-name="question_domain_id" class="<?= $Grid->question_domain_id->headerCellClass() ?>"><div id="elh_question_controlobjectives_question_domain_id" class="question_controlobjectives_question_domain_id"><?= $Grid->renderSort($Grid->question_domain_id) ?></div></th>
<?php } ?>
<?php if ($Grid->layer_id->Visible) { // layer_id ?>
        <th data-name="layer_id" class="<?= $Grid->layer_id->headerCellClass() ?>"><div id="elh_question_controlobjectives_layer_id" class="question_controlobjectives_layer_id"><?= $Grid->renderSort($Grid->layer_id) ?></div></th>
<?php } ?>
<?php if ($Grid->function_csf->Visible) { // function_csf ?>
        <th data-name="function_csf" class="<?= $Grid->function_csf->headerCellClass() ?>"><div id="elh_question_controlobjectives_function_csf" class="question_controlobjectives_function_csf"><?= $Grid->renderSort($Grid->function_csf) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_question_controlobjectives_created_at" class="question_controlobjectives_created_at"><?= $Grid->renderSort($Grid->created_at) ?></div></th>
<?php } ?>
<?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Grid->updated_at->headerCellClass() ?>"><div id="elh_question_controlobjectives_updated_at" class="question_controlobjectives_updated_at"><?= $Grid->renderSort($Grid->updated_at) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_question_controlobjectives", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->num_ordre->Visible) { // num_ordre ?>
        <td data-name="num_ordre" <?= $Grid->num_ordre->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_num_ordre" class="form-group">
<input type="<?= $Grid->num_ordre->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_num_ordre" name="x<?= $Grid->RowIndex ?>_num_ordre" id="x<?= $Grid->RowIndex ?>_num_ordre" size="30" placeholder="<?= HtmlEncode($Grid->num_ordre->getPlaceHolder()) ?>" value="<?= $Grid->num_ordre->EditValue ?>"<?= $Grid->num_ordre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_ordre->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_num_ordre" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_ordre" id="o<?= $Grid->RowIndex ?>_num_ordre" value="<?= HtmlEncode($Grid->num_ordre->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_num_ordre" class="form-group">
<input type="<?= $Grid->num_ordre->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_num_ordre" name="x<?= $Grid->RowIndex ?>_num_ordre" id="x<?= $Grid->RowIndex ?>_num_ordre" size="30" placeholder="<?= HtmlEncode($Grid->num_ordre->getPlaceHolder()) ?>" value="<?= $Grid->num_ordre->EditValue ?>"<?= $Grid->num_ordre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_ordre->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_num_ordre">
<span<?= $Grid->num_ordre->viewAttributes() ?>>
<?= $Grid->num_ordre->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_num_ordre" data-hidden="1" name="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_num_ordre" id="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_num_ordre" value="<?= HtmlEncode($Grid->num_ordre->FormValue) ?>">
<input type="hidden" data-table="question_controlobjectives" data-field="x_num_ordre" data-hidden="1" name="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_num_ordre" id="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_num_ordre" value="<?= HtmlEncode($Grid->num_ordre->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->controlObj_name->Visible) { // controlObj_name ?>
        <td data-name="controlObj_name" <?= $Grid->controlObj_name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_controlObj_name" class="form-group">
<input type="<?= $Grid->controlObj_name->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_controlObj_name" name="x<?= $Grid->RowIndex ?>_controlObj_name" id="x<?= $Grid->RowIndex ?>_controlObj_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->controlObj_name->getPlaceHolder()) ?>" value="<?= $Grid->controlObj_name->EditValue ?>"<?= $Grid->controlObj_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->controlObj_name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_controlObj_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_controlObj_name" id="o<?= $Grid->RowIndex ?>_controlObj_name" value="<?= HtmlEncode($Grid->controlObj_name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->controlObj_name->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_controlObj_name" name="x<?= $Grid->RowIndex ?>_controlObj_name" id="x<?= $Grid->RowIndex ?>_controlObj_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->controlObj_name->getPlaceHolder()) ?>" value="<?= $Grid->controlObj_name->EditValue ?>"<?= $Grid->controlObj_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->controlObj_name->getErrorMessage() ?></div>
<input type="hidden" data-table="question_controlobjectives" data-field="x_controlObj_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_controlObj_name" id="o<?= $Grid->RowIndex ?>_controlObj_name" value="<?= HtmlEncode($Grid->controlObj_name->OldValue ?? $Grid->controlObj_name->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_controlObj_name">
<span<?= $Grid->controlObj_name->viewAttributes() ?>>
<?= $Grid->controlObj_name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_controlObj_name" data-hidden="1" name="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_controlObj_name" id="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_controlObj_name" value="<?= HtmlEncode($Grid->controlObj_name->FormValue) ?>">
<input type="hidden" data-table="question_controlobjectives" data-field="x_controlObj_name" data-hidden="1" name="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_controlObj_name" id="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_controlObj_name" value="<?= HtmlEncode($Grid->controlObj_name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="question_controlobjectives" data-field="x_controlObj_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_controlObj_name" id="x<?= $Grid->RowIndex ?>_controlObj_name" value="<?= HtmlEncode($Grid->controlObj_name->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->question_domain_id->Visible) { // question_domain_id ?>
        <td data-name="question_domain_id" <?= $Grid->question_domain_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->question_domain_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_question_domain_id" class="form-group">
<span<?= $Grid->question_domain_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_domain_id->getDisplayValue($Grid->question_domain_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_question_domain_id" name="x<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_question_domain_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_question_domain_id"
        name="x<?= $Grid->RowIndex ?>_question_domain_id"
        class="form-control ew-select<?= $Grid->question_domain_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id"
        data-table="question_controlobjectives"
        data-field="x_question_domain_id"
        data-value-separator="<?= $Grid->question_domain_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->question_domain_id->getPlaceHolder()) ?>"
        <?= $Grid->question_domain_id->editAttributes() ?>>
        <?= $Grid->question_domain_id->selectOptionListHtml("x{$Grid->RowIndex}_question_domain_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->question_domain_id->getErrorMessage() ?></div>
<?= $Grid->question_domain_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_question_domain_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_question_domain_id", selectId: "question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.question_domain_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_question_domain_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_question_domain_id" id="o<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->question_domain_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_question_domain_id" class="form-group">
<span<?= $Grid->question_domain_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_domain_id->getDisplayValue($Grid->question_domain_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_question_domain_id" name="x<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_question_domain_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_question_domain_id"
        name="x<?= $Grid->RowIndex ?>_question_domain_id"
        class="form-control ew-select<?= $Grid->question_domain_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id"
        data-table="question_controlobjectives"
        data-field="x_question_domain_id"
        data-value-separator="<?= $Grid->question_domain_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->question_domain_id->getPlaceHolder()) ?>"
        <?= $Grid->question_domain_id->editAttributes() ?>>
        <?= $Grid->question_domain_id->selectOptionListHtml("x{$Grid->RowIndex}_question_domain_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->question_domain_id->getErrorMessage() ?></div>
<?= $Grid->question_domain_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_question_domain_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_question_domain_id", selectId: "question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.question_domain_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_question_domain_id">
<span<?= $Grid->question_domain_id->viewAttributes() ?>>
<?= $Grid->question_domain_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_question_domain_id" data-hidden="1" name="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_question_domain_id" id="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->FormValue) ?>">
<input type="hidden" data-table="question_controlobjectives" data-field="x_question_domain_id" data-hidden="1" name="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_question_domain_id" id="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->layer_id->Visible) { // layer_id ?>
        <td data-name="layer_id" <?= $Grid->layer_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->layer_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_layer_id" class="form-group">
<span<?= $Grid->layer_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer_id->getDisplayValue($Grid->layer_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_layer_id" name="x<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_layer_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_layer_id"
        name="x<?= $Grid->RowIndex ?>_layer_id"
        class="form-control ew-select<?= $Grid->layer_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id"
        data-table="question_controlobjectives"
        data-field="x_layer_id"
        data-value-separator="<?= $Grid->layer_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->layer_id->getPlaceHolder()) ?>"
        <?= $Grid->layer_id->editAttributes() ?>>
        <?= $Grid->layer_id->selectOptionListHtml("x{$Grid->RowIndex}_layer_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->layer_id->getErrorMessage() ?></div>
<?= $Grid->layer_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_layer_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_layer_id", selectId: "question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.layer_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_layer_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_layer_id" id="o<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->layer_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_layer_id" class="form-group">
<span<?= $Grid->layer_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer_id->getDisplayValue($Grid->layer_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_layer_id" name="x<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_layer_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_layer_id"
        name="x<?= $Grid->RowIndex ?>_layer_id"
        class="form-control ew-select<?= $Grid->layer_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id"
        data-table="question_controlobjectives"
        data-field="x_layer_id"
        data-value-separator="<?= $Grid->layer_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->layer_id->getPlaceHolder()) ?>"
        <?= $Grid->layer_id->editAttributes() ?>>
        <?= $Grid->layer_id->selectOptionListHtml("x{$Grid->RowIndex}_layer_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->layer_id->getErrorMessage() ?></div>
<?= $Grid->layer_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_layer_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_layer_id", selectId: "question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.layer_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_layer_id">
<span<?= $Grid->layer_id->viewAttributes() ?>>
<?= $Grid->layer_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_layer_id" data-hidden="1" name="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_layer_id" id="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->FormValue) ?>">
<input type="hidden" data-table="question_controlobjectives" data-field="x_layer_id" data-hidden="1" name="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_layer_id" id="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf" <?= $Grid->function_csf->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->function_csf->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_function_csf" class="form-group">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_function_csf" name="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_function_csf" class="form-group">
<?php
$onchange = $Grid->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Grid->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_function_csf" id="sv_x<?= $Grid->RowIndex ?>_function_csf" value="<?= RemoveHtml($Grid->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>"<?= $Grid->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="question_controlobjectives" data-field="x_function_csf" data-input="sv_x<?= $Grid->RowIndex ?>_function_csf" data-value-separator="<?= $Grid->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid"], function() {
    fquestion_controlobjectivesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.question_controlobjectives.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Grid->function_csf->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_function_csf" data-hidden="1" name="o<?= $Grid->RowIndex ?>_function_csf" id="o<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->function_csf->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_function_csf" class="form-group">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_function_csf" name="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_function_csf" class="form-group">
<?php
$onchange = $Grid->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Grid->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_function_csf" id="sv_x<?= $Grid->RowIndex ?>_function_csf" value="<?= RemoveHtml($Grid->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>"<?= $Grid->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="question_controlobjectives" data-field="x_function_csf" data-input="sv_x<?= $Grid->RowIndex ?>_function_csf" data-value-separator="<?= $Grid->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid"], function() {
    fquestion_controlobjectivesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.question_controlobjectives.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Grid->function_csf->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_function_csf">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<?= $Grid->function_csf->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_function_csf" data-hidden="1" name="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_function_csf" id="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->FormValue) ?>">
<input type="hidden" data-table="question_controlobjectives" data-field="x_function_csf" data-hidden="1" name="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_function_csf" id="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_created_at" data-hidden="1" name="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_created_at" id="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="question_controlobjectives" data-field="x_created_at" data-hidden="1" name="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_created_at" id="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at" <?= $Grid->updated_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_updated_at" class="form-group">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesgrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_updated_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_updated_at" id="o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_updated_at" class="form-group">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesgrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_controlobjectives_updated_at">
<span<?= $Grid->updated_at->viewAttributes() ?>>
<?= $Grid->updated_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_updated_at" data-hidden="1" name="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_updated_at" id="fquestion_controlobjectivesgrid$x<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->FormValue) ?>">
<input type="hidden" data-table="question_controlobjectives" data-field="x_updated_at" data-hidden="1" name="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_updated_at" id="fquestion_controlobjectivesgrid$o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
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
loadjs.ready(["fquestion_controlobjectivesgrid","load"], function () {
    fquestion_controlobjectivesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_question_controlobjectives", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->num_ordre->Visible) { // num_ordre ?>
        <td data-name="num_ordre">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_question_controlobjectives_num_ordre" class="form-group question_controlobjectives_num_ordre">
<input type="<?= $Grid->num_ordre->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_num_ordre" name="x<?= $Grid->RowIndex ?>_num_ordre" id="x<?= $Grid->RowIndex ?>_num_ordre" size="30" placeholder="<?= HtmlEncode($Grid->num_ordre->getPlaceHolder()) ?>" value="<?= $Grid->num_ordre->EditValue ?>"<?= $Grid->num_ordre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_ordre->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_num_ordre" class="form-group question_controlobjectives_num_ordre">
<span<?= $Grid->num_ordre->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->num_ordre->getDisplayValue($Grid->num_ordre->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_num_ordre" data-hidden="1" name="x<?= $Grid->RowIndex ?>_num_ordre" id="x<?= $Grid->RowIndex ?>_num_ordre" value="<?= HtmlEncode($Grid->num_ordre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_num_ordre" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_ordre" id="o<?= $Grid->RowIndex ?>_num_ordre" value="<?= HtmlEncode($Grid->num_ordre->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->controlObj_name->Visible) { // controlObj_name ?>
        <td data-name="controlObj_name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_question_controlobjectives_controlObj_name" class="form-group question_controlobjectives_controlObj_name">
<input type="<?= $Grid->controlObj_name->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_controlObj_name" name="x<?= $Grid->RowIndex ?>_controlObj_name" id="x<?= $Grid->RowIndex ?>_controlObj_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->controlObj_name->getPlaceHolder()) ?>" value="<?= $Grid->controlObj_name->EditValue ?>"<?= $Grid->controlObj_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->controlObj_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_controlObj_name" class="form-group question_controlobjectives_controlObj_name">
<span<?= $Grid->controlObj_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->controlObj_name->getDisplayValue($Grid->controlObj_name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_controlObj_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_controlObj_name" id="x<?= $Grid->RowIndex ?>_controlObj_name" value="<?= HtmlEncode($Grid->controlObj_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_controlObj_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_controlObj_name" id="o<?= $Grid->RowIndex ?>_controlObj_name" value="<?= HtmlEncode($Grid->controlObj_name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->question_domain_id->Visible) { // question_domain_id ?>
        <td data-name="question_domain_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->question_domain_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_question_controlobjectives_question_domain_id" class="form-group question_controlobjectives_question_domain_id">
<span<?= $Grid->question_domain_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_domain_id->getDisplayValue($Grid->question_domain_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_question_domain_id" name="x<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_question_domain_id" class="form-group question_controlobjectives_question_domain_id">
    <select
        id="x<?= $Grid->RowIndex ?>_question_domain_id"
        name="x<?= $Grid->RowIndex ?>_question_domain_id"
        class="form-control ew-select<?= $Grid->question_domain_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id"
        data-table="question_controlobjectives"
        data-field="x_question_domain_id"
        data-value-separator="<?= $Grid->question_domain_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->question_domain_id->getPlaceHolder()) ?>"
        <?= $Grid->question_domain_id->editAttributes() ?>>
        <?= $Grid->question_domain_id->selectOptionListHtml("x{$Grid->RowIndex}_question_domain_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->question_domain_id->getErrorMessage() ?></div>
<?= $Grid->question_domain_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_question_domain_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_question_domain_id", selectId: "question_controlobjectives_x<?= $Grid->RowIndex ?>_question_domain_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.question_domain_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_question_domain_id" class="form-group question_controlobjectives_question_domain_id">
<span<?= $Grid->question_domain_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_domain_id->getDisplayValue($Grid->question_domain_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_question_domain_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_question_domain_id" id="x<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_question_domain_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_question_domain_id" id="o<?= $Grid->RowIndex ?>_question_domain_id" value="<?= HtmlEncode($Grid->question_domain_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->layer_id->Visible) { // layer_id ?>
        <td data-name="layer_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->layer_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_question_controlobjectives_layer_id" class="form-group question_controlobjectives_layer_id">
<span<?= $Grid->layer_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer_id->getDisplayValue($Grid->layer_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_layer_id" name="x<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_layer_id" class="form-group question_controlobjectives_layer_id">
    <select
        id="x<?= $Grid->RowIndex ?>_layer_id"
        name="x<?= $Grid->RowIndex ?>_layer_id"
        class="form-control ew-select<?= $Grid->layer_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id"
        data-table="question_controlobjectives"
        data-field="x_layer_id"
        data-value-separator="<?= $Grid->layer_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->layer_id->getPlaceHolder()) ?>"
        <?= $Grid->layer_id->editAttributes() ?>>
        <?= $Grid->layer_id->selectOptionListHtml("x{$Grid->RowIndex}_layer_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->layer_id->getErrorMessage() ?></div>
<?= $Grid->layer_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_layer_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_layer_id", selectId: "question_controlobjectives_x<?= $Grid->RowIndex ?>_layer_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.layer_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_layer_id" class="form-group question_controlobjectives_layer_id">
<span<?= $Grid->layer_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer_id->getDisplayValue($Grid->layer_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_layer_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_layer_id" id="x<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_layer_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_layer_id" id="o<?= $Grid->RowIndex ?>_layer_id" value="<?= HtmlEncode($Grid->layer_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->function_csf->getSessionValue() != "") { ?>
<span id="el$rowindex$_question_controlobjectives_function_csf" class="form-group question_controlobjectives_function_csf">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_function_csf" name="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_function_csf" class="form-group question_controlobjectives_function_csf">
<?php
$onchange = $Grid->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Grid->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_function_csf" id="sv_x<?= $Grid->RowIndex ?>_function_csf" value="<?= RemoveHtml($Grid->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>"<?= $Grid->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="question_controlobjectives" data-field="x_function_csf" data-input="sv_x<?= $Grid->RowIndex ?>_function_csf" data-value-separator="<?= $Grid->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid"], function() {
    fquestion_controlobjectivesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.question_controlobjectives.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Grid->function_csf->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_function_csf" class="form-group question_controlobjectives_function_csf">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_function_csf" data-hidden="1" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_function_csf" data-hidden="1" name="o<?= $Grid->RowIndex ?>_function_csf" id="o<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_question_controlobjectives_created_at" class="form-group question_controlobjectives_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_created_at" class="form-group question_controlobjectives_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_at->getDisplayValue($Grid->created_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_created_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_question_controlobjectives_updated_at" class="form-group question_controlobjectives_updated_at">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesgrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_question_controlobjectives_updated_at" class="form-group question_controlobjectives_updated_at">
<span<?= $Grid->updated_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->updated_at->getDisplayValue($Grid->updated_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_controlobjectives" data-field="x_updated_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_controlobjectives" data-field="x_updated_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_updated_at" id="o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fquestion_controlobjectivesgrid","load"], function() {
    fquestion_controlobjectivesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fquestion_controlobjectivesgrid">
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
    ew.addEventHandlers("question_controlobjectives");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
