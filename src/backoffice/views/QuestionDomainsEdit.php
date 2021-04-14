<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$QuestionDomainsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fquestion_domainsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fquestion_domainsedit = currentForm = new ew.Form("fquestion_domainsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "question_domains")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.question_domains)
        ew.vars.tables.question_domains = currentTable;
    fquestion_domainsedit.addFields([
        ["domain_name", [fields.domain_name.visible && fields.domain_name.required ? ew.Validators.required(fields.domain_name.caption) : null], fields.domain_name.isInvalid],
        ["question_area_id", [fields.question_area_id.visible && fields.question_area_id.required ? ew.Validators.required(fields.question_area_id.caption) : null], fields.question_area_id.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fquestion_domainsedit,
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
    fquestion_domainsedit.validate = function () {
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
    fquestion_domainsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fquestion_domainsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fquestion_domainsedit.lists.question_area_id = <?= $Page->question_area_id->toClientList($Page) ?>;
    loadjs.done("fquestion_domainsedit");
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
<form name="fquestion_domainsedit" id="fquestion_domainsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="question_domains">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "question_areas") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="question_areas">
<input type="hidden" name="fk_area_name" value="<?= HtmlEncode($Page->question_area_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->domain_name->Visible) { // domain_name ?>
    <div id="r_domain_name" class="form-group row">
        <label id="elh_question_domains_domain_name" for="x_domain_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->domain_name->caption() ?><?= $Page->domain_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->domain_name->cellAttributes() ?>>
<input type="<?= $Page->domain_name->getInputTextType() ?>" data-table="question_domains" data-field="x_domain_name" name="x_domain_name" id="x_domain_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->domain_name->getPlaceHolder()) ?>" value="<?= $Page->domain_name->EditValue ?>"<?= $Page->domain_name->editAttributes() ?> aria-describedby="x_domain_name_help">
<?= $Page->domain_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->domain_name->getErrorMessage() ?></div>
<input type="hidden" data-table="question_domains" data-field="x_domain_name" data-hidden="1" name="o_domain_name" id="o_domain_name" value="<?= HtmlEncode($Page->domain_name->OldValue ?? $Page->domain_name->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->question_area_id->Visible) { // question_area_id ?>
    <div id="r_question_area_id" class="form-group row">
        <label id="elh_question_domains_question_area_id" for="x_question_area_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->question_area_id->caption() ?><?= $Page->question_area_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->question_area_id->cellAttributes() ?>>
<?php if ($Page->question_area_id->getSessionValue() != "") { ?>
<span id="el_question_domains_question_area_id">
<span<?= $Page->question_area_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->question_area_id->getDisplayValue($Page->question_area_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_question_area_id" name="x_question_area_id" value="<?= HtmlEncode($Page->question_area_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_question_domains_question_area_id">
    <select
        id="x_question_area_id"
        name="x_question_area_id"
        class="form-control ew-select<?= $Page->question_area_id->isInvalidClass() ?>"
        data-select2-id="question_domains_x_question_area_id"
        data-table="question_domains"
        data-field="x_question_area_id"
        data-value-separator="<?= $Page->question_area_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->question_area_id->getPlaceHolder()) ?>"
        <?= $Page->question_area_id->editAttributes() ?>>
        <?= $Page->question_area_id->selectOptionListHtml("x_question_area_id") ?>
    </select>
    <?= $Page->question_area_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->question_area_id->getErrorMessage() ?></div>
<?= $Page->question_area_id->Lookup->getParamTag($Page, "p_x_question_area_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='question_domains_x_question_area_id']"),
        options = { name: "x_question_area_id", selectId: "question_domains_x_question_area_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.question_domains.fields.question_area_id.selectOptions);
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
        <label id="elh_question_domains_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_question_domains_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="question_domains" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_question_domains_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_question_domains_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="question_domains" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fquestion_domainsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fquestion_domainsedit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("question_controlobjectives", explode(",", $Page->getCurrentDetailTable())) && $question_controlobjectives->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("question_controlobjectives", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "QuestionControlobjectivesGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("question_domains");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
