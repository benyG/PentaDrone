<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$CisQuestionLinksAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcis_question_linksadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fcis_question_linksadd = currentForm = new ew.Form("fcis_question_linksadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "cis_question_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.cis_question_links)
        ew.vars.tables.cis_question_links = currentTable;
    fcis_question_linksadd.addFields([
        ["question_foreign_id", [fields.question_foreign_id.visible && fields.question_foreign_id.required ? ew.Validators.required(fields.question_foreign_id.caption) : null, ew.Validators.integer], fields.question_foreign_id.isInvalid],
        ["cisrefs_id", [fields.cisrefs_id.visible && fields.cisrefs_id.required ? ew.Validators.required(fields.cisrefs_id.caption) : null], fields.cisrefs_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcis_question_linksadd,
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
    fcis_question_linksadd.validate = function () {
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
    fcis_question_linksadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcis_question_linksadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcis_question_linksadd");
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
<form name="fcis_question_linksadd" id="fcis_question_linksadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cis_question_links">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->question_foreign_id->Visible) { // question_foreign_id ?>
    <div id="r_question_foreign_id" class="form-group row">
        <label id="elh_cis_question_links_question_foreign_id" for="x_question_foreign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->question_foreign_id->caption() ?><?= $Page->question_foreign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->question_foreign_id->cellAttributes() ?>>
<span id="el_cis_question_links_question_foreign_id">
<input type="<?= $Page->question_foreign_id->getInputTextType() ?>" data-table="cis_question_links" data-field="x_question_foreign_id" name="x_question_foreign_id" id="x_question_foreign_id" size="30" placeholder="<?= HtmlEncode($Page->question_foreign_id->getPlaceHolder()) ?>" value="<?= $Page->question_foreign_id->EditValue ?>"<?= $Page->question_foreign_id->editAttributes() ?> aria-describedby="x_question_foreign_id_help">
<?= $Page->question_foreign_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->question_foreign_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cisrefs_id->Visible) { // cisrefs_id ?>
    <div id="r_cisrefs_id" class="form-group row">
        <label id="elh_cis_question_links_cisrefs_id" for="x_cisrefs_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cisrefs_id->caption() ?><?= $Page->cisrefs_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->cisrefs_id->cellAttributes() ?>>
<span id="el_cis_question_links_cisrefs_id">
<input type="<?= $Page->cisrefs_id->getInputTextType() ?>" data-table="cis_question_links" data-field="x_cisrefs_id" name="x_cisrefs_id" id="x_cisrefs_id" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->cisrefs_id->getPlaceHolder()) ?>" value="<?= $Page->cisrefs_id->EditValue ?>"<?= $Page->cisrefs_id->editAttributes() ?> aria-describedby="x_cisrefs_id_help">
<?= $Page->cisrefs_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cisrefs_id->getErrorMessage() ?></div>
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
    ew.addEventHandlers("cis_question_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
