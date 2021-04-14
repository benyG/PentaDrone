<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionControlobjectivesAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestion_controlobjectivesadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fquestion_controlobjectivesadd = currentForm = new ew.Form("fquestion_controlobjectivesadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "question_controlobjectives")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.question_controlobjectives)
        ew.vars.tables.question_controlobjectives = currentTable;
    fquestion_controlobjectivesadd.addFields([
        ["num_ordre", [fields.num_ordre.visible && fields.num_ordre.required ? ew.Validators.required(fields.num_ordre.caption) : null, ew.Validators.integer], fields.num_ordre.isInvalid],
        ["controlObj_name", [fields.controlObj_name.visible && fields.controlObj_name.required ? ew.Validators.required(fields.controlObj_name.caption) : null], fields.controlObj_name.isInvalid],
        ["question_domain_id", [fields.question_domain_id.visible && fields.question_domain_id.required ? ew.Validators.required(fields.question_domain_id.caption) : null], fields.question_domain_id.isInvalid],
        ["layer_id", [fields.layer_id.visible && fields.layer_id.required ? ew.Validators.required(fields.layer_id.caption) : null], fields.layer_id.isInvalid],
        ["function_csf", [fields.function_csf.visible && fields.function_csf.required ? ew.Validators.required(fields.function_csf.caption) : null], fields.function_csf.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestion_controlobjectivesadd,
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
    fquestion_controlobjectivesadd.validate = function () {
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
    fquestion_controlobjectivesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestion_controlobjectivesadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fquestion_controlobjectivesadd.lists.question_domain_id = <?= $Page->question_domain_id->toClientList($Page) ?>;
    fquestion_controlobjectivesadd.lists.layer_id = <?= $Page->layer_id->toClientList($Page) ?>;
    fquestion_controlobjectivesadd.lists.function_csf = <?= $Page->function_csf->toClientList($Page) ?>;
    loadjs.done("fquestion_controlobjectivesadd");
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
<form name="fquestion_controlobjectivesadd" id="fquestion_controlobjectivesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_controlobjectives">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "question_domains") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="question_domains">
<input type="hidden" name="fk_domain_name" value="<?= HtmlEncode($Page->question_domain_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "layers") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="layers">
<input type="hidden" name="fk_name" value="<?= HtmlEncode($Page->layer_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "functions") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="functions">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->function_csf->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->num_ordre->Visible) { // num_ordre ?>
    <div id="r_num_ordre" class="form-group row">
        <label id="elh_question_controlobjectives_num_ordre" for="x_num_ordre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->num_ordre->caption() ?><?= $Page->num_ordre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->num_ordre->cellAttributes() ?>>
<span id="el_question_controlobjectives_num_ordre">
<input type="<?= $Page->num_ordre->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_num_ordre" name="x_num_ordre" id="x_num_ordre" size="30" placeholder="<?= HtmlEncode($Page->num_ordre->getPlaceHolder()) ?>" value="<?= $Page->num_ordre->EditValue ?>"<?= $Page->num_ordre->editAttributes() ?> aria-describedby="x_num_ordre_help">
<?= $Page->num_ordre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->num_ordre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->controlObj_name->Visible) { // controlObj_name ?>
    <div id="r_controlObj_name" class="form-group row">
        <label id="elh_question_controlobjectives_controlObj_name" for="x_controlObj_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->controlObj_name->caption() ?><?= $Page->controlObj_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->controlObj_name->cellAttributes() ?>>
<span id="el_question_controlobjectives_controlObj_name">
<input type="<?= $Page->controlObj_name->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_controlObj_name" name="x_controlObj_name" id="x_controlObj_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->controlObj_name->getPlaceHolder()) ?>" value="<?= $Page->controlObj_name->EditValue ?>"<?= $Page->controlObj_name->editAttributes() ?> aria-describedby="x_controlObj_name_help">
<?= $Page->controlObj_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->controlObj_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->question_domain_id->Visible) { // question_domain_id ?>
    <div id="r_question_domain_id" class="form-group row">
        <label id="elh_question_controlobjectives_question_domain_id" for="x_question_domain_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->question_domain_id->caption() ?><?= $Page->question_domain_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->question_domain_id->cellAttributes() ?>>
<?php if ($Page->question_domain_id->getSessionValue() != "") { ?>
<span id="el_question_controlobjectives_question_domain_id">
<span<?= $Page->question_domain_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->question_domain_id->getDisplayValue($Page->question_domain_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_question_domain_id" name="x_question_domain_id" value="<?= HtmlEncode($Page->question_domain_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_question_controlobjectives_question_domain_id">
    <select
        id="x_question_domain_id"
        name="x_question_domain_id"
        class="form-control ew-select<?= $Page->question_domain_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x_question_domain_id"
        data-table="question_controlobjectives"
        data-field="x_question_domain_id"
        data-value-separator="<?= $Page->question_domain_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->question_domain_id->getPlaceHolder()) ?>"
        <?= $Page->question_domain_id->editAttributes() ?>>
        <?= $Page->question_domain_id->selectOptionListHtml("x_question_domain_id") ?>
    </select>
    <?= $Page->question_domain_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->question_domain_id->getErrorMessage() ?></div>
<?= $Page->question_domain_id->Lookup->getParamTag($Page, "p_x_question_domain_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x_question_domain_id']"),
        options = { name: "x_question_domain_id", selectId: "question_controlobjectives_x_question_domain_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.question_domain_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->layer_id->Visible) { // layer_id ?>
    <div id="r_layer_id" class="form-group row">
        <label id="elh_question_controlobjectives_layer_id" for="x_layer_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->layer_id->caption() ?><?= $Page->layer_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->layer_id->cellAttributes() ?>>
<?php if ($Page->layer_id->getSessionValue() != "") { ?>
<span id="el_question_controlobjectives_layer_id">
<span<?= $Page->layer_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->layer_id->getDisplayValue($Page->layer_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_layer_id" name="x_layer_id" value="<?= HtmlEncode($Page->layer_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_question_controlobjectives_layer_id">
    <select
        id="x_layer_id"
        name="x_layer_id"
        class="form-control ew-select<?= $Page->layer_id->isInvalidClass() ?>"
        data-select2-id="question_controlobjectives_x_layer_id"
        data-table="question_controlobjectives"
        data-field="x_layer_id"
        data-value-separator="<?= $Page->layer_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->layer_id->getPlaceHolder()) ?>"
        <?= $Page->layer_id->editAttributes() ?>>
        <?= $Page->layer_id->selectOptionListHtml("x_layer_id") ?>
    </select>
    <?= $Page->layer_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->layer_id->getErrorMessage() ?></div>
<?= $Page->layer_id->Lookup->getParamTag($Page, "p_x_layer_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_controlobjectives_x_layer_id']"),
        options = { name: "x_layer_id", selectId: "question_controlobjectives_x_layer_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_controlobjectives.fields.layer_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->function_csf->Visible) { // function_csf ?>
    <div id="r_function_csf" class="form-group row">
        <label id="elh_question_controlobjectives_function_csf" class="<?= $Page->LeftColumnClass ?>"><?= $Page->function_csf->caption() ?><?= $Page->function_csf->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->function_csf->cellAttributes() ?>>
<?php if ($Page->function_csf->getSessionValue() != "") { ?>
<span id="el_question_controlobjectives_function_csf">
<span<?= $Page->function_csf->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->function_csf->getDisplayValue($Page->function_csf->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_function_csf" name="x_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_question_controlobjectives_function_csf">
<?php
$onchange = $Page->function_csf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->function_csf->EditAttrs["onchange"] = "";
?>
<span id="as_x_function_csf" class="ew-auto-suggest">
    <input type="<?= $Page->function_csf->getInputTextType() ?>" class="form-control" name="sv_x_function_csf" id="sv_x_function_csf" value="<?= RemoveHtml($Page->function_csf->EditValue) ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->function_csf->getPlaceHolder()) ?>"<?= $Page->function_csf->editAttributes() ?> aria-describedby="x_function_csf_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="question_controlobjectives" data-field="x_function_csf" data-input="sv_x_function_csf" data-value-separator="<?= $Page->function_csf->displayValueSeparatorAttribute() ?>" name="x_function_csf" id="x_function_csf" value="<?= HtmlEncode($Page->function_csf->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->function_csf->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->function_csf->getErrorMessage() ?></div>
<script>
loadjs.ready(["fquestion_controlobjectivesadd"], function() {
    fquestion_controlobjectivesadd.createAutoSuggest(Object.assign({"id":"x_function_csf","forceSelect":false}, ew.vars.tables.question_controlobjectives.fields.function_csf.autoSuggestOptions));
});
</script>
<?= $Page->function_csf->Lookup->getParamTag($Page, "p_x_function_csf") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_question_controlobjectives_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_question_controlobjectives_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_question_controlobjectives_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_question_controlobjectives_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="question_controlobjectives" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_controlobjectivesadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_controlobjectivesadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("questions_library", explode(",", $Page->getCurrentDetailTable())) && $questions_library->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("questions_library", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "QuestionsLibraryGrid.php" ?>
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
    ew.addEventHandlers("question_controlobjectives");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
