<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$SubcatQuestionLinksAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsubcat_question_linksadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsubcat_question_linksadd = currentForm = new ew.Form("fsubcat_question_linksadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subcat_question_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subcat_question_links)
        ew.vars.tables.subcat_question_links = currentTable;
    fsubcat_question_linksadd.addFields([
        ["questions_id", [fields.questions_id.visible && fields.questions_id.required ? ew.Validators.required(fields.questions_id.caption) : null], fields.questions_id.isInvalid],
        ["subcat_id", [fields.subcat_id.visible && fields.subcat_id.required ? ew.Validators.required(fields.subcat_id.caption) : null], fields.subcat_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubcat_question_linksadd,
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
    fsubcat_question_linksadd.validate = function () {
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
    fsubcat_question_linksadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubcat_question_linksadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsubcat_question_linksadd");
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
<form name="fsubcat_question_linksadd" id="fsubcat_question_linksadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subcat_question_links">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "questions_library") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="questions_library">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->questions_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "sub_categories") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sub_categories">
<input type="hidden" name="fk_code_nist" value="<?= HtmlEncode($Page->subcat_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->questions_id->Visible) { // questions_id ?>
    <div id="r_questions_id" class="form-group row">
        <label id="elh_subcat_question_links_questions_id" for="x_questions_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->questions_id->caption() ?><?= $Page->questions_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->questions_id->cellAttributes() ?>>
<?php if ($Page->questions_id->getSessionValue() != "") { ?>
<span id="el_subcat_question_links_questions_id">
<span<?= $Page->questions_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->questions_id->getDisplayValue($Page->questions_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_questions_id" name="x_questions_id" value="<?= HtmlEncode($Page->questions_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_question_links_questions_id">
<input type="<?= $Page->questions_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_questions_id" name="x_questions_id" id="x_questions_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->questions_id->getPlaceHolder()) ?>" value="<?= $Page->questions_id->EditValue ?>"<?= $Page->questions_id->editAttributes() ?> aria-describedby="x_questions_id_help">
<?= $Page->questions_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->questions_id->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subcat_id->Visible) { // subcat_id ?>
    <div id="r_subcat_id" class="form-group row">
        <label id="elh_subcat_question_links_subcat_id" for="x_subcat_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subcat_id->caption() ?><?= $Page->subcat_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->subcat_id->cellAttributes() ?>>
<?php if ($Page->subcat_id->getSessionValue() != "") { ?>
<span id="el_subcat_question_links_subcat_id">
<span<?= $Page->subcat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subcat_id->getDisplayValue($Page->subcat_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_subcat_id" name="x_subcat_id" value="<?= HtmlEncode($Page->subcat_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subcat_question_links_subcat_id">
<input type="<?= $Page->subcat_id->getInputTextType() ?>" data-table="subcat_question_links" data-field="x_subcat_id" name="x_subcat_id" id="x_subcat_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->subcat_id->getPlaceHolder()) ?>" value="<?= $Page->subcat_id->EditValue ?>"<?= $Page->subcat_id->editAttributes() ?> aria-describedby="x_subcat_id_help">
<?= $Page->subcat_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subcat_id->getErrorMessage() ?></div>
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
    ew.addEventHandlers("subcat_question_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
