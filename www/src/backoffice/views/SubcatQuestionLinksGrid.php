<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Set up and run Grid object
$Grid = Container("SubcatQuestionLinksGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsubcat_question_linksgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsubcat_question_linksgrid = new ew.Form("fsubcat_question_linksgrid", "grid");
    fsubcat_question_linksgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subcat_question_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subcat_question_links)
        ew.vars.tables.subcat_question_links = currentTable;
    fsubcat_question_linksgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["questions_id", [fields.questions_id.visible && fields.questions_id.required ? ew.Validators.required(fields.questions_id.caption) : null], fields.questions_id.isInvalid],
        ["subcat_id", [fields.subcat_id.visible && fields.subcat_id.required ? ew.Validators.required(fields.subcat_id.caption) : null], fields.subcat_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubcat_question_linksgrid,
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
    fsubcat_question_linksgrid.validate = function () {
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
    fsubcat_question_linksgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "questions_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "subcat_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsubcat_question_linksgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubcat_question_linksgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsubcat_question_linksgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> subcat_question_links">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fsubcat_question_linksgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_subcat_question_links" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_subcat_question_linksgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_subcat_question_links_id" class="subcat_question_links_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->questions_id->Visible) { // questions_id ?>
        <th data-name="questions_id" class="<?= $Grid->questions_id->headerCellClass() ?>"><div id="elh_subcat_question_links_questions_id" class="subcat_question_links_questions_id"><?= $Grid->renderSort($Grid->questions_id) ?></div></th>
<?php } ?>
<?php if ($Grid->subcat_id->Visible) { // subcat_id ?>
        <th data-name="subcat_id" class="<?= $Grid->subcat_id->headerCellClass() ?>"><div id="elh_subcat_question_links_subcat_id" class="subcat_question_links_subcat_id"><?= $Grid->renderSort($Grid->subcat_id) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_subcat_question_links", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_id" class="form-group"></span>
<input type="hidden" data-table="subcat_question_links" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_question_links" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_id" data-hidden="1" name="fsubcat_question_linksgrid$x<?= $Grid->RowIndex ?>_id" id="fsubcat_question_linksgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="subcat_question_links" data-field="x_id" data-hidden="1" name="fsubcat_question_linksgrid$o<?= $Grid->RowIndex ?>_id" id="fsubcat_question_linksgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="subcat_question_links" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->questions_id->Visible) { // questions_id ?>
        <td data-name="questions_id" <?= $Grid->questions_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->questions_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_questions_id" class="form-group">
<span<?= $Grid->questions_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->questions_id->getDisplayValue($Grid->questions_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_questions_id" name="x<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_questions_id" class="form-group">
<input type="<?= $Grid->questions_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_questions_id" name="x<?= $Grid->RowIndex ?>_questions_id" id="x<?= $Grid->RowIndex ?>_questions_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->questions_id->getPlaceHolder()) ?>" value="<?= $Grid->questions_id->EditValue ?>"<?= $Grid->questions_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->questions_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_questions_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_questions_id" id="o<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->questions_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_questions_id" class="form-group">
<span<?= $Grid->questions_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->questions_id->getDisplayValue($Grid->questions_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_questions_id" name="x<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_questions_id" class="form-group">
<input type="<?= $Grid->questions_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_questions_id" name="x<?= $Grid->RowIndex ?>_questions_id" id="x<?= $Grid->RowIndex ?>_questions_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->questions_id->getPlaceHolder()) ?>" value="<?= $Grid->questions_id->EditValue ?>"<?= $Grid->questions_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->questions_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_questions_id">
<span<?= $Grid->questions_id->viewAttributes() ?>>
<?= $Grid->questions_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_questions_id" data-hidden="1" name="fsubcat_question_linksgrid$x<?= $Grid->RowIndex ?>_questions_id" id="fsubcat_question_linksgrid$x<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->FormValue) ?>">
<input type="hidden" data-table="subcat_question_links" data-field="x_questions_id" data-hidden="1" name="fsubcat_question_linksgrid$o<?= $Grid->RowIndex ?>_questions_id" id="fsubcat_question_linksgrid$o<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->subcat_id->Visible) { // subcat_id ?>
        <td data-name="subcat_id" <?= $Grid->subcat_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->subcat_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_subcat_id" class="form-group">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_subcat_id" class="form-group">
<input type="<?= $Grid->subcat_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" id="x<?= $Grid->RowIndex ?>_subcat_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->subcat_id->getPlaceHolder()) ?>" value="<?= $Grid->subcat_id->EditValue ?>"<?= $Grid->subcat_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subcat_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_subcat_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subcat_id" id="o<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->subcat_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_subcat_id" class="form-group">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_subcat_id" class="form-group">
<input type="<?= $Grid->subcat_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" id="x<?= $Grid->RowIndex ?>_subcat_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->subcat_id->getPlaceHolder()) ?>" value="<?= $Grid->subcat_id->EditValue ?>"<?= $Grid->subcat_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subcat_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subcat_question_links_subcat_id">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<?= $Grid->subcat_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_subcat_id" data-hidden="1" name="fsubcat_question_linksgrid$x<?= $Grid->RowIndex ?>_subcat_id" id="fsubcat_question_linksgrid$x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->FormValue) ?>">
<input type="hidden" data-table="subcat_question_links" data-field="x_subcat_id" data-hidden="1" name="fsubcat_question_linksgrid$o<?= $Grid->RowIndex ?>_subcat_id" id="fsubcat_question_linksgrid$o<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->OldValue) ?>">
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
loadjs.ready(["fsubcat_question_linksgrid","load"], function () {
    fsubcat_question_linksgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_subcat_question_links", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_subcat_question_links_id" class="form-group subcat_question_links_id"></span>
<?php } else { ?>
<span id="el$rowindex$_subcat_question_links_id" class="form-group subcat_question_links_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_question_links" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->questions_id->Visible) { // questions_id ?>
        <td data-name="questions_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->questions_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_subcat_question_links_questions_id" class="form-group subcat_question_links_questions_id">
<span<?= $Grid->questions_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->questions_id->getDisplayValue($Grid->questions_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_questions_id" name="x<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_subcat_question_links_questions_id" class="form-group subcat_question_links_questions_id">
<input type="<?= $Grid->questions_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_questions_id" name="x<?= $Grid->RowIndex ?>_questions_id" id="x<?= $Grid->RowIndex ?>_questions_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->questions_id->getPlaceHolder()) ?>" value="<?= $Grid->questions_id->EditValue ?>"<?= $Grid->questions_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->questions_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_subcat_question_links_questions_id" class="form-group subcat_question_links_questions_id">
<span<?= $Grid->questions_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->questions_id->getDisplayValue($Grid->questions_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_question_links" data-field="x_questions_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_questions_id" id="x<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_questions_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_questions_id" id="o<?= $Grid->RowIndex ?>_questions_id" value="<?= HtmlEncode($Grid->questions_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subcat_id->Visible) { // subcat_id ?>
        <td data-name="subcat_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->subcat_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_subcat_question_links_subcat_id" class="form-group subcat_question_links_subcat_id">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_subcat_question_links_subcat_id" class="form-group subcat_question_links_subcat_id">
<input type="<?= $Grid->subcat_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" id="x<?= $Grid->RowIndex ?>_subcat_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->subcat_id->getPlaceHolder()) ?>" value="<?= $Grid->subcat_id->EditValue ?>"<?= $Grid->subcat_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subcat_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_subcat_question_links_subcat_id" class="form-group subcat_question_links_subcat_id">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_question_links" data-field="x_subcat_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subcat_id" id="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcat_question_links" data-field="x_subcat_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subcat_id" id="o<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsubcat_question_linksgrid","load"], function() {
    fsubcat_question_linksgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fsubcat_question_linksgrid">
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
    ew.addEventHandlers("subcat_question_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
