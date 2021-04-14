<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Set up and run Grid object
$Grid = Container("QuestionDomainsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fquestion_domainsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fquestion_domainsgrid = new ew.Form("fquestion_domainsgrid", "grid");
    fquestion_domainsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "question_domains")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.question_domains)
        ew.vars.tables.question_domains = currentTable;
    fquestion_domainsgrid.addFields([
        ["domain_name", [fields.domain_name.visible && fields.domain_name.required ? ew.Validators.required(fields.domain_name.caption) : null], fields.domain_name.isInvalid],
        ["question_area_id", [fields.question_area_id.visible && fields.question_area_id.required ? ew.Validators.required(fields.question_area_id.caption) : null], fields.question_area_id.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestion_domainsgrid,
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
    fquestion_domainsgrid.validate = function () {
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
    fquestion_domainsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "domain_name", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "question_area_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_at", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "updated_at", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fquestion_domainsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestion_domainsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fquestion_domainsgrid.lists.question_area_id = <?= $Grid->question_area_id->toClientList($Grid) ?>;
    loadjs.done("fquestion_domainsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> question_domains">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fquestion_domainsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_question_domains" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_question_domainsgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->domain_name->Visible) { // domain_name ?>
        <th data-name="domain_name" class="<?= $Grid->domain_name->headerCellClass() ?>"><div id="elh_question_domains_domain_name" class="question_domains_domain_name"><?= $Grid->renderSort($Grid->domain_name) ?></div></th>
<?php } ?>
<?php if ($Grid->question_area_id->Visible) { // question_area_id ?>
        <th data-name="question_area_id" class="<?= $Grid->question_area_id->headerCellClass() ?>"><div id="elh_question_domains_question_area_id" class="question_domains_question_area_id"><?= $Grid->renderSort($Grid->question_area_id) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_question_domains_created_at" class="question_domains_created_at"><?= $Grid->renderSort($Grid->created_at) ?></div></th>
<?php } ?>
<?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Grid->updated_at->headerCellClass() ?>"><div id="elh_question_domains_updated_at" class="question_domains_updated_at"><?= $Grid->renderSort($Grid->updated_at) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_question_domains", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->domain_name->Visible) { // domain_name ?>
        <td data-name="domain_name" <?= $Grid->domain_name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_domain_name" class="form-group">
<input type="<?= $Grid->domain_name->getInputTextType() ?>" data-table="question_domains" data-field="x_domain_name" name="x<?= $Grid->RowIndex ?>_domain_name" id="x<?= $Grid->RowIndex ?>_domain_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->domain_name->getPlaceHolder()) ?>" value="<?= $Grid->domain_name->EditValue ?>"<?= $Grid->domain_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->domain_name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_domain_name" id="o<?= $Grid->RowIndex ?>_domain_name" value="<?= HtmlEncode($Grid->domain_name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->domain_name->getInputTextType() ?>" data-table="question_domains" data-field="x_domain_name" name="x<?= $Grid->RowIndex ?>_domain_name" id="x<?= $Grid->RowIndex ?>_domain_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->domain_name->getPlaceHolder()) ?>" value="<?= $Grid->domain_name->EditValue ?>"<?= $Grid->domain_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->domain_name->getErrorMessage() ?></div>
<input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_domain_name" id="o<?= $Grid->RowIndex ?>_domain_name" value="<?= HtmlEncode($Grid->domain_name->OldValue ?? $Grid->domain_name->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_domain_name">
<span<?= $Grid->domain_name->viewAttributes() ?>>
<?= $Grid->domain_name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_domain_name" id="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_domain_name" value="<?= HtmlEncode($Grid->domain_name->FormValue) ?>">
<input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_domain_name" id="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_domain_name" value="<?= HtmlEncode($Grid->domain_name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_domain_name" id="x<?= $Grid->RowIndex ?>_domain_name" value="<?= HtmlEncode($Grid->domain_name->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->question_area_id->Visible) { // question_area_id ?>
        <td data-name="question_area_id" <?= $Grid->question_area_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->question_area_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_question_area_id" class="form-group">
<span<?= $Grid->question_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_area_id->getDisplayValue($Grid->question_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_question_area_id" name="x<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_question_area_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_question_area_id"
        name="x<?= $Grid->RowIndex ?>_question_area_id"
        class="form-control ew-select<?= $Grid->question_area_id->isInvalidClass() ?>"
        data-select2-id="question_domains_x<?= $Grid->RowIndex ?>_question_area_id"
        data-table="question_domains"
        data-field="x_question_area_id"
        data-value-separator="<?= $Grid->question_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->question_area_id->getPlaceHolder()) ?>"
        <?= $Grid->question_area_id->editAttributes() ?>>
        <?= $Grid->question_area_id->selectOptionListHtml("x{$Grid->RowIndex}_question_area_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->question_area_id->getErrorMessage() ?></div>
<?= $Grid->question_area_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_question_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_domains_x<?= $Grid->RowIndex ?>_question_area_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_question_area_id", selectId: "question_domains_x<?= $Grid->RowIndex ?>_question_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_domains.fields.question_area_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="question_domains" data-field="x_question_area_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_question_area_id" id="o<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->question_area_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_question_area_id" class="form-group">
<span<?= $Grid->question_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_area_id->getDisplayValue($Grid->question_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_question_area_id" name="x<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_question_area_id" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_question_area_id"
        name="x<?= $Grid->RowIndex ?>_question_area_id"
        class="form-control ew-select<?= $Grid->question_area_id->isInvalidClass() ?>"
        data-select2-id="question_domains_x<?= $Grid->RowIndex ?>_question_area_id"
        data-table="question_domains"
        data-field="x_question_area_id"
        data-value-separator="<?= $Grid->question_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->question_area_id->getPlaceHolder()) ?>"
        <?= $Grid->question_area_id->editAttributes() ?>>
        <?= $Grid->question_area_id->selectOptionListHtml("x{$Grid->RowIndex}_question_area_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->question_area_id->getErrorMessage() ?></div>
<?= $Grid->question_area_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_question_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_domains_x<?= $Grid->RowIndex ?>_question_area_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_question_area_id", selectId: "question_domains_x<?= $Grid->RowIndex ?>_question_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_domains.fields.question_area_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_question_area_id">
<span<?= $Grid->question_area_id->viewAttributes() ?>>
<?= $Grid->question_area_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_domains" data-field="x_question_area_id" data-hidden="1" name="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_question_area_id" id="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->FormValue) ?>">
<input type="hidden" data-table="question_domains" data-field="x_question_area_id" data-hidden="1" name="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_question_area_id" id="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="question_domains" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="question_domains" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="question_domains" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_domains" data-field="x_created_at" data-hidden="1" name="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_created_at" id="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="question_domains" data-field="x_created_at" data-hidden="1" name="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_created_at" id="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at" <?= $Grid->updated_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_updated_at" class="form-group">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="question_domains" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsgrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="question_domains" data-field="x_updated_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_updated_at" id="o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_updated_at" class="form-group">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="question_domains" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsgrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_question_domains_updated_at">
<span<?= $Grid->updated_at->viewAttributes() ?>>
<?= $Grid->updated_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="question_domains" data-field="x_updated_at" data-hidden="1" name="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_updated_at" id="fquestion_domainsgrid$x<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->FormValue) ?>">
<input type="hidden" data-table="question_domains" data-field="x_updated_at" data-hidden="1" name="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_updated_at" id="fquestion_domainsgrid$o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
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
loadjs.ready(["fquestion_domainsgrid","load"], function () {
    fquestion_domainsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_question_domains", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->domain_name->Visible) { // domain_name ?>
        <td data-name="domain_name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_question_domains_domain_name" class="form-group question_domains_domain_name">
<input type="<?= $Grid->domain_name->getInputTextType() ?>" data-table="question_domains" data-field="x_domain_name" name="x<?= $Grid->RowIndex ?>_domain_name" id="x<?= $Grid->RowIndex ?>_domain_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->domain_name->getPlaceHolder()) ?>" value="<?= $Grid->domain_name->EditValue ?>"<?= $Grid->domain_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->domain_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_question_domains_domain_name" class="form-group question_domains_domain_name">
<span<?= $Grid->domain_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->domain_name->getDisplayValue($Grid->domain_name->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_domain_name" id="x<?= $Grid->RowIndex ?>_domain_name" value="<?= HtmlEncode($Grid->domain_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_domain_name" id="o<?= $Grid->RowIndex ?>_domain_name" value="<?= HtmlEncode($Grid->domain_name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->question_area_id->Visible) { // question_area_id ?>
        <td data-name="question_area_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->question_area_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_question_domains_question_area_id" class="form-group question_domains_question_area_id">
<span<?= $Grid->question_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_area_id->getDisplayValue($Grid->question_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_question_area_id" name="x<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_question_domains_question_area_id" class="form-group question_domains_question_area_id">
    <select
        id="x<?= $Grid->RowIndex ?>_question_area_id"
        name="x<?= $Grid->RowIndex ?>_question_area_id"
        class="form-control ew-select<?= $Grid->question_area_id->isInvalidClass() ?>"
        data-select2-id="question_domains_x<?= $Grid->RowIndex ?>_question_area_id"
        data-table="question_domains"
        data-field="x_question_area_id"
        data-value-separator="<?= $Grid->question_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->question_area_id->getPlaceHolder()) ?>"
        <?= $Grid->question_area_id->editAttributes() ?>>
        <?= $Grid->question_area_id->selectOptionListHtml("x{$Grid->RowIndex}_question_area_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->question_area_id->getErrorMessage() ?></div>
<?= $Grid->question_area_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_question_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_domains_x<?= $Grid->RowIndex ?>_question_area_id']"),
        options = { name: "x<?= $Grid->RowIndex ?>_question_area_id", selectId: "question_domains_x<?= $Grid->RowIndex ?>_question_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_domains.fields.question_area_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_question_domains_question_area_id" class="form-group question_domains_question_area_id">
<span<?= $Grid->question_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->question_area_id->getDisplayValue($Grid->question_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_domains" data-field="x_question_area_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_question_area_id" id="x<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_domains" data-field="x_question_area_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_question_area_id" id="o<?= $Grid->RowIndex ?>_question_area_id" value="<?= HtmlEncode($Grid->question_area_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_question_domains_created_at" class="form-group question_domains_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="question_domains" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_question_domains_created_at" class="form-group question_domains_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_at->getDisplayValue($Grid->created_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_domains" data-field="x_created_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_domains" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_question_domains_updated_at" class="form-group question_domains_updated_at">
<input type="<?= $Grid->updated_at->getInputTextType() ?>" data-table="question_domains" data-field="x_updated_at" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" placeholder="<?= HtmlEncode($Grid->updated_at->getPlaceHolder()) ?>" value="<?= $Grid->updated_at->EditValue ?>"<?= $Grid->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->updated_at->getErrorMessage() ?></div>
<?php if (!$Grid->updated_at->ReadOnly && !$Grid->updated_at->Disabled && !isset($Grid->updated_at->EditAttrs["readonly"]) && !isset($Grid->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsgrid", "x<?= $Grid->RowIndex ?>_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_question_domains_updated_at" class="form-group question_domains_updated_at">
<span<?= $Grid->updated_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->updated_at->getDisplayValue($Grid->updated_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="question_domains" data-field="x_updated_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_updated_at" id="x<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="question_domains" data-field="x_updated_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_updated_at" id="o<?= $Grid->RowIndex ?>_updated_at" value="<?= HtmlEncode($Grid->updated_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fquestion_domainsgrid","load"], function() {
    fquestion_domainsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fquestion_domainsgrid">
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
    ew.addEventHandlers("question_domains");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
