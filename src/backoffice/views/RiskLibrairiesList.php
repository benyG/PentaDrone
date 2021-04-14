<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$RiskLibrairiesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var frisk_librairieslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    frisk_librairieslist = currentForm = new ew.Form("frisk_librairieslist", "list");
    frisk_librairieslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "risk_librairies")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.risk_librairies)
        ew.vars.tables.risk_librairies = currentTable;
    frisk_librairieslist.addFields([
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
        var f = frisk_librairieslist,
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
    frisk_librairieslist.validate = function () {
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
    frisk_librairieslist.emptyRow = function (rowIndex) {
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
    frisk_librairieslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    frisk_librairieslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    frisk_librairieslist.lists.layer = <?= $Page->layer->toClientList($Page) ?>;
    frisk_librairieslist.lists.function_csf = <?= $Page->function_csf->toClientList($Page) ?>;
    frisk_librairieslist.lists.Confidentiality = <?= $Page->Confidentiality->toClientList($Page) ?>;
    frisk_librairieslist.lists.Integrity = <?= $Page->Integrity->toClientList($Page) ?>;
    frisk_librairieslist.lists.Availability = <?= $Page->Availability->toClientList($Page) ?>;
    frisk_librairieslist.lists.Efficiency = <?= $Page->Efficiency->toClientList($Page) ?>;
    loadjs.done("frisk_librairieslist");
});
var frisk_librairieslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    frisk_librairieslistsrch = currentSearchForm = new ew.Form("frisk_librairieslistsrch");

    // Dynamic selection lists

    // Filters
    frisk_librairieslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("frisk_librairieslistsrch");
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "layers") {
    if ($Page->MasterRecordExists) {
        include_once "views/LayersMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "functions") {
    if ($Page->MasterRecordExists) {
        include_once "views/FunctionsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="frisk_librairieslistsrch" id="frisk_librairieslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="frisk_librairieslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="risk_librairies">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> risk_librairies">
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
<form name="frisk_librairieslist" id="frisk_librairieslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_librairies">
<?php if ($Page->getCurrentMasterTable() == "layers" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="layers">
<input type="hidden" name="fk_name" value="<?= HtmlEncode($Page->layer->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "functions" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="functions">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->function_csf->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_risk_librairies" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_risk_librairieslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_risk_librairies_id" class="risk_librairies_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <th data-name="title" class="<?= $Page->title->headerCellClass() ?>"><div id="elh_risk_librairies_title" class="risk_librairies_title"><?= $Page->renderSort($Page->title) ?></div></th>
<?php } ?>
<?php if ($Page->layer->Visible) { // layer ?>
        <th data-name="layer" class="<?= $Page->layer->headerCellClass() ?>"><div id="elh_risk_librairies_layer" class="risk_librairies_layer"><?= $Page->renderSort($Page->layer) ?></div></th>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
        <th data-name="function_csf" class="<?= $Page->function_csf->headerCellClass() ?>"><div id="elh_risk_librairies_function_csf" class="risk_librairies_function_csf"><?= $Page->renderSort($Page->function_csf) ?></div></th>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
        <th data-name="tag" class="<?= $Page->tag->headerCellClass() ?>"><div id="elh_risk_librairies_tag" class="risk_librairies_tag"><?= $Page->renderSort($Page->tag) ?></div></th>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <th data-name="Confidentiality" class="<?= $Page->Confidentiality->headerCellClass() ?>"><div id="elh_risk_librairies_Confidentiality" class="risk_librairies_Confidentiality"><?= $Page->renderSort($Page->Confidentiality) ?></div></th>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
        <th data-name="Integrity" class="<?= $Page->Integrity->headerCellClass() ?>"><div id="elh_risk_librairies_Integrity" class="risk_librairies_Integrity"><?= $Page->renderSort($Page->Integrity) ?></div></th>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
        <th data-name="Availability" class="<?= $Page->Availability->headerCellClass() ?>"><div id="elh_risk_librairies_Availability" class="risk_librairies_Availability"><?= $Page->renderSort($Page->Availability) ?></div></th>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <th data-name="Efficiency" class="<?= $Page->Efficiency->headerCellClass() ?>"><div id="elh_risk_librairies_Efficiency" class="risk_librairies_Efficiency"><?= $Page->renderSort($Page->Efficiency) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_risk_librairies", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el<?= $Page->RowCount ?>_risk_librairies_id" class="form-group risk_librairies_id"></span>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->title->Visible) { // title ?>
        <td data-name="title">
<span id="el<?= $Page->RowCount ?>_risk_librairies_title" class="form-group risk_librairies_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="risk_librairies" data-field="x_title" name="x<?= $Page->RowIndex ?>_title" id="x<?= $Page->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="o<?= $Page->RowIndex ?>_title" id="o<?= $Page->RowIndex ?>_title" value="<?= HtmlEncode($Page->title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->layer->Visible) { // layer ?>
        <td data-name="layer">
<?php if ($Page->layer->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_layer" class="form-group risk_librairies_layer">
<span<?= $Page->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->layer->getDisplayValue($Page->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_layer" name="x<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_layer" class="form-group risk_librairies_layer">
<?php
$onchange = $Page->layer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->layer->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_layer" class="ew-auto-suggest">
    <input type="<?= $Page->layer->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_layer" id="sv_x<?= $Page->RowIndex ?>_layer" value="<?= RemoveHtml($Page->layer->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>"<?= $Page->layer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_layer" data-input="sv_x<?= $Page->RowIndex ?>_layer" data-value-separator="<?= $Page->layer->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_layer" id="x<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->layer->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairieslist"], function() {
    frisk_librairieslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_layer","forceSelect":false}, ew.vars.tables.risk_librairies.fields.layer.autoSuggestOptions));
});
</script>
<?= $Page->layer->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_layer") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="o<?= $Page->RowIndex ?>_layer" id="o<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf">
<?php if ($Page->function_csf->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_function_csf" class="form-group risk_librairies_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->function_csf->getDisplayValue($Page->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_function_csf" name="x<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_function_csf" class="form-group risk_librairies_function_csf">
<?php
$onchange = $Page->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Page->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_function_csf" id="sv_x<?= $Page->RowIndex ?>_function_csf" value="<?= RemoveHtml($Page->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>"<?= $Page->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_function_csf" data-input="sv_x<?= $Page->RowIndex ?>_function_csf" data-value-separator="<?= $Page->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_function_csf" id="x<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairieslist"], function() {
    frisk_librairieslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.risk_librairies.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Page->function_csf->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="o<?= $Page->RowIndex ?>_function_csf" id="o<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->tag->Visible) { // tag ?>
        <td data-name="tag">
<span id="el<?= $Page->RowCount ?>_risk_librairies_tag" class="form-group risk_librairies_tag">
<input type="<?= $Page->tag->getInputTextType() ?>" data-table="risk_librairies" data-field="x_tag" name="x<?= $Page->RowIndex ?>_tag" id="x<?= $Page->RowIndex ?>_tag" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->tag->getPlaceHolder()) ?>" value="<?= $Page->tag->EditValue ?>"<?= $Page->tag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tag->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="o<?= $Page->RowIndex ?>_tag" id="o<?= $Page->RowIndex ?>_tag" value="<?= HtmlEncode($Page->tag->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <td data-name="Confidentiality">
<span id="el<?= $Page->RowCount ?>_risk_librairies_Confidentiality" class="form-group risk_librairies_Confidentiality">
    <select
        id="x<?= $Page->RowIndex ?>_Confidentiality"
        name="x<?= $Page->RowIndex ?>_Confidentiality"
        class="form-control ew-select<?= $Page->Confidentiality->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality"
        data-table="risk_librairies"
        data-field="x_Confidentiality"
        data-value-separator="<?= $Page->Confidentiality->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Confidentiality->getPlaceHolder()) ?>"
        <?= $Page->Confidentiality->editAttributes() ?>>
        <?= $Page->Confidentiality->selectOptionListHtml("x{$Page->RowIndex}_Confidentiality") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Confidentiality->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality']"),
        options = { name: "x<?= $Page->RowIndex ?>_Confidentiality", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="o<?= $Page->RowIndex ?>_Confidentiality" id="o<?= $Page->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Page->Confidentiality->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Integrity->Visible) { // Integrity ?>
        <td data-name="Integrity">
<span id="el<?= $Page->RowCount ?>_risk_librairies_Integrity" class="form-group risk_librairies_Integrity">
    <select
        id="x<?= $Page->RowIndex ?>_Integrity"
        name="x<?= $Page->RowIndex ?>_Integrity"
        class="form-control ew-select<?= $Page->Integrity->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Integrity"
        data-table="risk_librairies"
        data-field="x_Integrity"
        data-value-separator="<?= $Page->Integrity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Integrity->getPlaceHolder()) ?>"
        <?= $Page->Integrity->editAttributes() ?>>
        <?= $Page->Integrity->selectOptionListHtml("x{$Page->RowIndex}_Integrity") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Integrity->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Integrity']"),
        options = { name: "x<?= $Page->RowIndex ?>_Integrity", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="o<?= $Page->RowIndex ?>_Integrity" id="o<?= $Page->RowIndex ?>_Integrity" value="<?= HtmlEncode($Page->Integrity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Availability->Visible) { // Availability ?>
        <td data-name="Availability">
<span id="el<?= $Page->RowCount ?>_risk_librairies_Availability" class="form-group risk_librairies_Availability">
    <select
        id="x<?= $Page->RowIndex ?>_Availability"
        name="x<?= $Page->RowIndex ?>_Availability"
        class="form-control ew-select<?= $Page->Availability->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Availability"
        data-table="risk_librairies"
        data-field="x_Availability"
        data-value-separator="<?= $Page->Availability->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Availability->getPlaceHolder()) ?>"
        <?= $Page->Availability->editAttributes() ?>>
        <?= $Page->Availability->selectOptionListHtml("x{$Page->RowIndex}_Availability") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Availability->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Availability']"),
        options = { name: "x<?= $Page->RowIndex ?>_Availability", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="o<?= $Page->RowIndex ?>_Availability" id="o<?= $Page->RowIndex ?>_Availability" value="<?= HtmlEncode($Page->Availability->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <td data-name="Efficiency">
<span id="el<?= $Page->RowCount ?>_risk_librairies_Efficiency" class="form-group risk_librairies_Efficiency">
    <select
        id="x<?= $Page->RowIndex ?>_Efficiency"
        name="x<?= $Page->RowIndex ?>_Efficiency"
        class="form-control ew-select<?= $Page->Efficiency->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Efficiency"
        data-table="risk_librairies"
        data-field="x_Efficiency"
        data-value-separator="<?= $Page->Efficiency->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Efficiency->getPlaceHolder()) ?>"
        <?= $Page->Efficiency->editAttributes() ?>>
        <?= $Page->Efficiency->selectOptionListHtml("x{$Page->RowIndex}_Efficiency") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Efficiency->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Efficiency']"),
        options = { name: "x<?= $Page->RowIndex ?>_Efficiency", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="o<?= $Page->RowIndex ?>_Efficiency" id="o<?= $Page->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Page->Efficiency->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["frisk_librairieslist","load"], function() {
    frisk_librairieslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_risk_librairies", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_risk_librairies_id" class="form-group"></span>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->title->Visible) { // title ?>
        <td data-name="title" <?= $Page->title->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_title" class="form-group">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="risk_librairies" data-field="x_title" name="x<?= $Page->RowIndex ?>_title" id="x<?= $Page->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="o<?= $Page->RowIndex ?>_title" id="o<?= $Page->RowIndex ?>_title" value="<?= HtmlEncode($Page->title->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->layer->Visible) { // layer ?>
        <td data-name="layer" <?= $Page->layer->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->layer->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_layer" class="form-group">
<span<?= $Page->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->layer->getDisplayValue($Page->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_layer" name="x<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_layer" class="form-group">
<?php
$onchange = $Page->layer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->layer->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_layer" class="ew-auto-suggest">
    <input type="<?= $Page->layer->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_layer" id="sv_x<?= $Page->RowIndex ?>_layer" value="<?= RemoveHtml($Page->layer->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>"<?= $Page->layer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_layer" data-input="sv_x<?= $Page->RowIndex ?>_layer" data-value-separator="<?= $Page->layer->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_layer" id="x<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->layer->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairieslist"], function() {
    frisk_librairieslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_layer","forceSelect":false}, ew.vars.tables.risk_librairies.fields.layer.autoSuggestOptions));
});
</script>
<?= $Page->layer->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_layer") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="o<?= $Page->RowIndex ?>_layer" id="o<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_layer">
<span<?= $Page->layer->viewAttributes() ?>>
<?= $Page->layer->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf" <?= $Page->function_csf->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->function_csf->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_function_csf" class="form-group">
<span<?= $Page->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->function_csf->getDisplayValue($Page->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_function_csf" name="x<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_function_csf" class="form-group">
<?php
$onchange = $Page->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Page->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_function_csf" id="sv_x<?= $Page->RowIndex ?>_function_csf" value="<?= RemoveHtml($Page->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>"<?= $Page->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_function_csf" data-input="sv_x<?= $Page->RowIndex ?>_function_csf" data-value-separator="<?= $Page->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_function_csf" id="x<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairieslist"], function() {
    frisk_librairieslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.risk_librairies.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Page->function_csf->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="o<?= $Page->RowIndex ?>_function_csf" id="o<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<?= $Page->function_csf->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->tag->Visible) { // tag ?>
        <td data-name="tag" <?= $Page->tag->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_tag" class="form-group">
<input type="<?= $Page->tag->getInputTextType() ?>" data-table="risk_librairies" data-field="x_tag" name="x<?= $Page->RowIndex ?>_tag" id="x<?= $Page->RowIndex ?>_tag" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->tag->getPlaceHolder()) ?>" value="<?= $Page->tag->EditValue ?>"<?= $Page->tag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tag->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="o<?= $Page->RowIndex ?>_tag" id="o<?= $Page->RowIndex ?>_tag" value="<?= HtmlEncode($Page->tag->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_tag">
<span<?= $Page->tag->viewAttributes() ?>>
<?= $Page->tag->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <td data-name="Confidentiality" <?= $Page->Confidentiality->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Confidentiality" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_Confidentiality"
        name="x<?= $Page->RowIndex ?>_Confidentiality"
        class="form-control ew-select<?= $Page->Confidentiality->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality"
        data-table="risk_librairies"
        data-field="x_Confidentiality"
        data-value-separator="<?= $Page->Confidentiality->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Confidentiality->getPlaceHolder()) ?>"
        <?= $Page->Confidentiality->editAttributes() ?>>
        <?= $Page->Confidentiality->selectOptionListHtml("x{$Page->RowIndex}_Confidentiality") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Confidentiality->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality']"),
        options = { name: "x<?= $Page->RowIndex ?>_Confidentiality", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="o<?= $Page->RowIndex ?>_Confidentiality" id="o<?= $Page->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Page->Confidentiality->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Confidentiality">
<span<?= $Page->Confidentiality->viewAttributes() ?>>
<?= $Page->Confidentiality->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Integrity->Visible) { // Integrity ?>
        <td data-name="Integrity" <?= $Page->Integrity->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Integrity" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_Integrity"
        name="x<?= $Page->RowIndex ?>_Integrity"
        class="form-control ew-select<?= $Page->Integrity->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Integrity"
        data-table="risk_librairies"
        data-field="x_Integrity"
        data-value-separator="<?= $Page->Integrity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Integrity->getPlaceHolder()) ?>"
        <?= $Page->Integrity->editAttributes() ?>>
        <?= $Page->Integrity->selectOptionListHtml("x{$Page->RowIndex}_Integrity") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Integrity->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Integrity']"),
        options = { name: "x<?= $Page->RowIndex ?>_Integrity", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="o<?= $Page->RowIndex ?>_Integrity" id="o<?= $Page->RowIndex ?>_Integrity" value="<?= HtmlEncode($Page->Integrity->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Integrity">
<span<?= $Page->Integrity->viewAttributes() ?>>
<?= $Page->Integrity->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Availability->Visible) { // Availability ?>
        <td data-name="Availability" <?= $Page->Availability->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Availability" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_Availability"
        name="x<?= $Page->RowIndex ?>_Availability"
        class="form-control ew-select<?= $Page->Availability->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Availability"
        data-table="risk_librairies"
        data-field="x_Availability"
        data-value-separator="<?= $Page->Availability->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Availability->getPlaceHolder()) ?>"
        <?= $Page->Availability->editAttributes() ?>>
        <?= $Page->Availability->selectOptionListHtml("x{$Page->RowIndex}_Availability") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Availability->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Availability']"),
        options = { name: "x<?= $Page->RowIndex ?>_Availability", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="o<?= $Page->RowIndex ?>_Availability" id="o<?= $Page->RowIndex ?>_Availability" value="<?= HtmlEncode($Page->Availability->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Availability">
<span<?= $Page->Availability->viewAttributes() ?>>
<?= $Page->Availability->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <td data-name="Efficiency" <?= $Page->Efficiency->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Efficiency" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_Efficiency"
        name="x<?= $Page->RowIndex ?>_Efficiency"
        class="form-control ew-select<?= $Page->Efficiency->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Efficiency"
        data-table="risk_librairies"
        data-field="x_Efficiency"
        data-value-separator="<?= $Page->Efficiency->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Efficiency->getPlaceHolder()) ?>"
        <?= $Page->Efficiency->editAttributes() ?>>
        <?= $Page->Efficiency->selectOptionListHtml("x{$Page->RowIndex}_Efficiency") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Efficiency->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Efficiency']"),
        options = { name: "x<?= $Page->RowIndex ?>_Efficiency", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="o<?= $Page->RowIndex ?>_Efficiency" id="o<?= $Page->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Page->Efficiency->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_risk_librairies_Efficiency">
<span<?= $Page->Efficiency->viewAttributes() ?>>
<?= $Page->Efficiency->getViewValue() ?></span>
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
loadjs.ready(["frisk_librairieslist","load"], function () {
    frisk_librairieslist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_risk_librairies", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_risk_librairies_id" class="form-group risk_librairies_id"></span>
<input type="hidden" data-table="risk_librairies" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->title->Visible) { // title ?>
        <td data-name="title">
<span id="el$rowindex$_risk_librairies_title" class="form-group risk_librairies_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="risk_librairies" data-field="x_title" name="x<?= $Page->RowIndex ?>_title" id="x<?= $Page->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_title" data-hidden="1" name="o<?= $Page->RowIndex ?>_title" id="o<?= $Page->RowIndex ?>_title" value="<?= HtmlEncode($Page->title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->layer->Visible) { // layer ?>
        <td data-name="layer">
<?php if ($Page->layer->getSessionValue() != "") { ?>
<span id="el$rowindex$_risk_librairies_layer" class="form-group risk_librairies_layer">
<span<?= $Page->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->layer->getDisplayValue($Page->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_layer" name="x<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_layer" class="form-group risk_librairies_layer">
<?php
$onchange = $Page->layer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->layer->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_layer" class="ew-auto-suggest">
    <input type="<?= $Page->layer->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_layer" id="sv_x<?= $Page->RowIndex ?>_layer" value="<?= RemoveHtml($Page->layer->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>"<?= $Page->layer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_layer" data-input="sv_x<?= $Page->RowIndex ?>_layer" data-value-separator="<?= $Page->layer->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_layer" id="x<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->layer->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairieslist"], function() {
    frisk_librairieslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_layer","forceSelect":false}, ew.vars.tables.risk_librairies.fields.layer.autoSuggestOptions));
});
</script>
<?= $Page->layer->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_layer") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_layer" data-hidden="1" name="o<?= $Page->RowIndex ?>_layer" id="o<?= $Page->RowIndex ?>_layer" value="<?= HtmlEncode($Page->layer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->function_csf->Visible) { // function_csf ?>
        <td data-name="function_csf">
<?php if ($Page->function_csf->getSessionValue() != "") { ?>
<span id="el$rowindex$_risk_librairies_function_csf" class="form-group risk_librairies_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->function_csf->getDisplayValue($Page->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_function_csf" name="x<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_risk_librairies_function_csf" class="form-group risk_librairies_function_csf">
<?php
$onchange = $Page->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_function_csf" class="ew-auto-suggest">
    <input type="<?= $Page->function_csf->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_function_csf" id="sv_x<?= $Page->RowIndex ?>_function_csf" value="<?= RemoveHtml($Page->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>"<?= $Page->function_csf->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_function_csf" data-input="sv_x<?= $Page->RowIndex ?>_function_csf" data-value-separator="<?= $Page->function_csf->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_function_csf" id="x<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairieslist"], function() {
    frisk_librairieslist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_function_csf","forceSelect":false}, ew.vars.tables.risk_librairies.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Page->function_csf->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_function_csf") ?>
</span>
<?php } ?>
<input type="hidden" data-table="risk_librairies" data-field="x_function_csf" data-hidden="1" name="o<?= $Page->RowIndex ?>_function_csf" id="o<?= $Page->RowIndex ?>_function_csf" value="<?= HtmlEncode($Page->function_csf->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->tag->Visible) { // tag ?>
        <td data-name="tag">
<span id="el$rowindex$_risk_librairies_tag" class="form-group risk_librairies_tag">
<input type="<?= $Page->tag->getInputTextType() ?>" data-table="risk_librairies" data-field="x_tag" name="x<?= $Page->RowIndex ?>_tag" id="x<?= $Page->RowIndex ?>_tag" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->tag->getPlaceHolder()) ?>" value="<?= $Page->tag->EditValue ?>"<?= $Page->tag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tag->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_tag" data-hidden="1" name="o<?= $Page->RowIndex ?>_tag" id="o<?= $Page->RowIndex ?>_tag" value="<?= HtmlEncode($Page->tag->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
        <td data-name="Confidentiality">
<span id="el$rowindex$_risk_librairies_Confidentiality" class="form-group risk_librairies_Confidentiality">
    <select
        id="x<?= $Page->RowIndex ?>_Confidentiality"
        name="x<?= $Page->RowIndex ?>_Confidentiality"
        class="form-control ew-select<?= $Page->Confidentiality->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality"
        data-table="risk_librairies"
        data-field="x_Confidentiality"
        data-value-separator="<?= $Page->Confidentiality->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Confidentiality->getPlaceHolder()) ?>"
        <?= $Page->Confidentiality->editAttributes() ?>>
        <?= $Page->Confidentiality->selectOptionListHtml("x{$Page->RowIndex}_Confidentiality") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Confidentiality->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality']"),
        options = { name: "x<?= $Page->RowIndex ?>_Confidentiality", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Confidentiality" data-hidden="1" name="o<?= $Page->RowIndex ?>_Confidentiality" id="o<?= $Page->RowIndex ?>_Confidentiality" value="<?= HtmlEncode($Page->Confidentiality->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Integrity->Visible) { // Integrity ?>
        <td data-name="Integrity">
<span id="el$rowindex$_risk_librairies_Integrity" class="form-group risk_librairies_Integrity">
    <select
        id="x<?= $Page->RowIndex ?>_Integrity"
        name="x<?= $Page->RowIndex ?>_Integrity"
        class="form-control ew-select<?= $Page->Integrity->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Integrity"
        data-table="risk_librairies"
        data-field="x_Integrity"
        data-value-separator="<?= $Page->Integrity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Integrity->getPlaceHolder()) ?>"
        <?= $Page->Integrity->editAttributes() ?>>
        <?= $Page->Integrity->selectOptionListHtml("x{$Page->RowIndex}_Integrity") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Integrity->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Integrity']"),
        options = { name: "x<?= $Page->RowIndex ?>_Integrity", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Integrity" data-hidden="1" name="o<?= $Page->RowIndex ?>_Integrity" id="o<?= $Page->RowIndex ?>_Integrity" value="<?= HtmlEncode($Page->Integrity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Availability->Visible) { // Availability ?>
        <td data-name="Availability">
<span id="el$rowindex$_risk_librairies_Availability" class="form-group risk_librairies_Availability">
    <select
        id="x<?= $Page->RowIndex ?>_Availability"
        name="x<?= $Page->RowIndex ?>_Availability"
        class="form-control ew-select<?= $Page->Availability->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Availability"
        data-table="risk_librairies"
        data-field="x_Availability"
        data-value-separator="<?= $Page->Availability->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Availability->getPlaceHolder()) ?>"
        <?= $Page->Availability->editAttributes() ?>>
        <?= $Page->Availability->selectOptionListHtml("x{$Page->RowIndex}_Availability") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Availability->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Availability']"),
        options = { name: "x<?= $Page->RowIndex ?>_Availability", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Availability" data-hidden="1" name="o<?= $Page->RowIndex ?>_Availability" id="o<?= $Page->RowIndex ?>_Availability" value="<?= HtmlEncode($Page->Availability->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Efficiency->Visible) { // Efficiency ?>
        <td data-name="Efficiency">
<span id="el$rowindex$_risk_librairies_Efficiency" class="form-group risk_librairies_Efficiency">
    <select
        id="x<?= $Page->RowIndex ?>_Efficiency"
        name="x<?= $Page->RowIndex ?>_Efficiency"
        class="form-control ew-select<?= $Page->Efficiency->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x<?= $Page->RowIndex ?>_Efficiency"
        data-table="risk_librairies"
        data-field="x_Efficiency"
        data-value-separator="<?= $Page->Efficiency->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Efficiency->getPlaceHolder()) ?>"
        <?= $Page->Efficiency->editAttributes() ?>>
        <?= $Page->Efficiency->selectOptionListHtml("x{$Page->RowIndex}_Efficiency") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Efficiency->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x<?= $Page->RowIndex ?>_Efficiency']"),
        options = { name: "x<?= $Page->RowIndex ?>_Efficiency", selectId: "risk_librairies_x<?= $Page->RowIndex ?>_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="risk_librairies" data-field="x_Efficiency" data-hidden="1" name="o<?= $Page->RowIndex ?>_Efficiency" id="o<?= $Page->RowIndex ?>_Efficiency" value="<?= HtmlEncode($Page->Efficiency->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["frisk_librairieslist","load"], function() {
    frisk_librairieslist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("risk_librairies");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
