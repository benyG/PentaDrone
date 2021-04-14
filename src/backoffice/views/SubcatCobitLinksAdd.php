<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$SubcatCobitLinksAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsubcat_cobit_linksadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsubcat_cobit_linksadd = currentForm = new ew.Form("fsubcat_cobit_linksadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subcat_cobit_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subcat_cobit_links)
        ew.vars.tables.subcat_cobit_links = currentTable;
    fsubcat_cobit_linksadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["subcat_id", [fields.subcat_id.visible && fields.subcat_id.required ? ew.Validators.required(fields.subcat_id.caption) : null], fields.subcat_id.isInvalid],
        ["cobitrefs_id", [fields.cobitrefs_id.visible && fields.cobitrefs_id.required ? ew.Validators.required(fields.cobitrefs_id.caption) : null], fields.cobitrefs_id.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubcat_cobit_linksadd,
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
    fsubcat_cobit_linksadd.validate = function () {
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
    fsubcat_cobit_linksadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubcat_cobit_linksadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsubcat_cobit_linksadd.lists.subcat_id = <?= $Page->subcat_id->toClientList($Page) ?>;
    fsubcat_cobit_linksadd.lists.cobitrefs_id = <?= $Page->cobitrefs_id->toClientList($Page) ?>;
    loadjs.done("fsubcat_cobit_linksadd");
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
<form name="fsubcat_cobit_linksadd" id="fsubcat_cobit_linksadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subcat_cobit_links">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "cobit5_refs") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cobit5_refs">
<input type="hidden" name="fk_NIdentifier" value="<?= HtmlEncode($Page->cobitrefs_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "sub_categories") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sub_categories">
<input type="hidden" name="fk_code_nist" value="<?= HtmlEncode($Page->subcat_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_subcat_cobit_links_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_subcat_cobit_links_id">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="subcat_cobit_links" data-field="x_id" name="x_id" id="x_id" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
    <div id="r_subcat_id" class="form-group row">
        <label id="elh_subcat_cobit_links_subcat_id" for="x_subcat_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subcat_id->caption() ?><?= $Page->subcat_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->subcat_id->cellAttributes() ?>>
<?php if ($Page->subcat_id->getSessionValue() != "") { ?>
<span id="el_subcat_cobit_links_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subcat_id->getDisplayValue($Page->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_subcat_id" name="x_subcat_id" value="<?= HtmlEncode($Page->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_cobit_links_subcat_id">
    <select
        id="x_subcat_id"
        name="x_subcat_id"
        class="form-control ew-select<?= $Page->subcat_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x_subcat_id"
        data-table="subcat_cobit_links"
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
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x_subcat_id']"),
        options = { name: "x_subcat_id", selectId: "subcat_cobit_links_x_subcat_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.subcat_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cobitrefs_id->Visible) { // cobitrefs_id ?>
    <div id="r_cobitrefs_id" class="form-group row">
        <label id="elh_subcat_cobit_links_cobitrefs_id" for="x_cobitrefs_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cobitrefs_id->caption() ?><?= $Page->cobitrefs_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->cobitrefs_id->cellAttributes() ?>>
<?php if ($Page->cobitrefs_id->getSessionValue() != "") { ?>
<span id="el_subcat_cobit_links_cobitrefs_id">
<span<?= $Page->cobitrefs_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cobitrefs_id->getDisplayValue($Page->cobitrefs_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_cobitrefs_id" name="x_cobitrefs_id" value="<?= HtmlEncode($Page->cobitrefs_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_cobit_links_cobitrefs_id">
    <select
        id="x_cobitrefs_id"
        name="x_cobitrefs_id"
        class="form-control ew-select<?= $Page->cobitrefs_id->isInvalidClass() ?>"
        data-select2-id="subcat_cobit_links_x_cobitrefs_id"
        data-table="subcat_cobit_links"
        data-field="x_cobitrefs_id"
        data-value-separator="<?= $Page->cobitrefs_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cobitrefs_id->getPlaceHolder()) ?>"
        <?= $Page->cobitrefs_id->editAttributes() ?>>
        <?= $Page->cobitrefs_id->selectOptionListHtml("x_cobitrefs_id") ?>
    </select>
    <?= $Page->cobitrefs_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cobitrefs_id->getErrorMessage() ?></div>
<?= $Page->cobitrefs_id->Lookup->getParamTag($Page, "p_x_cobitrefs_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_cobit_links_x_cobitrefs_id']"),
        options = { name: "x_cobitrefs_id", selectId: "subcat_cobit_links_x_cobitrefs_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_cobit_links.fields.cobitrefs_id.selectOptions);
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
        <label id="elh_subcat_cobit_links_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_subcat_cobit_links_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="subcat_cobit_links" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsubcat_cobit_linksadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsubcat_cobit_linksadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_subcat_cobit_links_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_subcat_cobit_links_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="subcat_cobit_links" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsubcat_cobit_linksadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsubcat_cobit_linksadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
    ew.addEventHandlers("subcat_cobit_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
