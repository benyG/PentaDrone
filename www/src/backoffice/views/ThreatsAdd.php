<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$ThreatsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fthreatsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fthreatsadd = currentForm = new ew.Form("fthreatsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "threats")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.threats)
        ew.vars.tables.threats = currentTable;
    fthreatsadd.addFields([
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["Confidentiality", [fields.Confidentiality.visible && fields.Confidentiality.required ? ew.Validators.required(fields.Confidentiality.caption) : null], fields.Confidentiality.isInvalid],
        ["Integrity", [fields.Integrity.visible && fields.Integrity.required ? ew.Validators.required(fields.Integrity.caption) : null], fields.Integrity.isInvalid],
        ["Availability", [fields.Availability.visible && fields.Availability.required ? ew.Validators.required(fields.Availability.caption) : null], fields.Availability.isInvalid],
        ["Efficiency", [fields.Efficiency.visible && fields.Efficiency.required ? ew.Validators.required(fields.Efficiency.caption) : null], fields.Efficiency.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fthreatsadd,
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
    fthreatsadd.validate = function () {
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
    fthreatsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fthreatsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fthreatsadd.lists.Confidentiality = <?= $Page->Confidentiality->toClientList($Page) ?>;
    fthreatsadd.lists.Integrity = <?= $Page->Integrity->toClientList($Page) ?>;
    fthreatsadd.lists.Availability = <?= $Page->Availability->toClientList($Page) ?>;
    fthreatsadd.lists.Efficiency = <?= $Page->Efficiency->toClientList($Page) ?>;
    loadjs.done("fthreatsadd");
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
<form name="fthreatsadd" id="fthreatsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="threats">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_threats_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_threats_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="threats" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Confidentiality->Visible) { // Confidentiality ?>
    <div id="r_Confidentiality" class="form-group row">
        <label id="elh_threats_Confidentiality" for="x_Confidentiality" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Confidentiality->caption() ?><?= $Page->Confidentiality->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Confidentiality->cellAttributes() ?>>
<span id="el_threats_Confidentiality">
    <select
        id="x_Confidentiality"
        name="x_Confidentiality"
        class="form-control ew-select<?= $Page->Confidentiality->isInvalidClass() ?>"
        data-select2-id="threats_x_Confidentiality"
        data-table="threats"
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
    var el = document.querySelector("select[data-select2-id='threats_x_Confidentiality']"),
        options = { name: "x_Confidentiality", selectId: "threats_x_Confidentiality", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.threats.fields.Confidentiality.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.threats.fields.Confidentiality.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Integrity->Visible) { // Integrity ?>
    <div id="r_Integrity" class="form-group row">
        <label id="elh_threats_Integrity" for="x_Integrity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Integrity->caption() ?><?= $Page->Integrity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Integrity->cellAttributes() ?>>
<span id="el_threats_Integrity">
    <select
        id="x_Integrity"
        name="x_Integrity"
        class="form-control ew-select<?= $Page->Integrity->isInvalidClass() ?>"
        data-select2-id="threats_x_Integrity"
        data-table="threats"
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
    var el = document.querySelector("select[data-select2-id='threats_x_Integrity']"),
        options = { name: "x_Integrity", selectId: "threats_x_Integrity", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.threats.fields.Integrity.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.threats.fields.Integrity.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Availability->Visible) { // Availability ?>
    <div id="r_Availability" class="form-group row">
        <label id="elh_threats_Availability" for="x_Availability" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Availability->caption() ?><?= $Page->Availability->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Availability->cellAttributes() ?>>
<span id="el_threats_Availability">
    <select
        id="x_Availability"
        name="x_Availability"
        class="form-control ew-select<?= $Page->Availability->isInvalidClass() ?>"
        data-select2-id="threats_x_Availability"
        data-table="threats"
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
    var el = document.querySelector("select[data-select2-id='threats_x_Availability']"),
        options = { name: "x_Availability", selectId: "threats_x_Availability", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.threats.fields.Availability.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.threats.fields.Availability.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Efficiency->Visible) { // Efficiency ?>
    <div id="r_Efficiency" class="form-group row">
        <label id="elh_threats_Efficiency" for="x_Efficiency" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Efficiency->caption() ?><?= $Page->Efficiency->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Efficiency->cellAttributes() ?>>
<span id="el_threats_Efficiency">
    <select
        id="x_Efficiency"
        name="x_Efficiency"
        class="form-control ew-select<?= $Page->Efficiency->isInvalidClass() ?>"
        data-select2-id="threats_x_Efficiency"
        data-table="threats"
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
    var el = document.querySelector("select[data-select2-id='threats_x_Efficiency']"),
        options = { name: "x_Efficiency", selectId: "threats_x_Efficiency", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.threats.fields.Efficiency.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.threats.fields.Efficiency.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_threats_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_threats_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="threats" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fthreatsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fthreatsadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_threats_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_threats_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="threats" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fthreatsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fthreatsadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
    ew.addEventHandlers("threats");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
