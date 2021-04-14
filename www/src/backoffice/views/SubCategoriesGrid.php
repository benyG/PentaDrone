<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("SubCategoriesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsub_categoriesgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsub_categoriesgrid = new ew.Form("fsub_categoriesgrid", "grid");
    fsub_categoriesgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sub_categories")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sub_categories)
        ew.vars.tables.sub_categories = currentTable;
    fsub_categoriesgrid.addFields([
        ["code_nist", [fields.code_nist.visible && fields.code_nist.required ? ew.Validators.required(fields.code_nist.caption) : null], fields.code_nist.isInvalid],
        ["statement", [fields.statement.visible && fields.statement.required ? ew.Validators.required(fields.statement.caption) : null], fields.statement.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsub_categoriesgrid,
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
    fsub_categoriesgrid.validate = function () {
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
    fsub_categoriesgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "code_nist", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "statement", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsub_categoriesgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsub_categoriesgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsub_categoriesgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sub_categories">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fsub_categoriesgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_sub_categories" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_sub_categoriesgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->code_nist->Visible) { // code_nist ?>
        <th data-name="code_nist" class="<?= $Grid->code_nist->headerCellClass() ?>"><div id="elh_sub_categories_code_nist" class="sub_categories_code_nist"><?= $Grid->renderSort($Grid->code_nist) ?></div></th>
<?php } ?>
<?php if ($Grid->statement->Visible) { // statement ?>
        <th data-name="statement" class="<?= $Grid->statement->headerCellClass() ?>"><div id="elh_sub_categories_statement" class="sub_categories_statement"><?= $Grid->renderSort($Grid->statement) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_sub_categories", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->code_nist->Visible) { // code_nist ?>
        <td data-name="code_nist" <?= $Grid->code_nist->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sub_categories_code_nist" class="form-group">
<input type="<?= $Grid->code_nist->getInputTextType() ?>" data-table="sub_categories" data-field="x_code_nist" name="x<?= $Grid->RowIndex ?>_code_nist" id="x<?= $Grid->RowIndex ?>_code_nist" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->code_nist->getPlaceHolder()) ?>" value="<?= $Grid->code_nist->EditValue ?>"<?= $Grid->code_nist->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->code_nist->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="o<?= $Grid->RowIndex ?>_code_nist" id="o<?= $Grid->RowIndex ?>_code_nist" value="<?= HtmlEncode($Grid->code_nist->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->code_nist->getInputTextType() ?>" data-table="sub_categories" data-field="x_code_nist" name="x<?= $Grid->RowIndex ?>_code_nist" id="x<?= $Grid->RowIndex ?>_code_nist" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->code_nist->getPlaceHolder()) ?>" value="<?= $Grid->code_nist->EditValue ?>"<?= $Grid->code_nist->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->code_nist->getErrorMessage() ?></div>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="o<?= $Grid->RowIndex ?>_code_nist" id="o<?= $Grid->RowIndex ?>_code_nist" value="<?= HtmlEncode($Grid->code_nist->OldValue ?? $Grid->code_nist->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_categories_code_nist">
<span<?= $Grid->code_nist->viewAttributes() ?>>
<?= $Grid->code_nist->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="fsub_categoriesgrid$x<?= $Grid->RowIndex ?>_code_nist" id="fsub_categoriesgrid$x<?= $Grid->RowIndex ?>_code_nist" value="<?= HtmlEncode($Grid->code_nist->FormValue) ?>">
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="fsub_categoriesgrid$o<?= $Grid->RowIndex ?>_code_nist" id="fsub_categoriesgrid$o<?= $Grid->RowIndex ?>_code_nist" value="<?= HtmlEncode($Grid->code_nist->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="x<?= $Grid->RowIndex ?>_code_nist" id="x<?= $Grid->RowIndex ?>_code_nist" value="<?= HtmlEncode($Grid->code_nist->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->statement->Visible) { // statement ?>
        <td data-name="statement" <?= $Grid->statement->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sub_categories_statement" class="form-group">
<input type="<?= $Grid->statement->getInputTextType() ?>" data-table="sub_categories" data-field="x_statement" name="x<?= $Grid->RowIndex ?>_statement" id="x<?= $Grid->RowIndex ?>_statement" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->statement->getPlaceHolder()) ?>" value="<?= $Grid->statement->EditValue ?>"<?= $Grid->statement->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->statement->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="o<?= $Grid->RowIndex ?>_statement" id="o<?= $Grid->RowIndex ?>_statement" value="<?= HtmlEncode($Grid->statement->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sub_categories_statement" class="form-group">
<input type="<?= $Grid->statement->getInputTextType() ?>" data-table="sub_categories" data-field="x_statement" name="x<?= $Grid->RowIndex ?>_statement" id="x<?= $Grid->RowIndex ?>_statement" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->statement->getPlaceHolder()) ?>" value="<?= $Grid->statement->EditValue ?>"<?= $Grid->statement->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->statement->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sub_categories_statement">
<span<?= $Grid->statement->viewAttributes() ?>>
<?= $Grid->statement->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="fsub_categoriesgrid$x<?= $Grid->RowIndex ?>_statement" id="fsub_categoriesgrid$x<?= $Grid->RowIndex ?>_statement" value="<?= HtmlEncode($Grid->statement->FormValue) ?>">
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="fsub_categoriesgrid$o<?= $Grid->RowIndex ?>_statement" id="fsub_categoriesgrid$o<?= $Grid->RowIndex ?>_statement" value="<?= HtmlEncode($Grid->statement->OldValue) ?>">
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
loadjs.ready(["fsub_categoriesgrid","load"], function () {
    fsub_categoriesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_sub_categories", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->code_nist->Visible) { // code_nist ?>
        <td data-name="code_nist">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sub_categories_code_nist" class="form-group sub_categories_code_nist">
<input type="<?= $Grid->code_nist->getInputTextType() ?>" data-table="sub_categories" data-field="x_code_nist" name="x<?= $Grid->RowIndex ?>_code_nist" id="x<?= $Grid->RowIndex ?>_code_nist" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->code_nist->getPlaceHolder()) ?>" value="<?= $Grid->code_nist->EditValue ?>"<?= $Grid->code_nist->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->code_nist->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_categories_code_nist" class="form-group sub_categories_code_nist">
<span<?= $Grid->code_nist->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->code_nist->getDisplayValue($Grid->code_nist->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="x<?= $Grid->RowIndex ?>_code_nist" id="x<?= $Grid->RowIndex ?>_code_nist" value="<?= HtmlEncode($Grid->code_nist->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_categories" data-field="x_code_nist" data-hidden="1" name="o<?= $Grid->RowIndex ?>_code_nist" id="o<?= $Grid->RowIndex ?>_code_nist" value="<?= HtmlEncode($Grid->code_nist->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->statement->Visible) { // statement ?>
        <td data-name="statement">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sub_categories_statement" class="form-group sub_categories_statement">
<input type="<?= $Grid->statement->getInputTextType() ?>" data-table="sub_categories" data-field="x_statement" name="x<?= $Grid->RowIndex ?>_statement" id="x<?= $Grid->RowIndex ?>_statement" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->statement->getPlaceHolder()) ?>" value="<?= $Grid->statement->EditValue ?>"<?= $Grid->statement->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->statement->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_categories_statement" class="form-group sub_categories_statement">
<span<?= $Grid->statement->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->statement->getDisplayValue($Grid->statement->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="x<?= $Grid->RowIndex ?>_statement" id="x<?= $Grid->RowIndex ?>_statement" value="<?= HtmlEncode($Grid->statement->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_categories" data-field="x_statement" data-hidden="1" name="o<?= $Grid->RowIndex ?>_statement" id="o<?= $Grid->RowIndex ?>_statement" value="<?= HtmlEncode($Grid->statement->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsub_categoriesgrid","load"], function() {
    fsub_categoriesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fsub_categoriesgrid">
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
    ew.addEventHandlers("sub_categories");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
