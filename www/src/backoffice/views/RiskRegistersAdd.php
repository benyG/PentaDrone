<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$RiskRegistersAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var frisk_registersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    frisk_registersadd = currentForm = new ew.Form("frisk_registersadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "risk_registers")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.risk_registers)
        ew.vars.tables.risk_registers = currentTable;
    frisk_registersadd.addFields([
        ["risk", [fields.risk.visible && fields.risk.required ? ew.Validators.required(fields.risk.caption) : null], fields.risk.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid],
        ["vulnerability", [fields.vulnerability.visible && fields.vulnerability.required ? ew.Validators.required(fields.vulnerability.caption) : null], fields.vulnerability.isInvalid],
        ["threat", [fields.threat.visible && fields.threat.required ? ew.Validators.required(fields.threat.caption) : null], fields.threat.isInvalid],
        ["layer_code", [fields.layer_code.visible && fields.layer_code.required ? ew.Validators.required(fields.layer_code.caption) : null], fields.layer_code.isInvalid],
        ["exposure_factor_EF", [fields.exposure_factor_EF.visible && fields.exposure_factor_EF.required ? ew.Validators.required(fields.exposure_factor_EF.caption) : null, ew.Validators.integer], fields.exposure_factor_EF.isInvalid],
        ["asset", [fields.asset.visible && fields.asset.required ? ew.Validators.required(fields.asset.caption) : null], fields.asset.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = frisk_registersadd,
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
    frisk_registersadd.validate = function () {
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
    frisk_registersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    frisk_registersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("frisk_registersadd");
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
<form name="frisk_registersadd" id="frisk_registersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_registers">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->risk->Visible) { // risk ?>
    <div id="r_risk" class="form-group row">
        <label id="elh_risk_registers_risk" for="x_risk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->risk->caption() ?><?= $Page->risk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->risk->cellAttributes() ?>>
<span id="el_risk_registers_risk">
<textarea data-table="risk_registers" data-field="x_risk" name="x_risk" id="x_risk" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->risk->getPlaceHolder()) ?>"<?= $Page->risk->editAttributes() ?> aria-describedby="x_risk_help"><?= $Page->risk->EditValue ?></textarea>
<?= $Page->risk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->risk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_risk_registers_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_risk_registers_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="risk_registers" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frisk_registersadd", "datetimepicker"], function() {
    ew.createDateTimePicker("frisk_registersadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_risk_registers_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_risk_registers_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="risk_registers" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frisk_registersadd", "datetimepicker"], function() {
    ew.createDateTimePicker("frisk_registersadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vulnerability->Visible) { // vulnerability ?>
    <div id="r_vulnerability" class="form-group row">
        <label id="elh_risk_registers_vulnerability" for="x_vulnerability" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vulnerability->caption() ?><?= $Page->vulnerability->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->vulnerability->cellAttributes() ?>>
<span id="el_risk_registers_vulnerability">
<input type="<?= $Page->vulnerability->getInputTextType() ?>" data-table="risk_registers" data-field="x_vulnerability" name="x_vulnerability" id="x_vulnerability" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->vulnerability->getPlaceHolder()) ?>" value="<?= $Page->vulnerability->EditValue ?>"<?= $Page->vulnerability->editAttributes() ?> aria-describedby="x_vulnerability_help">
<?= $Page->vulnerability->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vulnerability->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->threat->Visible) { // threat ?>
    <div id="r_threat" class="form-group row">
        <label id="elh_risk_registers_threat" for="x_threat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->threat->caption() ?><?= $Page->threat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->threat->cellAttributes() ?>>
<span id="el_risk_registers_threat">
<input type="<?= $Page->threat->getInputTextType() ?>" data-table="risk_registers" data-field="x_threat" name="x_threat" id="x_threat" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->threat->getPlaceHolder()) ?>" value="<?= $Page->threat->EditValue ?>"<?= $Page->threat->editAttributes() ?> aria-describedby="x_threat_help">
<?= $Page->threat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->threat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->layer_code->Visible) { // layer_code ?>
    <div id="r_layer_code" class="form-group row">
        <label id="elh_risk_registers_layer_code" for="x_layer_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->layer_code->caption() ?><?= $Page->layer_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->layer_code->cellAttributes() ?>>
<span id="el_risk_registers_layer_code">
<input type="<?= $Page->layer_code->getInputTextType() ?>" data-table="risk_registers" data-field="x_layer_code" name="x_layer_code" id="x_layer_code" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->layer_code->getPlaceHolder()) ?>" value="<?= $Page->layer_code->EditValue ?>"<?= $Page->layer_code->editAttributes() ?> aria-describedby="x_layer_code_help">
<?= $Page->layer_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->layer_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->exposure_factor_EF->Visible) { // exposure_factor_EF ?>
    <div id="r_exposure_factor_EF" class="form-group row">
        <label id="elh_risk_registers_exposure_factor_EF" for="x_exposure_factor_EF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->exposure_factor_EF->caption() ?><?= $Page->exposure_factor_EF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->exposure_factor_EF->cellAttributes() ?>>
<span id="el_risk_registers_exposure_factor_EF">
<input type="<?= $Page->exposure_factor_EF->getInputTextType() ?>" data-table="risk_registers" data-field="x_exposure_factor_EF" name="x_exposure_factor_EF" id="x_exposure_factor_EF" size="30" placeholder="<?= HtmlEncode($Page->exposure_factor_EF->getPlaceHolder()) ?>" value="<?= $Page->exposure_factor_EF->EditValue ?>"<?= $Page->exposure_factor_EF->editAttributes() ?> aria-describedby="x_exposure_factor_EF_help">
<?= $Page->exposure_factor_EF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->exposure_factor_EF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset->Visible) { // asset ?>
    <div id="r_asset" class="form-group row">
        <label id="elh_risk_registers_asset" for="x_asset" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset->caption() ?><?= $Page->asset->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->asset->cellAttributes() ?>>
<span id="el_risk_registers_asset">
<input type="<?= $Page->asset->getInputTextType() ?>" data-table="risk_registers" data-field="x_asset" name="x_asset" id="x_asset" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->asset->getPlaceHolder()) ?>" value="<?= $Page->asset->EditValue ?>"<?= $Page->asset->editAttributes() ?> aria-describedby="x_asset_help">
<?= $Page->asset->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset->getErrorMessage() ?></div>
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
    ew.addEventHandlers("risk_registers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
