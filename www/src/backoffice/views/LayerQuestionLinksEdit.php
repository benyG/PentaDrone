<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$LayerQuestionLinksEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var flayer_question_linksedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    flayer_question_linksedit = currentForm = new ew.Form("flayer_question_linksedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "layer_question_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.layer_question_links)
        ew.vars.tables.layer_question_links = currentTable;
    flayer_question_linksedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["layer_foreign_id", [fields.layer_foreign_id.visible && fields.layer_foreign_id.required ? ew.Validators.required(fields.layer_foreign_id.caption) : null, ew.Validators.integer], fields.layer_foreign_id.isInvalid],
        ["question_foreign_id", [fields.question_foreign_id.visible && fields.question_foreign_id.required ? ew.Validators.required(fields.question_foreign_id.caption) : null], fields.question_foreign_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = flayer_question_linksedit,
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
    flayer_question_linksedit.validate = function () {
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
    flayer_question_linksedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flayer_question_linksedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("flayer_question_linksedit");
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
<form name="flayer_question_linksedit" id="flayer_question_linksedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="layer_question_links">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "questions_library") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="questions_library">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->question_foreign_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "layers") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="layers">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->layer_foreign_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_layer_question_links_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_layer_question_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="layer_question_links" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->layer_foreign_id->Visible) { // layer_foreign_id ?>
    <div id="r_layer_foreign_id" class="form-group row">
        <label id="elh_layer_question_links_layer_foreign_id" for="x_layer_foreign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->layer_foreign_id->caption() ?><?= $Page->layer_foreign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->layer_foreign_id->cellAttributes() ?>>
<?php if ($Page->layer_foreign_id->getSessionValue() != "") { ?>
<span id="el_layer_question_links_layer_foreign_id">
<span<?= $Page->layer_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->layer_foreign_id->getDisplayValue($Page->layer_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_layer_foreign_id" name="x_layer_foreign_id" value="<?= HtmlEncode($Page->layer_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_layer_question_links_layer_foreign_id">
<input type="<?= $Page->layer_foreign_id->getInputTextType() ?>" data-table="layer_question_links" data-field="x_layer_foreign_id" name="x_layer_foreign_id" id="x_layer_foreign_id" size="30" placeholder="<?= HtmlEncode($Page->layer_foreign_id->getPlaceHolder()) ?>" value="<?= $Page->layer_foreign_id->EditValue ?>"<?= $Page->layer_foreign_id->editAttributes() ?> aria-describedby="x_layer_foreign_id_help">
<?= $Page->layer_foreign_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->layer_foreign_id->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->question_foreign_id->Visible) { // question_foreign_id ?>
    <div id="r_question_foreign_id" class="form-group row">
        <label id="elh_layer_question_links_question_foreign_id" for="x_question_foreign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->question_foreign_id->caption() ?><?= $Page->question_foreign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->question_foreign_id->cellAttributes() ?>>
<?php if ($Page->question_foreign_id->getSessionValue() != "") { ?>
<span id="el_layer_question_links_question_foreign_id">
<span<?= $Page->question_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->question_foreign_id->getDisplayValue($Page->question_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_question_foreign_id" name="x_question_foreign_id" value="<?= HtmlEncode($Page->question_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_layer_question_links_question_foreign_id">
<input type="<?= $Page->question_foreign_id->getInputTextType() ?>" data-table="layer_question_links" data-field="x_question_foreign_id" name="x_question_foreign_id" id="x_question_foreign_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->question_foreign_id->getPlaceHolder()) ?>" value="<?= $Page->question_foreign_id->EditValue ?>"<?= $Page->question_foreign_id->editAttributes() ?> aria-describedby="x_question_foreign_id_help">
<?= $Page->question_foreign_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->question_foreign_id->getErrorMessage() ?></div>
</span>
<?php } ?>
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
    ew.addEventHandlers("layer_question_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
