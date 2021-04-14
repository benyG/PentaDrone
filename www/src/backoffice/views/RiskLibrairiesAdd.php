<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$RiskLibrairiesAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var frisk_librairiesadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    frisk_librairiesadd = currentForm = new ew.Form("frisk_librairiesadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "risk_librairies")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.risk_librairies)
        ew.vars.tables.risk_librairies = currentTable;
    frisk_librairiesadd.addFields([
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["layer", [fields.layer.visible && fields.layer.required ? ew.Validators.required(fields.layer.caption) : null], fields.layer.isInvalid],
        ["function_csf", [fields.function_csf.visible && fields.function_csf.required ? ew.Validators.required(fields.function_csf.caption) : null], fields.function_csf.isInvalid],
        ["tag", [fields.tag.visible && fields.tag.required ? ew.Validators.required(fields.tag.caption) : null], fields.tag.isInvalid],
        ["Confidentiality", [fields.Confidentiality.visible && fields.Confidentiality.required ? ew.Validators.required(fields.Confidentiality.caption) : null], fields.Confidentiality.isInvalid],
        ["Integrity", [fields.Integrity.visible && fields.Integrity.required ? ew.Validators.required(fields.Integrity.caption) : null], fields.Integrity.isInvalid],
        ["Availability", [fields.Availability.visible && fields.Availability.required ? ew.Validators.required(fields.Availability.caption) : null], fields.Availability.isInvalid],
        ["Efficiency", [fields.Efficiency.visible && fields.Efficiency.required ? ew.Validators.required(fields.Efficiency.caption) : null], fields.Efficiency.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = frisk_librairiesadd,
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
    frisk_librairiesadd.validate = function () {
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

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    frisk_librairiesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    frisk_librairiesadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    frisk_librairiesadd.lists.layer = <?= $Page->layer->toClientList($Page) ?>;
    frisk_librairiesadd.lists.function_csf = <?= $Page->function_csf->toClientList($Page) ?>;
    frisk_librairiesadd.lists.Confidentiality = <?= $Page->Confidentiality->toClientList($Page) ?>;
    frisk_librairiesadd.lists.Integrity = <?= $Page->Integrity->toClientList($Page) ?>;
    frisk_librairiesadd.lists.Availability = <?= $Page->Availability->toClientList($Page) ?>;
    frisk_librairiesadd.lists.Efficiency = <?= $Page->Efficiency->toClientList($Page) ?>;
    loadjs.done("frisk_librairiesadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="frisk_librairiesadd" id="frisk_librairiesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_librairies">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "layers") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="layers">
<input type="hidden" name="fk_name" value="<?= HtmlEncode($Page->layer->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "functions") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="functions">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->function_csf->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->title->Visible) { // title ?>
    <div id="r_title" class="form-group row">
        <label id="elh_risk_librairies_title" for="x_title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title->caption() ?><?= $Page->title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->title->cellAttributes() ?>>
<span id="el_risk_librairies_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="risk_librairies" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?> aria-describedby="x_title_help">
<?= $Page->title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->layer->Visible) { // layer ?>
    <div id="r_layer" class="form-group row">
        <label id="elh_risk_librairies_layer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->layer->caption() ?><?= $Page->layer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->layer->cellAttributes() ?>>
<?php if ($Page->layer->getSessionValue() != "") { ?>
<span id="el_risk_librairies_layer">
<span<?= $Page->layer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->layer->getDisplayValue($Page->layer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_layer" name="x_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_risk_librairies_layer">
<?php
$onchange = $Page->layer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->layer->EditAttrs["onchange"] = "";
?>
<span id="as_x_layer" class="ew-auto-suggest">
    <input type="<?= $Page->layer->getInputTextType() ?>" class="form-control" name="sv_x_layer" id="sv_x_layer" value="<?= RemoveHtml($Page->layer->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->layer->getPlaceHolder()) ?>"<?= $Page->layer->editAttributes() ?> aria-describedby="x_layer_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_layer" data-input="sv_x_layer" data-value-separator="<?= $Page->layer->displayValueSeparatorAttribute() ?>" name="x_layer" id="x_layer" value="<?= HtmlEncode($Page->layer->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->layer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->layer->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesadd"], function() {
    frisk_librairiesadd.createAutoSuggest(Object.assign({"id":"x_layer","forceSelect":false}, ew.vars.tables.risk_librairies.fields.layer.autoSuggestOptions));
});
</script>
<?= $Page->layer->Lookup->getParamTag($Page, "p_x_layer") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
    <div id="r_function_csf" class="form-group row">
        <label id="elh_risk_librairies_function_csf" class="<?= $Page->LeftColumnClass ?>"><?= $Page->function_csf->caption() ?><?= $Page->function_csf->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->function_csf->cellAttributes() ?>>
<?php if ($Page->function_csf->getSessionValue() != "") { ?>
<span id="el_risk_librairies_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->function_csf->getDisplayValue($Page->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_function_csf" name="x_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_risk_librairies_function_csf">
<?php
$onchange = $Page->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x_function_csf" class="ew-auto-suggest">
    <input type="<?= $Page->function_csf->getInputTextType() ?>" class="form-control" name="sv_x_function_csf" id="sv_x_function_csf" value="<?= RemoveHtml($Page->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>"<?= $Page->function_csf->editAttributes() ?> aria-describedby="x_function_csf_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="risk_librairies" data-field="x_function_csf" data-input="sv_x_function_csf" data-value-separator="<?= $Page->function_csf->displayValueSeparatorAttribute() ?>" name="x_function_csf" id="x_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->function_csf->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["frisk_librairiesadd"], function() {
    frisk_librairiesadd.createAutoSuggest(Object.assign({"id":"x_function_csf","forceSelect":false}, ew.vars.tables.risk_librairies.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Page->function_csf->Lookup->getParamTag($Page, "p_x_function_csf") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
    <div id="r_tag" class="form-group row">
        <label id="elh_risk_librairies_tag" for="x_tag" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tag->caption() ?><?= $Page->tag->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tag->cellAttributes() ?>>
<span id="el_risk_librairies_tag">
<input type="<?= $Page->tag->getInputTextType() ?>" data-table="risk_librairies" data-field="x_tag" name="x_tag" id="x_tag" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->tag->getPlaceHolder()) ?>" value="<?= $Page->tag->EditValue ?>"<?= $Page->tag->editAttributes() ?> aria-describedby="x_tag_help">
<?= $Page->tag->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tag->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
    <div id="r_Confidentiality" class="form-group row">
        <label id="elh_risk_librairies_Confidentiality" for="x_Confidentiality" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Confidentiality->caption() ?><?= $Page->Confidentiality->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Confidentiality->cellAttributes() ?>>
<span id="el_risk_librairies_Confidentiality">
    <select
        id="x_Confidentiality"
        name="x_Confidentiality"
        class="form-control ew-select<?= $Page->Confidentiality->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x_Confidentiality"
        data-table="risk_librairies"
        data-field="x_Confidentiality"
        data-value-separator="<?= $Page->Confidentiality->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Confidentiality->getPlaceHolder()) ?>"
        <?= $Page->Confidentiality->editAttributes() ?>>
        <?= $Page->Confidentiality->selectOptionListHtml("x_Confidentiality") ?>
    </select>
    <?= $Page->Confidentiality->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Confidentiality->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x_Confidentiality']"),
        options = { name: "x_Confidentiality", selectId: "risk_librairies_x_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
    <div id="r_Integrity" class="form-group row">
        <label id="elh_risk_librairies_Integrity" for="x_Integrity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Integrity->caption() ?><?= $Page->Integrity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Integrity->cellAttributes() ?>>
<span id="el_risk_librairies_Integrity">
    <select
        id="x_Integrity"
        name="x_Integrity"
        class="form-control ew-select<?= $Page->Integrity->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x_Integrity"
        data-table="risk_librairies"
        data-field="x_Integrity"
        data-value-separator="<?= $Page->Integrity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Integrity->getPlaceHolder()) ?>"
        <?= $Page->Integrity->editAttributes() ?>>
        <?= $Page->Integrity->selectOptionListHtml("x_Integrity") ?>
    </select>
    <?= $Page->Integrity->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Integrity->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x_Integrity']"),
        options = { name: "x_Integrity", selectId: "risk_librairies_x_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
    <div id="r_Availability" class="form-group row">
        <label id="elh_risk_librairies_Availability" for="x_Availability" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Availability->caption() ?><?= $Page->Availability->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Availability->cellAttributes() ?>>
<span id="el_risk_librairies_Availability">
    <select
        id="x_Availability"
        name="x_Availability"
        class="form-control ew-select<?= $Page->Availability->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x_Availability"
        data-table="risk_librairies"
        data-field="x_Availability"
        data-value-separator="<?= $Page->Availability->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Availability->getPlaceHolder()) ?>"
        <?= $Page->Availability->editAttributes() ?>>
        <?= $Page->Availability->selectOptionListHtml("x_Availability") ?>
    </select>
    <?= $Page->Availability->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Availability->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x_Availability']"),
        options = { name: "x_Availability", selectId: "risk_librairies_x_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
    <div id="r_Efficiency" class="form-group row">
        <label id="elh_risk_librairies_Efficiency" for="x_Efficiency" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Efficiency->caption() ?><?= $Page->Efficiency->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Efficiency->cellAttributes() ?>>
<span id="el_risk_librairies_Efficiency">
    <select
        id="x_Efficiency"
        name="x_Efficiency"
        class="form-control ew-select<?= $Page->Efficiency->isInvalidClass() ?>"
        data-select2-id="risk_librairies_x_Efficiency"
        data-table="risk_librairies"
        data-field="x_Efficiency"
        data-value-separator="<?= $Page->Efficiency->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Efficiency->getPlaceHolder()) ?>"
        <?= $Page->Efficiency->editAttributes() ?>>
        <?= $Page->Efficiency->selectOptionListHtml("x_Efficiency") ?>
    </select>
    <?= $Page->Efficiency->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Efficiency->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_librairies_x_Efficiency']"),
        options = { name: "x_Efficiency", selectId: "risk_librairies_x_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.risk_librairies.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_librairies.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_risk_librairies_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_risk_librairies_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="risk_librairies" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frisk_librairiesadd", "datetimepicker"], function() {
    ew.createDateTimePicker("frisk_librairiesadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_risk_librairies_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_risk_librairies_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="risk_librairies" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frisk_librairiesadd", "datetimepicker"], function() {
    ew.createDateTimePicker("frisk_librairiesadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
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
