<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("RiskLibrairiesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var frisk_librairiesgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    frisk_librairiesgrid = new ew.Form("frisk_librairiesgrid", "grid");
    frisk_librairiesgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "risk_librairies")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.risk_librairies)
        ew.vars.tables.risk_librairies = currentTable;
    frisk_librairiesgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["layer", [fields.layer.visible && fields.layer.required ? ew.Validators.required(fields.layer.caption) : null], fields.layer.isInvalid],
        ["function_csf", [fields.function_csf.visible && fields.function_csf.required ? ew.Validators.required(fields.function_csf.caption) : null], fields.function_csf.isInvalid],
        ["tag", [fields.tag.visible && fields.tag.required ? ew.Validators.required(fields.tag.caption) : null], fields.tag.isInvalid],
        ["Confidentiality", [fields.Confidentiality.visible && fields.Confidentiality.required ? ew.Validators.required(fields.Confidentiality.caption) : null], fields.Confidentiality.isInvalid],
        ["Integrity", [fields.Integrity.visible && fields.Integrity.required ? ew.Validators.required(fields.Integrity.caption) : null], fields.Integrity.isInvalid],
        ["Availability", [fields.Availability.visible && fields.Availability.required ? ew.Validators.required(fields.Availability.caption) : null], fields.Availability.isInvalid],
        ["Efficiency", [fields.Efficiency.visible && fields.Efficiency.required ? ew.Validators.required(fields.Efficiency.caption) : null], fields.Efficiency.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = frisk_librairiesgrid,
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
    frisk_librairiesgrid.validate = function () {
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
    frisk_librairiesgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "title", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "layer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "function_csf", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tag", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Confidentiality", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Integrity", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Availability", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Efficiency", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    frisk_librairiesgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    frisk_librairiesgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    frisk_librairiesgrid.lists.layer = <?= $Grid->layer->toClientList($Grid) ?>;
    frisk_librairiesgrid.lists.function_csf = <?= $Grid->function_csf->toClientList($Grid) ?>;
    frisk_librairiesgrid.lists.Confidentiality = <?= $Grid->Confidentiality->toClientList($Grid) ?>;
    frisk_librairiesgrid.lists.Integrity = <?= $Grid->Integrity->toClientList($Grid) ?>;
    frisk_librairiesgrid.lists.Availability = <?= $Grid->Availability->toClientList($Grid) ?>;
    frisk_librairiesgrid.lists.Efficiency = <?= $Grid->Efficiency->toClientList($Grid) ?>;
    loadjs.done("frisk_librairiesgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> risk_librairies">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="frisk_librairiesgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_risk_librairies" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_risk_librairiesgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_risk_librairies_id" class="risk_librairies_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->title->Visible) { // title ?>
        <th data-name="title" class="<?= $Grid->title->headerCellClass() ?>"><div id="elh_risk_librairies_title" class="risk_librairies_title"><?= $Grid->renderSort($Grid->title) ?></div></th>
<?php } ?>
<?php if ($Grid->layer->Visible) { // layer ?>
        <th data-name="layer" class="<?= $Grid->layer->headerCellClass() ?>"><div id="elh_risk_librairies_layer" class="risk_librairies_layer"><?= $Grid->renderSort($Grid->layer) ?></div></th>
<?php } ?>
<?php if ($Grid->function_csf->Visible) { // function_csf ?>
        <th data-name="function_csf" class="<?= $Grid->function_csf->headerCellClass() ?>"><div id="elh_risk_librairies_function_csf" class="risk_librairies_function_csf"><?= $Grid->renderSort($Grid->function_csf) ?></div></th>
<?php } ?>
<?php if ($Grid->tag->Visible) { // tag ?>
        <th data-name="tag" class="<?= $Grid->tag->headerCellClass() ?>"><div id="elh_risk_librairies_tag" class="risk_librairies_tag"><?= $Grid->renderSort($Grid->tag) ?></div></th>
<?php } ?>
<?php if ($Grid->Confidentiality->Visible) { // Confidentiality ?>
        <th data-name="Confidentiality" class="<?= $Grid->Confidentiality->headerCellClass() ?>"><div id="elh_risk_librairies_Confidentiality" class="risk_librairies_Confidentiality"><?= $Grid->renderSort($Grid->Confidentiality) ?></div></th>
<?php } ?>
<?php if ($Grid->Integrity->Visible) { // Integrity ?>
        <th data-name="Integrity" class="<?= $Grid->Integrity->headerCellClass() ?>"><div id="elh_risk_librairies_Integrity" class="risk_librairies_Integrity"><?= $Grid->renderSort($Grid->Integrity) ?></div></th>
<?php } ?>
<?php if ($Grid->Availability->Visible) { // Availability ?>
        <th data-name="Availability" class="<?= $Grid->Availability->headerCellClass() ?>"><div id="elh_risk_librairies_Availability" class="risk_librairies_Availability"><?= $Grid->renderSort($Grid->Availability) ?></div></th>
<?php } ?>
<?php if ($Grid->Efficiency->Visible) { // Efficiency ?>
        <th data-name="Efficiency" class="<?= $Grid->Efficiency->headerCellClass() ?>"><div id="elh_risk_librairies_Efficiency" class="risk_librairies_Efficiency"><?= $Grid->renderSort($Grid->Efficiency) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_risk_librairies", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_risk_librairies_id" class="form-group"></span>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_id" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_id" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->title->Visible) { // title ?>
        <td data-name="title" <?= $Grid->title->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_title" class="form-group">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="risk_librairies" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_title" id="o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_title" class="form-group">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="risk_librairies" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_title">
<span<?= $Grid->title->viewAttributes() ?>>
<?= $Grid->title->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_title" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_title" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->layer->Visible) { // layer ?>
        <td data-name="layer" <?= $Grid->layer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->layer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_layer" class="form-group">
<span<?= $Grid->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer->getDisplayValue($Grid->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_layer" name="x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_layer" class="form-group">
<?php
$onchange = $Grid->layer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->layer->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_layer" class="ew-auto-suggest">
    <input type="<?= $Grid->layer->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_layer" id="sv_x<?= $Grid->RowIndex ?>_layer" value="<?= RemoveHtml($Grid->layer->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->layer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->layer->getPlaceHolder()) ?>"<?= $Grid->layer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_layer" data-input="sv_x<?= $Grid->RowIndex ?>_layer" data-value-separator="<?= $Grid->layer->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_layer" id="x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->layer->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesgrid"], function() {
    frisk_librairiesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_layer","forceSelect":false}, ew.vars.tables.risk_librairies.fields.layer.autoSuggestOptions));
});
</script>
<?= $Grid->layer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_layer") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_layer" id="o<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->layer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_layer" class="form-group">
<span<?= $Grid->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer->getDisplayValue($Grid->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_layer" name="x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_layer" class="form-group">
<?php
$onchange = $Grid->layer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->layer->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_layer" class="ew-auto-suggest">
    <input type="<?= $Grid->layer->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_layer" id="sv_x<?= $Grid->RowIndex ?>_layer" value="<?= RemoveHtml($Grid->layer->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->layer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->layer->getPlaceHolder()) ?>"<?= $Grid->layer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_layer" data-input="sv_x<?= $Grid->RowIndex ?>_layer" data-value-separator="<?= $Grid->layer->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_layer" id="x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->layer->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesgrid"], function() {
    frisk_librairiesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_layer","forceSelect":false}, ew.vars.tables.risk_librairies.fields.layer.autoSuggestOptions));
});
</script>
<?= $Grid->layer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_layer") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_layer">
<span<?= $Grid->layer->viewAttributes() ?>>
<?= $Grid->layer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_layer" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_layer" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf" <?= $Grid->function_csf->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->function_csf->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_function_csf" class="form-group">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_function_csf" name="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_function_csf" class="form-group">
<?php
$onchange = $Grid->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Grid->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_function_csf" id="sv_x<?= $Grid->RowIndex ?>_function_csf" value="<?= RemoveHtml($Grid->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>"<?= $Grid->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_function_csf" data-input="sv_x<?= $Grid->RowIndex ?>_function_csf" data-value-separator="<?= $Grid->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesgrid"], function() {
    frisk_librairiesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.risk_librairies.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Grid->function_csf->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="o<?= $Grid->RowIndex ?>_function_csf" id="o<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->function_csf->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_function_csf" class="form-group">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_function_csf" name="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_function_csf" class="form-group">
<?php
$onchange = $Grid->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Grid->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_function_csf" id="sv_x<?= $Grid->RowIndex ?>_function_csf" value="<?= RemoveHtml($Grid->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>"<?= $Grid->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_function_csf" data-input="sv_x<?= $Grid->RowIndex ?>_function_csf" data-value-separator="<?= $Grid->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesgrid"], function() {
    frisk_librairiesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.risk_librairies.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Grid->function_csf->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_function_csf">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<?= $Grid->function_csf->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_function_csf" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_function_csf" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tag->Visible) { // tag ?>
        <td data-name="tag" <?= $Grid->tag->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_tag" class="form-group">
<input type="<?= $Grid->tag->getInputTextType() ?>" data-table="risk_librairies" data-field="x_tag" name="x<?= $Grid->RowIndex ?>_tag" id="x<?= $Grid->RowIndex ?>_tag" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->tag->getPlaceHolder()) ?>" value="<?= $Grid->tag->EditValue ?>"<?= $Grid->tag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tag->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tag" id="o<?= $Grid->RowIndex ?>_tag" value="<?= HtmlEncode($Grid->tag->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_tag" class="form-group">
<input type="<?= $Grid->tag->getInputTextType() ?>" data-table="risk_librairies" data-field="x_tag" name="x<?= $Grid->RowIndex ?>_tag" id="x<?= $Grid->RowIndex ?>_tag" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->tag->getPlaceHolder()) ?>" value="<?= $Grid->tag->EditValue ?>"<?= $Grid->tag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tag->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_tag">
<span<?= $Grid->tag->viewAttributes() ?>>
<?= $Grid->tag->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_tag" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_tag" value="<?= HtmlEncode($Grid->tag->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_tag" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_tag" value="<?= HtmlEncode($Grid->tag->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Confidentiality->Visible) { // Confidentiality ?>
        <td data-name="Confidentiality" <?= $Grid->Confidentiality->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Confidentiality" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Confidentiality"
        name="x<?= $Grid->RowIndex ?>_Confidentiality"
        class="form-control ew-select<?= $Grid->Confidentiality->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality"
        data-table="risk_librairies"
        data-field="x_Confidentiality"
        data-value-separator="<?= $Grid->Confidentiality->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Confidentiality->getPlaceHolder()) ?>"
        <?= $Grid->Confidentiality->editAttributes() ?>>
        <?= $Grid->Confidentiality->selectOptionListHtml("x{$Grid->RowIndex}_Confidentiality") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Confidentiality->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Confidentiality", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Confidentiality" id="o<?= $Grid->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Grid->Confidentiality->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Confidentiality" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Confidentiality"
        name="x<?= $Grid->RowIndex ?>_Confidentiality"
        class="form-control ew-select<?= $Grid->Confidentiality->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality"
        data-table="risk_librairies"
        data-field="x_Confidentiality"
        data-value-separator="<?= $Grid->Confidentiality->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Confidentiality->getPlaceHolder()) ?>"
        <?= $Grid->Confidentiality->editAttributes() ?>>
        <?= $Grid->Confidentiality->selectOptionListHtml("x{$Grid->RowIndex}_Confidentiality") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Confidentiality->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Confidentiality", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Confidentiality">
<span<?= $Grid->Confidentiality->viewAttributes() ?>>
<?= $Grid->Confidentiality->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Confidentiality" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Grid->Confidentiality->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Confidentiality" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Grid->Confidentiality->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Integrity->Visible) { // Integrity ?>
        <td data-name="Integrity" <?= $Grid->Integrity->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Integrity" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Integrity"
        name="x<?= $Grid->RowIndex ?>_Integrity"
        class="form-control ew-select<?= $Grid->Integrity->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Integrity"
        data-table="risk_librairies"
        data-field="x_Integrity"
        data-value-separator="<?= $Grid->Integrity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Integrity->getPlaceHolder()) ?>"
        <?= $Grid->Integrity->editAttributes() ?>>
        <?= $Grid->Integrity->selectOptionListHtml("x{$Grid->RowIndex}_Integrity") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Integrity->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Integrity']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Integrity", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Integrity" id="o<?= $Grid->RowIndex ?>_Integrity" value="<?= HtmlEncode($Grid->Integrity->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Integrity" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Integrity"
        name="x<?= $Grid->RowIndex ?>_Integrity"
        class="form-control ew-select<?= $Grid->Integrity->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Integrity"
        data-table="risk_librairies"
        data-field="x_Integrity"
        data-value-separator="<?= $Grid->Integrity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Integrity->getPlaceHolder()) ?>"
        <?= $Grid->Integrity->editAttributes() ?>>
        <?= $Grid->Integrity->selectOptionListHtml("x{$Grid->RowIndex}_Integrity") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Integrity->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Integrity']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Integrity", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Integrity">
<span<?= $Grid->Integrity->viewAttributes() ?>>
<?= $Grid->Integrity->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Integrity" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Integrity" value="<?= HtmlEncode($Grid->Integrity->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Integrity" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Integrity" value="<?= HtmlEncode($Grid->Integrity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Availability->Visible) { // Availability ?>
        <td data-name="Availability" <?= $Grid->Availability->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Availability" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Availability"
        name="x<?= $Grid->RowIndex ?>_Availability"
        class="form-control ew-select<?= $Grid->Availability->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Availability"
        data-table="risk_librairies"
        data-field="x_Availability"
        data-value-separator="<?= $Grid->Availability->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Availability->getPlaceHolder()) ?>"
        <?= $Grid->Availability->editAttributes() ?>>
        <?= $Grid->Availability->selectOptionListHtml("x{$Grid->RowIndex}_Availability") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Availability->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Availability']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Availability", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Availability" id="o<?= $Grid->RowIndex ?>_Availability" value="<?= HtmlEncode($Grid->Availability->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Availability" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Availability"
        name="x<?= $Grid->RowIndex ?>_Availability"
        class="form-control ew-select<?= $Grid->Availability->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Availability"
        data-table="risk_librairies"
        data-field="x_Availability"
        data-value-separator="<?= $Grid->Availability->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Availability->getPlaceHolder()) ?>"
        <?= $Grid->Availability->editAttributes() ?>>
        <?= $Grid->Availability->selectOptionListHtml("x{$Grid->RowIndex}_Availability") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Availability->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Availability']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Availability", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Availability">
<span<?= $Grid->Availability->viewAttributes() ?>>
<?= $Grid->Availability->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Availability" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Availability" value="<?= HtmlEncode($Grid->Availability->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Availability" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Availability" value="<?= HtmlEncode($Grid->Availability->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Efficiency->Visible) { // Efficiency ?>
        <td data-name="Efficiency" <?= $Grid->Efficiency->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Efficiency" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Efficiency"
        name="x<?= $Grid->RowIndex ?>_Efficiency"
        class="form-control ew-select<?= $Grid->Efficiency->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency"
        data-table="risk_librairies"
        data-field="x_Efficiency"
        data-value-separator="<?= $Grid->Efficiency->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Efficiency->getPlaceHolder()) ?>"
        <?= $Grid->Efficiency->editAttributes() ?>>
        <?= $Grid->Efficiency->selectOptionListHtml("x{$Grid->RowIndex}_Efficiency") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Efficiency->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Efficiency", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Efficiency" id="o<?= $Grid->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Grid->Efficiency->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Efficiency" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_Efficiency"
        name="x<?= $Grid->RowIndex ?>_Efficiency"
        class="form-control ew-select<?= $Grid->Efficiency->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency"
        data-table="risk_librairies"
        data-field="x_Efficiency"
        data-value-separator="<?= $Grid->Efficiency->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Efficiency->getPlaceHolder()) ?>"
        <?= $Grid->Efficiency->editAttributes() ?>>
        <?= $Grid->Efficiency->selectOptionListHtml("x{$Grid->RowIndex}_Efficiency") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Efficiency->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Efficiency", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_risk_librairies_Efficiency">
<span<?= $Grid->Efficiency->viewAttributes() ?>>
<?= $Grid->Efficiency->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Efficiency" id="frisk_librairiesgrid$x<?= $Grid->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Grid->Efficiency->FormValue) ?>">
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Efficiency" id="frisk_librairiesgrid$o<?= $Grid->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Grid->Efficiency->OldValue) ?>">
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
loadjs.ready(["frisk_librairiesgrid","load"], function () {
    frisk_librairiesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_risk_librairies", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_risk_librairies_id" class="form-group risk_librairies_id"></span>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_id" class="form-group risk_librairies_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->title->Visible) { // title ?>
        <td data-name="title">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_risk_librairies_title" class="form-group risk_librairies_title">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="risk_librairies" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_title" class="form-group risk_librairies_title">
<span<?= $Grid->title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->title->getDisplayValue($Grid->title->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_title" id="o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->layer->Visible) { // layer ?>
        <td data-name="layer">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->layer->getSessionValue() != "") { ?>
<span id="el$rowindex$_risk_librairies_layer" class="form-group risk_librairies_layer">
<span<?= $Grid->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer->getDisplayValue($Grid->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_layer" name="x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_layer" class="form-group risk_librairies_layer">
<?php
$onchange = $Grid->layer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->layer->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_layer" class="ew-auto-suggest">
    <input type="<?= $Grid->layer->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_layer" id="sv_x<?= $Grid->RowIndex ?>_layer" value="<?= RemoveHtml($Grid->layer->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->layer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->layer->getPlaceHolder()) ?>"<?= $Grid->layer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_layer" data-input="sv_x<?= $Grid->RowIndex ?>_layer" data-value-separator="<?= $Grid->layer->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_layer" id="x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->layer->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesgrid"], function() {
    frisk_librairiesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_layer","forceSelect":false}, ew.vars.tables.risk_librairies.fields.layer.autoSuggestOptions));
});
</script>
<?= $Grid->layer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_layer") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_layer" class="form-group risk_librairies_layer">
<span<?= $Grid->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->layer->getDisplayValue($Grid->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_layer" id="x<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_layer" id="o<?= $Grid->RowIndex ?>_layer" value="<?= HtmlEncode($Grid->layer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->function_csf->getSessionValue() != "") { ?>
<span id="el$rowindex$_risk_librairies_function_csf" class="form-group risk_librairies_function_csf">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_function_csf" name="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_function_csf" class="form-group risk_librairies_function_csf">
<?php
$onchange = $Grid->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Grid->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_function_csf" id="sv_x<?= $Grid->RowIndex ?>_function_csf" value="<?= RemoveHtml($Grid->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->function_csf->getPlaceHolder()) ?>"<?= $Grid->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_function_csf" data-input="sv_x<?= $Grid->RowIndex ?>_function_csf" data-value-separator="<?= $Grid->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesgrid"], function() {
    frisk_librairiesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.risk_librairies.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Grid->function_csf->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_function_csf" class="form-group risk_librairies_function_csf">
<span<?= $Grid->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->function_csf->getDisplayValue($Grid->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="x<?= $Grid->RowIndex ?>_function_csf" id="x<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="o<?= $Grid->RowIndex ?>_function_csf" id="o<?= $Grid->RowIndex ?>_function_csf" value="<?= HtmlEncode($Grid->function_csf->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tag->Visible) { // tag ?>
        <td data-name="tag">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_risk_librairies_tag" class="form-group risk_librairies_tag">
<input type="<?= $Grid->tag->getInputTextType() ?>" data-table="risk_librairies" data-field="x_tag" name="x<?= $Grid->RowIndex ?>_tag" id="x<?= $Grid->RowIndex ?>_tag" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->tag->getPlaceHolder()) ?>" value="<?= $Grid->tag->EditValue ?>"<?= $Grid->tag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tag->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_tag" class="form-group risk_librairies_tag">
<span<?= $Grid->tag->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tag->getDisplayValue($Grid->tag->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tag" id="x<?= $Grid->RowIndex ?>_tag" value="<?= HtmlEncode($Grid->tag->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tag" id="o<?= $Grid->RowIndex ?>_tag" value="<?= HtmlEncode($Grid->tag->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Confidentiality->Visible) { // Confidentiality ?>
        <td data-name="Confidentiality">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_risk_librairies_Confidentiality" class="form-group risk_librairies_Confidentiality">
    <select
        id="x<?= $Grid->RowIndex ?>_Confidentiality"
        name="x<?= $Grid->RowIndex ?>_Confidentiality"
        class="form-control ew-select<?= $Grid->Confidentiality->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality"
        data-table="risk_librairies"
        data-field="x_Confidentiality"
        data-value-separator="<?= $Grid->Confidentiality->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Confidentiality->getPlaceHolder()) ?>"
        <?= $Grid->Confidentiality->editAttributes() ?>>
        <?= $Grid->Confidentiality->selectOptionListHtml("x{$Grid->RowIndex}_Confidentiality") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Confidentiality->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Confidentiality", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_Confidentiality" class="form-group risk_librairies_Confidentiality">
<span<?= $Grid->Confidentiality->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Confidentiality->getDisplayValue($Grid->Confidentiality->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Confidentiality" id="x<?= $Grid->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Grid->Confidentiality->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Confidentiality" id="o<?= $Grid->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Grid->Confidentiality->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Integrity->Visible) { // Integrity ?>
        <td data-name="Integrity">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_risk_librairies_Integrity" class="form-group risk_librairies_Integrity">
    <select
        id="x<?= $Grid->RowIndex ?>_Integrity"
        name="x<?= $Grid->RowIndex ?>_Integrity"
        class="form-control ew-select<?= $Grid->Integrity->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Integrity"
        data-table="risk_librairies"
        data-field="x_Integrity"
        data-value-separator="<?= $Grid->Integrity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Integrity->getPlaceHolder()) ?>"
        <?= $Grid->Integrity->editAttributes() ?>>
        <?= $Grid->Integrity->selectOptionListHtml("x{$Grid->RowIndex}_Integrity") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Integrity->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Integrity']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Integrity", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_Integrity" class="form-group risk_librairies_Integrity">
<span<?= $Grid->Integrity->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Integrity->getDisplayValue($Grid->Integrity->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Integrity" id="x<?= $Grid->RowIndex ?>_Integrity" value="<?= HtmlEncode($Grid->Integrity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Integrity" id="o<?= $Grid->RowIndex ?>_Integrity" value="<?= HtmlEncode($Grid->Integrity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Availability->Visible) { // Availability ?>
        <td data-name="Availability">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_risk_librairies_Availability" class="form-group risk_librairies_Availability">
    <select
        id="x<?= $Grid->RowIndex ?>_Availability"
        name="x<?= $Grid->RowIndex ?>_Availability"
        class="form-control ew-select<?= $Grid->Availability->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Availability"
        data-table="risk_librairies"
        data-field="x_Availability"
        data-value-separator="<?= $Grid->Availability->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Availability->getPlaceHolder()) ?>"
        <?= $Grid->Availability->editAttributes() ?>>
        <?= $Grid->Availability->selectOptionListHtml("x{$Grid->RowIndex}_Availability") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Availability->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Availability']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Availability", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_Availability" class="form-group risk_librairies_Availability">
<span<?= $Grid->Availability->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Availability->getDisplayValue($Grid->Availability->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Availability" id="x<?= $Grid->RowIndex ?>_Availability" value="<?= HtmlEncode($Grid->Availability->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Availability" id="o<?= $Grid->RowIndex ?>_Availability" value="<?= HtmlEncode($Grid->Availability->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Efficiency->Visible) { // Efficiency ?>
        <td data-name="Efficiency">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_risk_librairies_Efficiency" class="form-group risk_librairies_Efficiency">
    <select
        id="x<?= $Grid->RowIndex ?>_Efficiency"
        name="x<?= $Grid->RowIndex ?>_Efficiency"
        class="form-control ew-select<?= $Grid->Efficiency->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency"
        data-table="risk_librairies"
        data-field="x_Efficiency"
        data-value-separator="<?= $Grid->Efficiency->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Efficiency->getPlaceHolder()) ?>"
        <?= $Grid->Efficiency->editAttributes() ?>>
        <?= $Grid->Efficiency->selectOptionListHtml("x{$Grid->RowIndex}_Efficiency") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Efficiency->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency']"),
        options = { name: "x<?= $Grid->RowIndex ?>_Efficiency", selectId: "risk_librairies_x<?= $Grid->RowIndex ?>_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_Efficiency" class="form-group risk_librairies_Efficiency">
<span<?= $Grid->Efficiency->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Efficiency->getDisplayValue($Grid->Efficiency->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Efficiency" id="x<?= $Grid->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Grid->Efficiency->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Efficiency" id="o<?= $Grid->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Grid->Efficiency->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["frisk_librairiesgrid","load"], function() {
    frisk_librairiesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="frisk_librairiesgrid">
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
    ew.addEventHandlers("risk_librairies");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
