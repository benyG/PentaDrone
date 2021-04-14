<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$NistRefsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnist_refsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnist_refsadd = currentForm = new ew.Form("fnist_refsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "nist_refs")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.nist_refs)
        ew.vars.tables.nist_refs = currentTable;
    fnist_refsadd.addFields([
        ["Nidentifier", [fields.Nidentifier.visible && fields.Nidentifier.required ? ew.Validators.required(fields.Nidentifier.caption) : null], fields.Nidentifier.isInvalid],
        ["N_ordre", [fields.N_ordre.visible && fields.N_ordre.required ? ew.Validators.required(fields.N_ordre.caption) : null, ew.Validators.integer], fields.N_ordre.isInvalid],
        ["Control_Family_id", [fields.Control_Family_id.visible && fields.Control_Family_id.required ? ew.Validators.required(fields.Control_Family_id.caption) : null], fields.Control_Family_id.isInvalid],
        ["Control_Name", [fields.Control_Name.visible && fields.Control_Name.required ? ew.Validators.required(fields.Control_Name.caption) : null], fields.Control_Name.isInvalid],
        ["control_description", [fields.control_description.visible && fields.control_description.required ? ew.Validators.required(fields.control_description.caption) : null], fields.control_description.isInvalid],
        ["discussion", [fields.discussion.visible && fields.discussion.required ? ew.Validators.required(fields.discussion.caption) : null], fields.discussion.isInvalid],
        ["related_controls", [fields.related_controls.visible && fields.related_controls.required ? ew.Validators.required(fields.related_controls.caption) : null], fields.related_controls.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnist_refsadd,
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
    fnist_refsadd.validate = function () {
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
    fnist_refsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnist_refsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnist_refsadd");
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
<form name="fnist_refsadd" id="fnist_refsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nist_refs">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "nist_refs_controlfamily") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nist_refs_controlfamily">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->Control_Family_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
    <div id="r_Nidentifier" class="form-group row">
        <label id="elh_nist_refs_Nidentifier" for="x_Nidentifier" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nidentifier->caption() ?><?= $Page->Nidentifier->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Nidentifier->cellAttributes() ?>>
<span id="el_nist_refs_Nidentifier">
<input type="<?= $Page->Nidentifier->getInputTextType() ?>" data-table="nist_refs" data-field="x_Nidentifier" name="x_Nidentifier" id="x_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->Nidentifier->getPlaceHolder()) ?>" value="<?= $Page->Nidentifier->EditValue ?>"<?= $Page->Nidentifier->editAttributes() ?> aria-describedby="x_Nidentifier_help">
<?= $Page->Nidentifier->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nidentifier->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->N_ordre->Visible) { // N_ordre ?>
    <div id="r_N_ordre" class="form-group row">
        <label id="elh_nist_refs_N_ordre" for="x_N_ordre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->N_ordre->caption() ?><?= $Page->N_ordre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->N_ordre->cellAttributes() ?>>
<span id="el_nist_refs_N_ordre">
<input type="<?= $Page->N_ordre->getInputTextType() ?>" data-table="nist_refs" data-field="x_N_ordre" name="x_N_ordre" id="x_N_ordre" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->N_ordre->getPlaceHolder()) ?>" value="<?= $Page->N_ordre->EditValue ?>"<?= $Page->N_ordre->editAttributes() ?> aria-describedby="x_N_ordre_help">
<?= $Page->N_ordre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->N_ordre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
    <div id="r_Control_Family_id" class="form-group row">
        <label id="elh_nist_refs_Control_Family_id" for="x_Control_Family_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Control_Family_id->caption() ?><?= $Page->Control_Family_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Control_Family_id->cellAttributes() ?>>
<?php if ($Page->Control_Family_id->getSessionValue() != "") { ?>
<span id="el_nist_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Control_Family_id->getDisplayValue($Page->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_Control_Family_id" name="x_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_nist_refs_Control_Family_id">
<input type="<?= $Page->Control_Family_id->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Family_id" name="x_Control_Family_id" id="x_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Page->Control_Family_id->EditValue ?>"<?= $Page->Control_Family_id->editAttributes() ?> aria-describedby="x_Control_Family_id_help">
<?= $Page->Control_Family_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Control_Name->Visible) { // Control_Name ?>
    <div id="r_Control_Name" class="form-group row">
        <label id="elh_nist_refs_Control_Name" for="x_Control_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Control_Name->caption() ?><?= $Page->Control_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Control_Name->cellAttributes() ?>>
<span id="el_nist_refs_Control_Name">
<input type="<?= $Page->Control_Name->getInputTextType() ?>" data-table="nist_refs" data-field="x_Control_Name" name="x_Control_Name" id="x_Control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Control_Name->getPlaceHolder()) ?>" value="<?= $Page->Control_Name->EditValue ?>"<?= $Page->Control_Name->editAttributes() ?> aria-describedby="x_Control_Name_help">
<?= $Page->Control_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Control_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_description->Visible) { // control_description ?>
    <div id="r_control_description" class="form-group row">
        <label id="elh_nist_refs_control_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_description->caption() ?><?= $Page->control_description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_description->cellAttributes() ?>>
<span id="el_nist_refs_control_description">
<?php $Page->control_description->EditAttrs->appendClass("editor"); ?>
<textarea data-table="nist_refs" data-field="x_control_description" name="x_control_description" id="x_control_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->control_description->getPlaceHolder()) ?>"<?= $Page->control_description->editAttributes() ?> aria-describedby="x_control_description_help"><?= $Page->control_description->EditValue ?></textarea>
<?= $Page->control_description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_description->getErrorMessage() ?></div>
<script>
loadjs.ready(["fnist_refsadd", "editor"], function() {
	ew.createEditor("fnist_refsadd", "x_control_description", 35, 4, <?= $Page->control_description->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->discussion->Visible) { // discussion ?>
    <div id="r_discussion" class="form-group row">
        <label id="elh_nist_refs_discussion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->discussion->caption() ?><?= $Page->discussion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->discussion->cellAttributes() ?>>
<span id="el_nist_refs_discussion">
<?php $Page->discussion->EditAttrs->appendClass("editor"); ?>
<textarea data-table="nist_refs" data-field="x_discussion" name="x_discussion" id="x_discussion" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->discussion->getPlaceHolder()) ?>"<?= $Page->discussion->editAttributes() ?> aria-describedby="x_discussion_help"><?= $Page->discussion->EditValue ?></textarea>
<?= $Page->discussion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->discussion->getErrorMessage() ?></div>
<script>
loadjs.ready(["fnist_refsadd", "editor"], function() {
	ew.createEditor("fnist_refsadd", "x_discussion", 35, 4, <?= $Page->discussion->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->related_controls->Visible) { // related_controls ?>
    <div id="r_related_controls" class="form-group row">
        <label id="elh_nist_refs_related_controls" for="x_related_controls" class="<?= $Page->LeftColumnClass ?>"><?= $Page->related_controls->caption() ?><?= $Page->related_controls->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->related_controls->cellAttributes() ?>>
<span id="el_nist_refs_related_controls">
<textarea data-table="nist_refs" data-field="x_related_controls" name="x_related_controls" id="x_related_controls" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->related_controls->getPlaceHolder()) ?>"<?= $Page->related_controls->editAttributes() ?> aria-describedby="x_related_controls_help"><?= $Page->related_controls->EditValue ?></textarea>
<?= $Page->related_controls->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->related_controls->getErrorMessage() ?></div>
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
    ew.addEventHandlers("nist_refs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
