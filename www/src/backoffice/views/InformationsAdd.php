<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$InformationsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var finformationsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    finformationsadd = currentForm = new ew.Form("finformationsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "informations")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.informations)
        ew.vars.tables.informations = currentTable;
    finformationsadd.addFields([
        ["people_id", [fields.people_id.visible && fields.people_id.required ? ew.Validators.required(fields.people_id.caption) : null, ew.Validators.integer], fields.people_id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["asset_value", [fields.asset_value.visible && fields.asset_value.required ? ew.Validators.required(fields.asset_value.caption) : null, ew.Validators.integer], fields.asset_value.isInvalid],
        ["business_value", [fields.business_value.visible && fields.business_value.required ? ew.Validators.required(fields.business_value.caption) : null], fields.business_value.isInvalid],
        ["criticality_points", [fields.criticality_points.visible && fields.criticality_points.required ? ew.Validators.required(fields.criticality_points.caption) : null, ew.Validators.integer], fields.criticality_points.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = finformationsadd,
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
    finformationsadd.validate = function () {
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
    finformationsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finformationsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("finformationsadd");
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
<form name="finformationsadd" id="finformationsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="informations">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->people_id->Visible) { // people_id ?>
    <div id="r_people_id" class="form-group row">
        <label id="elh_informations_people_id" for="x_people_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->people_id->caption() ?><?= $Page->people_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->people_id->cellAttributes() ?>>
<span id="el_informations_people_id">
<input type="<?= $Page->people_id->getInputTextType() ?>" data-table="informations" data-field="x_people_id" name="x_people_id" id="x_people_id" size="30" placeholder="<?= HtmlEncode($Page->people_id->getPlaceHolder()) ?>" value="<?= $Page->people_id->EditValue ?>"<?= $Page->people_id->editAttributes() ?> aria-describedby="x_people_id_help">
<?= $Page->people_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->people_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_informations_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_informations_name">
<textarea data-table="informations" data-field="x_name" name="x_name" id="x_name" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help"><?= $Page->name->EditValue ?></textarea>
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_informations_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<span id="el_informations_description">
<textarea data-table="informations" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_value->Visible) { // asset_value ?>
    <div id="r_asset_value" class="form-group row">
        <label id="elh_informations_asset_value" for="x_asset_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_value->caption() ?><?= $Page->asset_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->asset_value->cellAttributes() ?>>
<span id="el_informations_asset_value">
<input type="<?= $Page->asset_value->getInputTextType() ?>" data-table="informations" data-field="x_asset_value" name="x_asset_value" id="x_asset_value" size="30" placeholder="<?= HtmlEncode($Page->asset_value->getPlaceHolder()) ?>" value="<?= $Page->asset_value->EditValue ?>"<?= $Page->asset_value->editAttributes() ?> aria-describedby="x_asset_value_help">
<?= $Page->asset_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->business_value->Visible) { // business_value ?>
    <div id="r_business_value" class="form-group row">
        <label id="elh_informations_business_value" for="x_business_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->business_value->caption() ?><?= $Page->business_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->business_value->cellAttributes() ?>>
<span id="el_informations_business_value">
<input type="<?= $Page->business_value->getInputTextType() ?>" data-table="informations" data-field="x_business_value" name="x_business_value" id="x_business_value" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->business_value->getPlaceHolder()) ?>" value="<?= $Page->business_value->EditValue ?>"<?= $Page->business_value->editAttributes() ?> aria-describedby="x_business_value_help">
<?= $Page->business_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->business_value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->criticality_points->Visible) { // criticality_points ?>
    <div id="r_criticality_points" class="form-group row">
        <label id="elh_informations_criticality_points" for="x_criticality_points" class="<?= $Page->LeftColumnClass ?>"><?= $Page->criticality_points->caption() ?><?= $Page->criticality_points->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->criticality_points->cellAttributes() ?>>
<span id="el_informations_criticality_points">
<input type="<?= $Page->criticality_points->getInputTextType() ?>" data-table="informations" data-field="x_criticality_points" name="x_criticality_points" id="x_criticality_points" size="30" placeholder="<?= HtmlEncode($Page->criticality_points->getPlaceHolder()) ?>" value="<?= $Page->criticality_points->EditValue ?>"<?= $Page->criticality_points->editAttributes() ?> aria-describedby="x_criticality_points_help">
<?= $Page->criticality_points->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->criticality_points->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_informations_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_informations_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="informations" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finformationsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("finformationsadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_informations_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_informations_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="informations" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finformationsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("finformationsadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
    ew.addEventHandlers("informations");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
