<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$CisRefsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcis_refsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fcis_refsadd = currentForm = new ew.Form("fcis_refsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "cis_refs")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.cis_refs)
        ew.vars.tables.cis_refs = currentTable;
    fcis_refsadd.addFields([
        ["Nidentifier", [fields.Nidentifier.visible && fields.Nidentifier.required ? ew.Validators.required(fields.Nidentifier.caption) : null], fields.Nidentifier.isInvalid],
        ["Control_Family_id", [fields.Control_Family_id.visible && fields.Control_Family_id.required ? ew.Validators.required(fields.Control_Family_id.caption) : null], fields.Control_Family_id.isInvalid],
        ["control_Name", [fields.control_Name.visible && fields.control_Name.required ? ew.Validators.required(fields.control_Name.caption) : null], fields.control_Name.isInvalid],
        ["control_description", [fields.control_description.visible && fields.control_description.required ? ew.Validators.required(fields.control_description.caption) : null], fields.control_description.isInvalid],
        ["impl_group1", [fields.impl_group1.visible && fields.impl_group1.required ? ew.Validators.required(fields.impl_group1.caption) : null], fields.impl_group1.isInvalid],
        ["impl_group2", [fields.impl_group2.visible && fields.impl_group2.required ? ew.Validators.required(fields.impl_group2.caption) : null], fields.impl_group2.isInvalid],
        ["impl_group3", [fields.impl_group3.visible && fields.impl_group3.required ? ew.Validators.required(fields.impl_group3.caption) : null], fields.impl_group3.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcis_refsadd,
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
    fcis_refsadd.validate = function () {
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
    fcis_refsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcis_refsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcis_refsadd");
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
<form name="fcis_refsadd" id="fcis_refsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cis_refs">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "cis_refs_controlfamily") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cis_refs_controlfamily">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->Control_Family_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->Nidentifier->Visible) { // Nidentifier ?>
    <div id="r_Nidentifier" class="form-group row">
        <label id="elh_cis_refs_Nidentifier" for="x_Nidentifier" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nidentifier->caption() ?><?= $Page->Nidentifier->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Nidentifier->cellAttributes() ?>>
<span id="el_cis_refs_Nidentifier">
<input type="<?= $Page->Nidentifier->getInputTextType() ?>" data-table="cis_refs" data-field="x_Nidentifier" name="x_Nidentifier" id="x_Nidentifier" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->Nidentifier->getPlaceHolder()) ?>" value="<?= $Page->Nidentifier->EditValue ?>"<?= $Page->Nidentifier->editAttributes() ?> aria-describedby="x_Nidentifier_help">
<?= $Page->Nidentifier->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nidentifier->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Control_Family_id->Visible) { // Control_Family_id ?>
    <div id="r_Control_Family_id" class="form-group row">
        <label id="elh_cis_refs_Control_Family_id" for="x_Control_Family_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Control_Family_id->caption() ?><?= $Page->Control_Family_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Control_Family_id->cellAttributes() ?>>
<?php if ($Page->Control_Family_id->getSessionValue() != "") { ?>
<span id="el_cis_refs_Control_Family_id">
<span<?= $Page->Control_Family_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Control_Family_id->getDisplayValue($Page->Control_Family_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_Control_Family_id" name="x_Control_Family_id" value="<?= HtmlEncode($Page->Control_Family_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_cis_refs_Control_Family_id">
<input type="<?= $Page->Control_Family_id->getInputTextType() ?>" data-table="cis_refs" data-field="x_Control_Family_id" name="x_Control_Family_id" id="x_Control_Family_id" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->Control_Family_id->getPlaceHolder()) ?>" value="<?= $Page->Control_Family_id->EditValue ?>"<?= $Page->Control_Family_id->editAttributes() ?> aria-describedby="x_Control_Family_id_help">
<?= $Page->Control_Family_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Control_Family_id->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_Name->Visible) { // control_Name ?>
    <div id="r_control_Name" class="form-group row">
        <label id="elh_cis_refs_control_Name" for="x_control_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_Name->caption() ?><?= $Page->control_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_Name->cellAttributes() ?>>
<span id="el_cis_refs_control_Name">
<input type="<?= $Page->control_Name->getInputTextType() ?>" data-table="cis_refs" data-field="x_control_Name" name="x_control_Name" id="x_control_Name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->control_Name->getPlaceHolder()) ?>" value="<?= $Page->control_Name->EditValue ?>"<?= $Page->control_Name->editAttributes() ?> aria-describedby="x_control_Name_help">
<?= $Page->control_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_description->Visible) { // control_description ?>
    <div id="r_control_description" class="form-group row">
        <label id="elh_cis_refs_control_description" for="x_control_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_description->caption() ?><?= $Page->control_description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_description->cellAttributes() ?>>
<span id="el_cis_refs_control_description">
<textarea data-table="cis_refs" data-field="x_control_description" name="x_control_description" id="x_control_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->control_description->getPlaceHolder()) ?>"<?= $Page->control_description->editAttributes() ?> aria-describedby="x_control_description_help"><?= $Page->control_description->EditValue ?></textarea>
<?= $Page->control_description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impl_group1->Visible) { // impl_group1 ?>
    <div id="r_impl_group1" class="form-group row">
        <label id="elh_cis_refs_impl_group1" for="x_impl_group1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impl_group1->caption() ?><?= $Page->impl_group1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->impl_group1->cellAttributes() ?>>
<span id="el_cis_refs_impl_group1">
<input type="<?= $Page->impl_group1->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group1" name="x_impl_group1" id="x_impl_group1" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->impl_group1->getPlaceHolder()) ?>" value="<?= $Page->impl_group1->EditValue ?>"<?= $Page->impl_group1->editAttributes() ?> aria-describedby="x_impl_group1_help">
<?= $Page->impl_group1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->impl_group1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impl_group2->Visible) { // impl_group2 ?>
    <div id="r_impl_group2" class="form-group row">
        <label id="elh_cis_refs_impl_group2" for="x_impl_group2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impl_group2->caption() ?><?= $Page->impl_group2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->impl_group2->cellAttributes() ?>>
<span id="el_cis_refs_impl_group2">
<input type="<?= $Page->impl_group2->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group2" name="x_impl_group2" id="x_impl_group2" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->impl_group2->getPlaceHolder()) ?>" value="<?= $Page->impl_group2->EditValue ?>"<?= $Page->impl_group2->editAttributes() ?> aria-describedby="x_impl_group2_help">
<?= $Page->impl_group2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->impl_group2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impl_group3->Visible) { // impl_group3 ?>
    <div id="r_impl_group3" class="form-group row">
        <label id="elh_cis_refs_impl_group3" for="x_impl_group3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impl_group3->caption() ?><?= $Page->impl_group3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->impl_group3->cellAttributes() ?>>
<span id="el_cis_refs_impl_group3">
<input type="<?= $Page->impl_group3->getInputTextType() ?>" data-table="cis_refs" data-field="x_impl_group3" name="x_impl_group3" id="x_impl_group3" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->impl_group3->getPlaceHolder()) ?>" value="<?= $Page->impl_group3->EditValue ?>"<?= $Page->impl_group3->editAttributes() ?> aria-describedby="x_impl_group3_help">
<?= $Page->impl_group3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->impl_group3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("subcat_cis_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_cis_links->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_cis_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatCisLinksGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("cis_refs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
