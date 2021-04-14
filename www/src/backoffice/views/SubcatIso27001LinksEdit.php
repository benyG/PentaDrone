<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubcatIso27001LinksEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsubcat_iso27001_linksedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fsubcat_iso27001_linksedit = currentForm = new ew.Form("fsubcat_iso27001_linksedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subcat_iso27001_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subcat_iso27001_links)
        ew.vars.tables.subcat_iso27001_links = currentTable;
    fsubcat_iso27001_linksedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["iso27001_code", [fields.iso27001_code.visible && fields.iso27001_code.required ? ew.Validators.required(fields.iso27001_code.caption) : null], fields.iso27001_code.isInvalid],
        ["subcat_id", [fields.subcat_id.visible && fields.subcat_id.required ? ew.Validators.required(fields.subcat_id.caption) : null], fields.subcat_id.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubcat_iso27001_linksedit,
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
    fsubcat_iso27001_linksedit.validate = function () {
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
    fsubcat_iso27001_linksedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubcat_iso27001_linksedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsubcat_iso27001_linksedit.lists.iso27001_code = <?= $Page->iso27001_code->toClientList($Page) ?>;
    fsubcat_iso27001_linksedit.lists.subcat_id = <?= $Page->subcat_id->toClientList($Page) ?>;
    loadjs.done("fsubcat_iso27001_linksedit");
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
<?php if (!$Page->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fsubcat_iso27001_linksedit" id="fsubcat_iso27001_linksedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subcat_iso27001_links">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "iso27001_refs") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="iso27001_refs">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->iso27001_code->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "sub_categories") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sub_categories">
<input type="hidden" name="fk_code_nist" value="<?= HtmlEncode($Page->subcat_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_subcat_iso27001_links_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_subcat_iso27001_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="subcat_iso27001_links" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->iso27001_code->Visible) { // iso27001_code ?>
    <div id="r_iso27001_code" class="form-group row">
        <label id="elh_subcat_iso27001_links_iso27001_code" for="x_iso27001_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iso27001_code->caption() ?><?= $Page->iso27001_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->iso27001_code->cellAttributes() ?>>
<?php if ($Page->iso27001_code->getSessionValue() != "") { ?>
<span id="el_subcat_iso27001_links_iso27001_code">
<span<?= $Page->iso27001_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iso27001_code->getDisplayValue($Page->iso27001_code->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_iso27001_code" name="x_iso27001_code" value="<?= HtmlEncode($Page->iso27001_code->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_iso27001_links_iso27001_code">
    <select
        id="x_iso27001_code"
        name="x_iso27001_code"
        class="form-control ew-select<?= $Page->iso27001_code->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x_iso27001_code"
        data-table="subcat_iso27001_links"
        data-field="x_iso27001_code"
        data-value-separator="<?= $Page->iso27001_code->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->iso27001_code->getPlaceHolder()) ?>"
        <?= $Page->iso27001_code->editAttributes() ?>>
        <?= $Page->iso27001_code->selectOptionListHtml("x_iso27001_code") ?>
    </select>
    <?= $Page->iso27001_code->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->iso27001_code->getErrorMessage() ?></div>
<?= $Page->iso27001_code->Lookup->getParamTag($Page, "p_x_iso27001_code") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x_iso27001_code']"),
        options = { name: "x_iso27001_code", selectId: "subcat_iso27001_links_x_iso27001_code", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.iso27001_code.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
    <div id="r_subcat_id" class="form-group row">
        <label id="elh_subcat_iso27001_links_subcat_id" for="x_subcat_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subcat_id->caption() ?><?= $Page->subcat_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->subcat_id->cellAttributes() ?>>
<?php if ($Page->subcat_id->getSessionValue() != "") { ?>
<span id="el_subcat_iso27001_links_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subcat_id->getDisplayValue($Page->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_subcat_id" name="x_subcat_id" value="<?= HtmlEncode($Page->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_iso27001_links_subcat_id">
    <select
        id="x_subcat_id"
        name="x_subcat_id"
        class="form-control ew-select<?= $Page->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_iso27001_links_x_subcat_id"
        data-table="subcat_iso27001_links"
        data-field="x_subcat_id"
        data-value-separator="<?= $Page->subcat_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subcat_id->getPlaceHolder()) ?>"
        <?= $Page->subcat_id->editAttributes() ?>>
        <?= $Page->subcat_id->selectOptionListHtml("x_subcat_id") ?>
    </select>
    <?= $Page->subcat_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->subcat_id->getErrorMessage() ?></div>
<?= $Page->subcat_id->Lookup->getParamTag($Page, "p_x_subcat_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_iso27001_links_x_subcat_id']"),
        options = { name: "x_subcat_id", selectId: "subcat_iso27001_links_x_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_iso27001_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_subcat_iso27001_links_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_subcat_iso27001_links_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="subcat_iso27001_links" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsubcat_iso27001_linksedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fsubcat_iso27001_linksedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_subcat_iso27001_links_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_subcat_iso27001_links_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="subcat_iso27001_links" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsubcat_iso27001_linksedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fsubcat_iso27001_linksedit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("subcat_iso27001_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
