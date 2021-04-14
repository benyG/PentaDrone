<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("SubcatCobitLinksGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsubcat_cobit_linksgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsubcat_cobit_linksgrid = new ew.Form("fsubcat_cobit_linksgrid", "grid");
    fsubcat_cobit_linksgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subcat_cobit_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subcat_cobit_links)
        ew.vars.tables.subcat_cobit_links = currentTable;
    fsubcat_cobit_linksgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["subcat_id", [fields.subcat_id.visible && fields.subcat_id.required ? ew.Validators.required(fields.subcat_id.caption) : null], fields.subcat_id.isInvalid],
        ["cobitrefs_id", [fields.cobitrefs_id.visible && fields.cobitrefs_id.required ? ew.Validators.required(fields.cobitrefs_id.caption) : null], fields.cobitrefs_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubcat_cobit_linksgrid,
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
    fsubcat_cobit_linksgrid.validate = function () {
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
    fsubcat_cobit_linksgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "subcat_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "cobitrefs_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsubcat_cobit_linksgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubcat_cobit_linksgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsubcat_cobit_linksgrid.lists.subcat_id = <?= $Grid->subcat_id->toClientList($Grid) ?>;
    fsubcat_cobit_linksgrid.lists.cobitrefs_id = <?= $Grid->cobitrefs_id->toClientList($Grid) ?>;
    loadjs.done("fsubcat_cobit_linksgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> subcat_cobit_links">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fsubcat_cobit_linksgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_subcat_cobit_links" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_subcat_cobit_linksgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_subcat_cobit_links_id" class="subcat_cobit_links_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->subcat_id->Visible) { // subcat_id ?>
        <th data-name="subcat_id" class="<?= $Grid->subcat_id->headerCellClass() ?>"><div id="elh_subcat_cobit_links_subcat_id" class="subcat_cobit_links_subcat_id"><?= $Grid->renderSort($Grid->subcat_id) ?></div></th>
<?php } ?>
<?php if ($Grid->cobitrefs_id->Visible) { // cobitrefs_id ?>
        <th data-name="cobitrefs_id" class="<?= $Grid->cobitrefs_id->headerCellClass() ?>"><div id="elh_subcat_cobit_links_cobitrefs_id" class="subcat_cobit_links_cobitrefs_id"><?= $Grid->renderSort($Grid->cobitrefs_id) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_subcat_cobit_links", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_id" class="form-group">
<input type="<?= $Grid->id->getInputTextType() ?>" data-table="subcat_cobit_links" data-field="x_id" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" size="30" placeholder="<?= HtmlEncode($Grid->id->getPlaceHolder()) ?>" value="<?= $Grid->id->EditValue ?>"<?= $Grid->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->id->getInputTextType() ?>" data-table="subcat_cobit_links" data-field="x_id" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" size="30" placeholder="<?= HtmlEncode($Grid->id->getPlaceHolder()) ?>" value="<?= $Grid->id->EditValue ?>"<?= $Grid->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id->getErrorMessage() ?></div>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue ?? $Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_id" data-hidden="1" name="fsubcat_cobit_linksgrid$x<?= $Grid->RowIndex ?>_id" id="fsubcat_cobit_linksgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="subcat_cobit_links" data-field="x_id" data-hidden="1" name="fsubcat_cobit_linksgrid$o<?= $Grid->RowIndex ?>_id" id="fsubcat_cobit_linksgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="subcat_cobit_links" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->subcat_id->Visible) { // subcat_id ?>
        <td data-name="subcat_id" <?= $Grid->subcat_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->subcat_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_subcat_id" class="form-group">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_subcat_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_subcat_id"
        name="x<?= $Grid->RowIndex ?>_subcat_id"
        class="form-control ew-select<?= $Grid->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id"
        data-table="subcat_cobit_links"
        data-field="x_subcat_id"
        data-value-separator="<?= $Grid->subcat_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->subcat_id->getPlaceHolder()) ?>"
        <?= $Grid->subcat_id->editAttributes() ?>>
        <?= $Grid->subcat_id->selectOptionListHtml("x{$Grid->RowIndex}_subcat_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->subcat_id->getErrorMessage() ?></div>
<?= $Grid->subcat_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subcat_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_subcat_id", selectId: "subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_subcat_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subcat_id" id="o<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->subcat_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_subcat_id" class="form-group">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_subcat_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_subcat_id"
        name="x<?= $Grid->RowIndex ?>_subcat_id"
        class="form-control ew-select<?= $Grid->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id"
        data-table="subcat_cobit_links"
        data-field="x_subcat_id"
        data-value-separator="<?= $Grid->subcat_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->subcat_id->getPlaceHolder()) ?>"
        <?= $Grid->subcat_id->editAttributes() ?>>
        <?= $Grid->subcat_id->selectOptionListHtml("x{$Grid->RowIndex}_subcat_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->subcat_id->getErrorMessage() ?></div>
<?= $Grid->subcat_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subcat_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_subcat_id", selectId: "subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_subcat_id">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<?= $Grid->subcat_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_subcat_id" data-hidden="1" name="fsubcat_cobit_linksgrid$x<?= $Grid->RowIndex ?>_subcat_id" id="fsubcat_cobit_linksgrid$x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->FormValue) ?>">
<input type="hidden" data-table="subcat_cobit_links" data-field="x_subcat_id" data-hidden="1" name="fsubcat_cobit_linksgrid$o<?= $Grid->RowIndex ?>_subcat_id" id="fsubcat_cobit_linksgrid$o<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cobitrefs_id->Visible) { // cobitrefs_id ?>
        <td data-name="cobitrefs_id" <?= $Grid->cobitrefs_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->cobitrefs_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_cobitrefs_id" class="form-group">
<span<?= $Grid->cobitrefs_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cobitrefs_id->getDisplayValue($Grid->cobitrefs_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_cobitrefs_id" name="x<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_cobitrefs_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_cobitrefs_id"
        name="x<?= $Grid->RowIndex ?>_cobitrefs_id"
        class="form-control ew-select<?= $Grid->cobitrefs_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id"
        data-table="subcat_cobit_links"
        data-field="x_cobitrefs_id"
        data-value-separator="<?= $Grid->cobitrefs_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cobitrefs_id->getPlaceHolder()) ?>"
        <?= $Grid->cobitrefs_id->editAttributes() ?>>
        <?= $Grid->cobitrefs_id->selectOptionListHtml("x{$Grid->RowIndex}_cobitrefs_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cobitrefs_id->getErrorMessage() ?></div>
<?= $Grid->cobitrefs_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cobitrefs_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_cobitrefs_id", selectId: "subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.cobitrefs_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_cobitrefs_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cobitrefs_id" id="o<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->cobitrefs_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_cobitrefs_id" class="form-group">
<span<?= $Grid->cobitrefs_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cobitrefs_id->getDisplayValue($Grid->cobitrefs_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_cobitrefs_id" name="x<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_cobitrefs_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_cobitrefs_id"
        name="x<?= $Grid->RowIndex ?>_cobitrefs_id"
        class="form-control ew-select<?= $Grid->cobitrefs_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id"
        data-table="subcat_cobit_links"
        data-field="x_cobitrefs_id"
        data-value-separator="<?= $Grid->cobitrefs_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cobitrefs_id->getPlaceHolder()) ?>"
        <?= $Grid->cobitrefs_id->editAttributes() ?>>
        <?= $Grid->cobitrefs_id->selectOptionListHtml("x{$Grid->RowIndex}_cobitrefs_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cobitrefs_id->getErrorMessage() ?></div>
<?= $Grid->cobitrefs_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cobitrefs_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_cobitrefs_id", selectId: "subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.cobitrefs_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subcat_cobit_links_cobitrefs_id">
<span<?= $Grid->cobitrefs_id->viewAttributes() ?>>
<?= $Grid->cobitrefs_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_cobitrefs_id" data-hidden="1" name="fsubcat_cobit_linksgrid$x<?= $Grid->RowIndex ?>_cobitrefs_id" id="fsubcat_cobit_linksgrid$x<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->FormValue) ?>">
<input type="hidden" data-table="subcat_cobit_links" data-field="x_cobitrefs_id" data-hidden="1" name="fsubcat_cobit_linksgrid$o<?= $Grid->RowIndex ?>_cobitrefs_id" id="fsubcat_cobit_linksgrid$o<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->OldValue) ?>">
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
loadjs.ready(["fsubcat_cobit_linksgrid","load"], function () {
    fsubcat_cobit_linksgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_subcat_cobit_links", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_subcat_cobit_links_id" class="form-group subcat_cobit_links_id">
<input type="<?= $Grid->id->getInputTextType() ?>" data-table="subcat_cobit_links" data-field="x_id" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" size="30" placeholder="<?= HtmlEncode($Grid->id->getPlaceHolder()) ?>" value="<?= $Grid->id->EditValue ?>"<?= $Grid->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_subcat_cobit_links_id" class="form-group subcat_cobit_links_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subcat_id->Visible) { // subcat_id ?>
        <td data-name="subcat_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->subcat_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_subcat_cobit_links_subcat_id" class="form-group subcat_cobit_links_subcat_id">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subcat_id" name="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_subcat_cobit_links_subcat_id" class="form-group subcat_cobit_links_subcat_id">
    <select
        id="x<?= $Grid->RowIndex ?>_subcat_id"
        name="x<?= $Grid->RowIndex ?>_subcat_id"
        class="form-control ew-select<?= $Grid->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id"
        data-table="subcat_cobit_links"
        data-field="x_subcat_id"
        data-value-separator="<?= $Grid->subcat_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->subcat_id->getPlaceHolder()) ?>"
        <?= $Grid->subcat_id->editAttributes() ?>>
        <?= $Grid->subcat_id->selectOptionListHtml("x{$Grid->RowIndex}_subcat_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->subcat_id->getErrorMessage() ?></div>
<?= $Grid->subcat_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subcat_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_subcat_id", selectId: "subcat_cobit_links_x<?= $Grid->RowIndex ?>_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_subcat_cobit_links_subcat_id" class="form-group subcat_cobit_links_subcat_id">
<span<?= $Grid->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subcat_id->getDisplayValue($Grid->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_subcat_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subcat_id" id="x<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_subcat_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subcat_id" id="o<?= $Grid->RowIndex ?>_subcat_id" value="<?= HtmlEncode($Grid->subcat_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cobitrefs_id->Visible) { // cobitrefs_id ?>
        <td data-name="cobitrefs_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->cobitrefs_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_subcat_cobit_links_cobitrefs_id" class="form-group subcat_cobit_links_cobitrefs_id">
<span<?= $Grid->cobitrefs_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cobitrefs_id->getDisplayValue($Grid->cobitrefs_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_cobitrefs_id" name="x<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_subcat_cobit_links_cobitrefs_id" class="form-group subcat_cobit_links_cobitrefs_id">
    <select
        id="x<?= $Grid->RowIndex ?>_cobitrefs_id"
        name="x<?= $Grid->RowIndex ?>_cobitrefs_id"
        class="form-control ew-select<?= $Grid->cobitrefs_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id"
        data-table="subcat_cobit_links"
        data-field="x_cobitrefs_id"
        data-value-separator="<?= $Grid->cobitrefs_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cobitrefs_id->getPlaceHolder()) ?>"
        <?= $Grid->cobitrefs_id->editAttributes() ?>>
        <?= $Grid->cobitrefs_id->selectOptionListHtml("x{$Grid->RowIndex}_cobitrefs_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cobitrefs_id->getErrorMessage() ?></div>
<?= $Grid->cobitrefs_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cobitrefs_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_cobitrefs_id", selectId: "subcat_cobit_links_x<?= $Grid->RowIndex ?>_cobitrefs_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.cobitrefs_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_subcat_cobit_links_cobitrefs_id" class="form-group subcat_cobit_links_cobitrefs_id">
<span<?= $Grid->cobitrefs_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cobitrefs_id->getDisplayValue($Grid->cobitrefs_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_cobitrefs_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cobitrefs_id" id="x<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcat_cobit_links" data-field="x_cobitrefs_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cobitrefs_id" id="o<?= $Grid->RowIndex ?>_cobitrefs_id" value="<?= HtmlEncode($Grid->cobitrefs_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsubcat_cobit_linksgrid","load"], function() {
    fsubcat_cobit_linksgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fsubcat_cobit_linksgrid">
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
    ew.addEventHandlers("subcat_cobit_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
