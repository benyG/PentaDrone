<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$RiskControlLinksList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var frisk_control_linkslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    frisk_control_linkslist = currentForm = new ew.Form("frisk_control_linkslist", "list");
    frisk_control_linkslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "risk_control_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.risk_control_links)
        ew.vars.tables.risk_control_links = currentTable;
    frisk_control_linkslist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["control_foreign_id", [fields.control_foreign_id.visible && fields.control_foreign_id.required ? ew.Validators.required(fields.control_foreign_id.caption) : null], fields.control_foreign_id.isInvalid],
        ["risk_foreign_id", [fields.risk_foreign_id.visible && fields.risk_foreign_id.required ? ew.Validators.required(fields.risk_foreign_id.caption) : null], fields.risk_foreign_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = frisk_control_linkslist,
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
    frisk_control_linkslist.validate = function () {
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
        if (gridinsert && addcnt == 0) { // No row added
            ew.alert(ew.language.phrase("NoAddRecord"));
            return false;
        }
        return true;
    }

    // Check empty row
    frisk_control_linkslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "control_foreign_id", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "risk_foreign_id", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    frisk_control_linkslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    frisk_control_linkslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    frisk_control_linkslist.lists.control_foreign_id = <?= $Page->control_foreign_id->toClientList($Page) ?>;
    frisk_control_linkslist.lists.risk_foreign_id = <?= $Page->risk_foreign_id->toClientList($Page) ?>;
    loadjs.done("frisk_control_linkslist");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "risk_librairies") {
    if ($Page->MasterRecordExists) {
        include_once "views/RiskLibrairiesMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "questions_library") {
    if ($Page->MasterRecordExists) {
        include_once "views/QuestionsLibraryMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> risk_control_links">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="frisk_control_linkslist" id="frisk_control_linkslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_control_links">
<?php if ($Page->getCurrentMasterTable() == "risk_librairies" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="risk_librairies">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->risk_foreign_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "questions_library" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="questions_library">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->control_foreign_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_risk_control_links" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_risk_control_linkslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_risk_control_links_id" class="risk_control_links_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->control_foreign_id->Visible) { // control_foreign_id ?>
        <th data-name="control_foreign_id" class="<?= $Page->control_foreign_id->headerCellClass() ?>"><div id="elh_risk_control_links_control_foreign_id" class="risk_control_links_control_foreign_id"><?= $Page->renderSort($Page->control_foreign_id) ?></div></th>
<?php } ?>
<?php if ($Page->risk_foreign_id->Visible) { // risk_foreign_id ?>
        <th data-name="risk_foreign_id" class="<?= $Page->risk_foreign_id->headerCellClass() ?>"><div id="elh_risk_control_links_risk_foreign_id" class="risk_control_links_risk_foreign_id"><?= $Page->renderSort($Page->risk_foreign_id) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
    if ($Page->isAdd() || $Page->isCopy()) {
        $Page->RowIndex = 0;
        $Page->KeyCount = $Page->RowIndex;
        if ($Page->isAdd())
            $Page->loadRowValues();
        if ($Page->EventCancelled) // Insert failed
            $Page->restoreFormValues(); // Restore form values

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_risk_control_links", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el<?= $Page->RowCount ?>_risk_control_links_id" class="form-group risk_control_links_id"></span>
<input type="hidden" data-table="risk_control_links" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->control_foreign_id->Visible) { // control_foreign_id ?>
        <td data-name="control_foreign_id">
<?php if ($Page->control_foreign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_control_foreign_id" class="form-group risk_control_links_control_foreign_id">
<span<?= $Page->control_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->control_foreign_id->getDisplayValue($Page->control_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_control_foreign_id" name="x<?= $Page->RowIndex ?>_control_foreign_id" value="<?= HtmlEncode($Page->control_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_control_foreign_id" class="form-group risk_control_links_control_foreign_id">
    <select
        id="x<?= $Page->RowIndex ?>_control_foreign_id"
        name="x<?= $Page->RowIndex ?>_control_foreign_id"
        class="form-control ew-select<?= $Page->control_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id"
        data-table="risk_control_links"
        data-field="x_control_foreign_id"
        data-value-separator="<?= $Page->control_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->control_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->control_foreign_id->editAttributes() ?>>
        <?= $Page->control_foreign_id->selectOptionListHtml("x{$Page->RowIndex}_control_foreign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->control_foreign_id->getErrorMessage() ?></div>
<?= $Page->control_foreign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_control_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_control_foreign_id", selectId: "risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.control_foreign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="risk_control_links" data-field="x_control_foreign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_control_foreign_id" id="o<?= $Page->RowIndex ?>_control_foreign_id" value="<?= HtmlEncode($Page->control_foreign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->risk_foreign_id->Visible) { // risk_foreign_id ?>
        <td data-name="risk_foreign_id">
<?php if ($Page->risk_foreign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_risk_foreign_id" class="form-group risk_control_links_risk_foreign_id">
<span<?= $Page->risk_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->risk_foreign_id->getDisplayValue($Page->risk_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_risk_foreign_id" name="x<?= $Page->RowIndex ?>_risk_foreign_id" value="<?= HtmlEncode($Page->risk_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_risk_foreign_id" class="form-group risk_control_links_risk_foreign_id">
    <select
        id="x<?= $Page->RowIndex ?>_risk_foreign_id"
        name="x<?= $Page->RowIndex ?>_risk_foreign_id"
        class="form-control ew-select<?= $Page->risk_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id"
        data-table="risk_control_links"
        data-field="x_risk_foreign_id"
        data-value-separator="<?= $Page->risk_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->risk_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->risk_foreign_id->editAttributes() ?>>
        <?= $Page->risk_foreign_id->selectOptionListHtml("x{$Page->RowIndex}_risk_foreign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->risk_foreign_id->getErrorMessage() ?></div>
<?= $Page->risk_foreign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_risk_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_risk_foreign_id", selectId: "risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.risk_foreign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="risk_control_links" data-field="x_risk_foreign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_risk_foreign_id" id="o<?= $Page->RowIndex ?>_risk_foreign_id" value="<?= HtmlEncode($Page->risk_foreign_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["frisk_control_linkslist","load"], function() {
    frisk_control_linkslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
if ($Page->isGridAdd())
    $Page->RowIndex = 0;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_risk_control_links", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Page->RowAction != "delete" && $Page->RowAction != "insertdelete" && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_id" class="form-group"></span>
<input type="hidden" data-table="risk_control_links" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->control_foreign_id->Visible) { // control_foreign_id ?>
        <td data-name="control_foreign_id" <?= $Page->control_foreign_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->control_foreign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_control_foreign_id" class="form-group">
<span<?= $Page->control_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->control_foreign_id->getDisplayValue($Page->control_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_control_foreign_id" name="x<?= $Page->RowIndex ?>_control_foreign_id" value="<?= HtmlEncode($Page->control_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_control_foreign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_control_foreign_id"
        name="x<?= $Page->RowIndex ?>_control_foreign_id"
        class="form-control ew-select<?= $Page->control_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id"
        data-table="risk_control_links"
        data-field="x_control_foreign_id"
        data-value-separator="<?= $Page->control_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->control_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->control_foreign_id->editAttributes() ?>>
        <?= $Page->control_foreign_id->selectOptionListHtml("x{$Page->RowIndex}_control_foreign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->control_foreign_id->getErrorMessage() ?></div>
<?= $Page->control_foreign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_control_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_control_foreign_id", selectId: "risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.control_foreign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="risk_control_links" data-field="x_control_foreign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_control_foreign_id" id="o<?= $Page->RowIndex ?>_control_foreign_id" value="<?= HtmlEncode($Page->control_foreign_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_control_foreign_id">
<span<?= $Page->control_foreign_id->viewAttributes() ?>>
<?= $Page->control_foreign_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->risk_foreign_id->Visible) { // risk_foreign_id ?>
        <td data-name="risk_foreign_id" <?= $Page->risk_foreign_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->risk_foreign_id->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_risk_foreign_id" class="form-group">
<span<?= $Page->risk_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->risk_foreign_id->getDisplayValue($Page->risk_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_risk_foreign_id" name="x<?= $Page->RowIndex ?>_risk_foreign_id" value="<?= HtmlEncode($Page->risk_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_risk_foreign_id" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_risk_foreign_id"
        name="x<?= $Page->RowIndex ?>_risk_foreign_id"
        class="form-control ew-select<?= $Page->risk_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id"
        data-table="risk_control_links"
        data-field="x_risk_foreign_id"
        data-value-separator="<?= $Page->risk_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->risk_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->risk_foreign_id->editAttributes() ?>>
        <?= $Page->risk_foreign_id->selectOptionListHtml("x{$Page->RowIndex}_risk_foreign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->risk_foreign_id->getErrorMessage() ?></div>
<?= $Page->risk_foreign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_risk_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_risk_foreign_id", selectId: "risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.risk_foreign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="risk_control_links" data-field="x_risk_foreign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_risk_foreign_id" id="o<?= $Page->RowIndex ?>_risk_foreign_id" value="<?= HtmlEncode($Page->risk_foreign_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_control_links_risk_foreign_id">
<span<?= $Page->risk_foreign_id->viewAttributes() ?>>
<?= $Page->risk_foreign_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["frisk_control_linkslist","load"], function () {
    frisk_control_linkslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
    if ($Page->isGridAdd() || $Page->isGridEdit()) {
        $Page->RowIndex = '$rowindex$';
        $Page->loadRowValues();

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_risk_control_links", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowAttrs->appendClass("ew-template");
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el$rowindex$_risk_control_links_id" class="form-group risk_control_links_id"></span>
<input type="hidden" data-table="risk_control_links" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->control_foreign_id->Visible) { // control_foreign_id ?>
        <td data-name="control_foreign_id">
<?php if ($Page->control_foreign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_risk_control_links_control_foreign_id" class="form-group risk_control_links_control_foreign_id">
<span<?= $Page->control_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->control_foreign_id->getDisplayValue($Page->control_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_control_foreign_id" name="x<?= $Page->RowIndex ?>_control_foreign_id" value="<?= HtmlEncode($Page->control_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_risk_control_links_control_foreign_id" class="form-group risk_control_links_control_foreign_id">
    <select
        id="x<?= $Page->RowIndex ?>_control_foreign_id"
        name="x<?= $Page->RowIndex ?>_control_foreign_id"
        class="form-control ew-select<?= $Page->control_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id"
        data-table="risk_control_links"
        data-field="x_control_foreign_id"
        data-value-separator="<?= $Page->control_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->control_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->control_foreign_id->editAttributes() ?>>
        <?= $Page->control_foreign_id->selectOptionListHtml("x{$Page->RowIndex}_control_foreign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->control_foreign_id->getErrorMessage() ?></div>
<?= $Page->control_foreign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_control_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_control_foreign_id", selectId: "risk_control_links_x<?= $Page->RowIndex ?>_control_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.control_foreign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="risk_control_links" data-field="x_control_foreign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_control_foreign_id" id="o<?= $Page->RowIndex ?>_control_foreign_id" value="<?= HtmlEncode($Page->control_foreign_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->risk_foreign_id->Visible) { // risk_foreign_id ?>
        <td data-name="risk_foreign_id">
<?php if ($Page->risk_foreign_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_risk_control_links_risk_foreign_id" class="form-group risk_control_links_risk_foreign_id">
<span<?= $Page->risk_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->risk_foreign_id->getDisplayValue($Page->risk_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_risk_foreign_id" name="x<?= $Page->RowIndex ?>_risk_foreign_id" value="<?= HtmlEncode($Page->risk_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_risk_control_links_risk_foreign_id" class="form-group risk_control_links_risk_foreign_id">
    <select
        id="x<?= $Page->RowIndex ?>_risk_foreign_id"
        name="x<?= $Page->RowIndex ?>_risk_foreign_id"
        class="form-control ew-select<?= $Page->risk_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id"
        data-table="risk_control_links"
        data-field="x_risk_foreign_id"
        data-value-separator="<?= $Page->risk_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->risk_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->risk_foreign_id->editAttributes() ?>>
        <?= $Page->risk_foreign_id->selectOptionListHtml("x{$Page->RowIndex}_risk_foreign_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->risk_foreign_id->getErrorMessage() ?></div>
<?= $Page->risk_foreign_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_risk_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id']"),
        options = { name: "x<?= $Page->RowIndex ?>_risk_foreign_id", selectId: "risk_control_links_x<?= $Page->RowIndex ?>_risk_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.risk_foreign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="risk_control_links" data-field="x_risk_foreign_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_risk_foreign_id" id="o<?= $Page->RowIndex ?>_risk_foreign_id" value="<?= HtmlEncode($Page->risk_foreign_id->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["frisk_control_linkslist","load"], function() {
    frisk_control_linkslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("risk_control_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
