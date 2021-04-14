<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$ControlsLibraryEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcontrols_libraryedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fcontrols_libraryedit = currentForm = new ew.Form("fcontrols_libraryedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "controls_library")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.controls_library)
        ew.vars.tables.controls_library = currentTable;
    fcontrols_libraryedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["nist_subcategory_id", [fields.nist_subcategory_id.visible && fields.nist_subcategory_id.required ? ew.Validators.required(fields.nist_subcategory_id.caption) : null, ew.Validators.integer], fields.nist_subcategory_id.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["best_practices", [fields.best_practices.visible && fields.best_practices.required ? ew.Validators.required(fields.best_practices.caption) : null], fields.best_practices.isInvalid],
        ["Evidence_to_request", [fields.Evidence_to_request.visible && fields.Evidence_to_request.required ? ew.Validators.required(fields.Evidence_to_request.caption) : null], fields.Evidence_to_request.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcontrols_libraryedit,
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
    fcontrols_libraryedit.validate = function () {
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
    fcontrols_libraryedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcontrols_libraryedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcontrols_libraryedit");
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
<form name="fcontrols_libraryedit" id="fcontrols_libraryedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="controls_library">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sub_categories") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sub_categories">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->nist_subcategory_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_controls_library_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_controls_library_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="controls_library" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
    <div id="r_nist_subcategory_id" class="form-group row">
        <label id="elh_controls_library_nist_subcategory_id" for="x_nist_subcategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nist_subcategory_id->caption() ?><?= $Page->nist_subcategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nist_subcategory_id->cellAttributes() ?>>
<?php if ($Page->nist_subcategory_id->getSessionValue() != "") { ?>
<span id="el_controls_library_nist_subcategory_id">
<span<?= $Page->nist_subcategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nist_subcategory_id->getDisplayValue($Page->nist_subcategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_nist_subcategory_id" name="x_nist_subcategory_id" value="<?= HtmlEncode($Page->nist_subcategory_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_controls_library_nist_subcategory_id">
<input type="<?= $Page->nist_subcategory_id->getInputTextType() ?>" data-table="controls_library" data-field="x_nist_subcategory_id" name="x_nist_subcategory_id" id="x_nist_subcategory_id" size="30" placeholder="<?= HtmlEncode($Page->nist_subcategory_id->getPlaceHolder()) ?>" value="<?= $Page->nist_subcategory_id->EditValue ?>"<?= $Page->nist_subcategory_id->editAttributes() ?> aria-describedby="x_nist_subcategory_id_help">
<?= $Page->nist_subcategory_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nist_subcategory_id->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <div id="r_title" class="form-group row">
        <label id="elh_controls_library_title" for="x_title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title->caption() ?><?= $Page->title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->title->cellAttributes() ?>>
<span id="el_controls_library_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="controls_library" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?> aria-describedby="x_title_help">
<?= $Page->title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_controls_library_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<span id="el_controls_library_description">
<textarea data-table="controls_library" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->best_practices->Visible) { // best_practices ?>
    <div id="r_best_practices" class="form-group row">
        <label id="elh_controls_library_best_practices" for="x_best_practices" class="<?= $Page->LeftColumnClass ?>"><?= $Page->best_practices->caption() ?><?= $Page->best_practices->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->best_practices->cellAttributes() ?>>
<span id="el_controls_library_best_practices">
<textarea data-table="controls_library" data-field="x_best_practices" name="x_best_practices" id="x_best_practices" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->best_practices->getPlaceHolder()) ?>"<?= $Page->best_practices->editAttributes() ?> aria-describedby="x_best_practices_help"><?= $Page->best_practices->EditValue ?></textarea>
<?= $Page->best_practices->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->best_practices->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Evidence_to_request->Visible) { // Evidence_to_request ?>
    <div id="r_Evidence_to_request" class="form-group row">
        <label id="elh_controls_library_Evidence_to_request" for="x_Evidence_to_request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Evidence_to_request->caption() ?><?= $Page->Evidence_to_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Evidence_to_request->cellAttributes() ?>>
<span id="el_controls_library_Evidence_to_request">
<textarea data-table="controls_library" data-field="x_Evidence_to_request" name="x_Evidence_to_request" id="x_Evidence_to_request" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Evidence_to_request->getPlaceHolder()) ?>"<?= $Page->Evidence_to_request->editAttributes() ?> aria-describedby="x_Evidence_to_request_help"><?= $Page->Evidence_to_request->EditValue ?></textarea>
<?= $Page->Evidence_to_request->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Evidence_to_request->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_controls_library_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_controls_library_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="controls_library" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_libraryedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_libraryedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_controls_library_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_controls_library_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="controls_library" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontrols_libraryedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontrols_libraryedit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("layer_controls_links", explode(",", $Page->getCurrentDetailTable())) && $layer_controls_links->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("layer_controls_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "LayerControlsLinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("risk_control_links", explode(",", $Page->getCurrentDetailTable())) && $risk_control_links->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("risk_control_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "RiskControlLinksGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("controls_library");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
