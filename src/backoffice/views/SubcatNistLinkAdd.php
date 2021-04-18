<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$SubcatNistLinkAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsubcat_nist_linkadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsubcat_nist_linkadd = currentForm = new ew.Form("fsubcat_nist_linkadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subcat_nist_link")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subcat_nist_link)
        ew.vars.tables.subcat_nist_link = currentTable;
    fsubcat_nist_linkadd.addFields([
        ["subcat_id", [fields.subcat_id.visible && fields.subcat_id.required ? ew.Validators.required(fields.subcat_id.caption) : null, ew.Validators.integer], fields.subcat_id.isInvalid],
        ["nistrefs_id", [fields.nistrefs_id.visible && fields.nistrefs_id.required ? ew.Validators.required(fields.nistrefs_id.caption) : null], fields.nistrefs_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubcat_nist_linkadd,
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
    fsubcat_nist_linkadd.validate = function () {
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
    fsubcat_nist_linkadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubcat_nist_linkadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsubcat_nist_linkadd.lists.nistrefs_id = <?= $Page->nistrefs_id->toClientList($Page) ?>;
    loadjs.done("fsubcat_nist_linkadd");
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
<form name="fsubcat_nist_linkadd" id="fsubcat_nist_linkadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subcat_nist_link">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "nist_refs") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nist_refs">
<input type="hidden" name="fk_Nidentifier" value="<?= HtmlEncode($Page->nistrefs_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "sub_categories") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sub_categories">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->subcat_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
    <div id="r_subcat_id" class="form-group row">
        <label id="elh_subcat_nist_link_subcat_id" for="x_subcat_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subcat_id->caption() ?><?= $Page->subcat_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->subcat_id->cellAttributes() ?>>
<?php if ($Page->subcat_id->getSessionValue() != "") { ?>
<span id="el_subcat_nist_link_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subcat_id->getDisplayValue($Page->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_subcat_id" name="x_subcat_id" value="<?= HtmlEncode($Page->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_nist_link_subcat_id">
<input type="<?= $Page->subcat_id->getInputTextType() ?>" data-table="subcat_nist_link" data-field="x_subcat_id" name="x_subcat_id" id="x_subcat_id" size="30" placeholder="<?= HtmlEncode($Page->subcat_id->getPlaceHolder()) ?>" value="<?= $Page->subcat_id->EditValue ?>"<?= $Page->subcat_id->editAttributes() ?> aria-describedby="x_subcat_id_help">
<?= $Page->subcat_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subcat_id->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nistrefs_id->Visible) { // nistrefs_id ?>
    <div id="r_nistrefs_id" class="form-group row">
        <label id="elh_subcat_nist_link_nistrefs_id" for="x_nistrefs_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nistrefs_id->caption() ?><?= $Page->nistrefs_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nistrefs_id->cellAttributes() ?>>
<?php if ($Page->nistrefs_id->getSessionValue() != "") { ?>
<span id="el_subcat_nist_link_nistrefs_id">
<span<?= $Page->nistrefs_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nistrefs_id->getDisplayValue($Page->nistrefs_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_nistrefs_id" name="x_nistrefs_id" value="<?= HtmlEncode($Page->nistrefs_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_nist_link_nistrefs_id">
    <select
        id="x_nistrefs_id[]"
        name="x_nistrefs_id[]"
        class="form-control ew-select<?= $Page->nistrefs_id->isInvalidClass() ?>"
        data-select2-id="subcat_nist_link_x_nistrefs_id[]"
        data-table="subcat_nist_link"
        data-field="x_nistrefs_id"
        multiple
        size="1"
        data-value-separator="<?= $Page->nistrefs_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nistrefs_id->getPlaceHolder()) ?>"
        <?= $Page->nistrefs_id->editAttributes() ?>>
        <?= $Page->nistrefs_id->selectOptionListHtml("x_nistrefs_id[]") ?>
    </select>
    <?= $Page->nistrefs_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->nistrefs_id->getErrorMessage() ?></div>
<?= $Page->nistrefs_id->Lookup->getParamTag($Page, "p_x_nistrefs_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subcat_nist_link_x_nistrefs_id[]']"),
        options = { name: "x_nistrefs_id[]", selectId: "subcat_nist_link_x_nistrefs_id[]", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.multiple = true;
    options.closeOnSelect = false;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subcat_nist_link.fields.nistrefs_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
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
    ew.addEventHandlers("subcat_nist_link");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>