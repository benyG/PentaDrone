<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionsLibraryEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestions_libraryedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fquestions_libraryedit = currentForm = new ew.Form("fquestions_libraryedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "questions_library")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.questions_library)
        ew.vars.tables.questions_library = currentTable;
    fquestions_libraryedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["libelle", [fields.libelle.visible && fields.libelle.required ? ew.Validators.required(fields.libelle.caption) : null], fields.libelle.isInvalid],
        ["Evidence_to_request", [fields.Evidence_to_request.visible && fields.Evidence_to_request.required ? ew.Validators.required(fields.Evidence_to_request.caption) : null], fields.Evidence_to_request.isInvalid],
        ["controlObj_id", [fields.controlObj_id.visible && fields.controlObj_id.required ? ew.Validators.required(fields.controlObj_id.caption) : null], fields.controlObj_id.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid],
        ["refs1", [fields.refs1.visible && fields.refs1.required ? ew.Validators.required(fields.refs1.caption) : null], fields.refs1.isInvalid],
        ["refs2", [fields.refs2.visible && fields.refs2.required ? ew.Validators.required(fields.refs2.caption) : null], fields.refs2.isInvalid],
        ["Activation_status", [fields.Activation_status.visible && fields.Activation_status.required ? ew.Validators.required(fields.Activation_status.caption) : null, ew.Validators.integer], fields.Activation_status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestions_libraryedit,
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
    fquestions_libraryedit.validate = function () {
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
    fquestions_libraryedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestions_libraryedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fquestions_libraryedit.lists.controlObj_id = <?= $Page->controlObj_id->toClientList($Page) ?>;
    loadjs.done("fquestions_libraryedit");
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
<form name="fquestions_libraryedit" id="fquestions_libraryedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="questions_library">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "iso27001_refs") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="iso27001_refs">
<input type="hidden" name="fk_code" value="<?= HtmlEncode($Page->refs1->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "nist_to_iso27001") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nist_to_iso27001">
<input type="hidden" name="fk_just_for_question_link" value="<?= HtmlEncode($Page->refs1->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "question_controlobjectives") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="question_controlobjectives">
<input type="hidden" name="fk_controlObj_name" value="<?= HtmlEncode($Page->controlObj_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_questions_library_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_questions_library_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="questions_library" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->libelle->Visible) { // libelle ?>
    <div id="r_libelle" class="form-group row">
        <label id="elh_questions_library_libelle" for="x_libelle" class="<?= $Page->LeftColumnClass ?>"><?= $Page->libelle->caption() ?><?= $Page->libelle->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->libelle->cellAttributes() ?>>
<span id="el_questions_library_libelle">
<input type="<?= $Page->libelle->getInputTextType() ?>" data-table="questions_library" data-field="x_libelle" name="x_libelle" id="x_libelle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->libelle->getPlaceHolder()) ?>" value="<?= $Page->libelle->EditValue ?>"<?= $Page->libelle->editAttributes() ?> aria-describedby="x_libelle_help">
<?= $Page->libelle->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->libelle->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Evidence_to_request->Visible) { // Evidence_to_request ?>
    <div id="r_Evidence_to_request" class="form-group row">
        <label id="elh_questions_library_Evidence_to_request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Evidence_to_request->caption() ?><?= $Page->Evidence_to_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Evidence_to_request->cellAttributes() ?>>
<span id="el_questions_library_Evidence_to_request">
<?php $Page->Evidence_to_request->EditAttrs->appendClass("editor"); ?>
<textarea data-table="questions_library" data-field="x_Evidence_to_request" name="x_Evidence_to_request" id="x_Evidence_to_request" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Evidence_to_request->getPlaceHolder()) ?>"<?= $Page->Evidence_to_request->editAttributes() ?> aria-describedby="x_Evidence_to_request_help"><?= $Page->Evidence_to_request->EditValue ?></textarea>
<?= $Page->Evidence_to_request->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Evidence_to_request->getErrorMessage() ?></div>
<script>
loadjs.ready(["fquestions_libraryedit", "editor"], function() {
	ew.createEditor("fquestions_libraryedit", "x_Evidence_to_request", 35, 4, <?= $Page->Evidence_to_request->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->controlObj_id->Visible) { // controlObj_id ?>
    <div id="r_controlObj_id" class="form-group row">
        <label id="elh_questions_library_controlObj_id" for="x_controlObj_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->controlObj_id->caption() ?><?= $Page->controlObj_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->controlObj_id->cellAttributes() ?>>
<?php if ($Page->controlObj_id->getSessionValue() != "") { ?>
<span id="el_questions_library_controlObj_id">
<span<?= $Page->controlObj_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->controlObj_id->getDisplayValue($Page->controlObj_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_controlObj_id" name="x_controlObj_id" value="<?= HtmlEncode($Page->controlObj_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_questions_library_controlObj_id">
    <select
        id="x_controlObj_id"
        name="x_controlObj_id"
        class="form-control ew-select<?= $Page->controlObj_id->isInvalidClass() ?>"
        data-select2-id="questions_library_x_controlObj_id"
        data-table="questions_library"
        data-field="x_controlObj_id"
        data-value-separator="<?= $Page->controlObj_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->controlObj_id->getPlaceHolder()) ?>"
        <?= $Page->controlObj_id->editAttributes() ?>>
        <?= $Page->controlObj_id->selectOptionListHtml("x_controlObj_id") ?>
    </select>
    <?= $Page->controlObj_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->controlObj_id->getErrorMessage() ?></div>
<?= $Page->controlObj_id->Lookup->getParamTag($Page, "p_x_controlObj_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='questions_library_x_controlObj_id']"),
        options = { name: "x_controlObj_id", selectId: "questions_library_x_controlObj_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.questions_library.fields.controlObj_id.selectOptions);
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
        <label id="elh_questions_library_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_questions_library_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="questions_library" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestions_libraryedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestions_libraryedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_questions_library_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_questions_library_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="questions_library" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestions_libraryedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestions_libraryedit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->refs1->Visible) { // refs1 ?>
    <div id="r_refs1" class="form-group row">
        <label id="elh_questions_library_refs1" for="x_refs1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->refs1->caption() ?><?= $Page->refs1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->refs1->cellAttributes() ?>>
<?php if ($Page->refs1->getSessionValue() != "") { ?>
<span id="el_questions_library_refs1">
<span<?= $Page->refs1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->refs1->getDisplayValue($Page->refs1->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_refs1" name="x_refs1" value="<?= HtmlEncode($Page->refs1->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_questions_library_refs1">
<input type="<?= $Page->refs1->getInputTextType() ?>" data-table="questions_library" data-field="x_refs1" name="x_refs1" id="x_refs1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs1->getPlaceHolder()) ?>" value="<?= $Page->refs1->EditValue ?>"<?= $Page->refs1->editAttributes() ?> aria-describedby="x_refs1_help">
<?= $Page->refs1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->refs1->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->refs2->Visible) { // refs2 ?>
    <div id="r_refs2" class="form-group row">
        <label id="elh_questions_library_refs2" for="x_refs2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->refs2->caption() ?><?= $Page->refs2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->refs2->cellAttributes() ?>>
<span id="el_questions_library_refs2">
<input type="<?= $Page->refs2->getInputTextType() ?>" data-table="questions_library" data-field="x_refs2" name="x_refs2" id="x_refs2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->refs2->getPlaceHolder()) ?>" value="<?= $Page->refs2->EditValue ?>"<?= $Page->refs2->editAttributes() ?> aria-describedby="x_refs2_help">
<?= $Page->refs2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->refs2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Activation_status->Visible) { // Activation_status ?>
    <div id="r_Activation_status" class="form-group row">
        <label id="elh_questions_library_Activation_status" for="x_Activation_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Activation_status->caption() ?><?= $Page->Activation_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Activation_status->cellAttributes() ?>>
<span id="el_questions_library_Activation_status">
<input type="<?= $Page->Activation_status->getInputTextType() ?>" data-table="questions_library" data-field="x_Activation_status" name="x_Activation_status" id="x_Activation_status" size="30" placeholder="<?= HtmlEncode($Page->Activation_status->getPlaceHolder()) ?>" value="<?= $Page->Activation_status->EditValue ?>"<?= $Page->Activation_status->editAttributes() ?> aria-describedby="x_Activation_status_help">
<?= $Page->Activation_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Activation_status->getErrorMessage() ?></div>
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
    ew.addEventHandlers("questions_library");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
