<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Page object
$Iso27001RefsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fiso27001_refsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fiso27001_refsadd = currentForm = new ew.Form("fiso27001_refsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "iso27001_refs")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.iso27001_refs)
        ew.vars.tables.iso27001_refs = currentTable;
    fiso27001_refsadd.addFields([
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["control_familyName_id", [fields.control_familyName_id.visible && fields.control_familyName_id.required ? ew.Validators.required(fields.control_familyName_id.caption) : null], fields.control_familyName_id.isInvalid],
        ["control_name", [fields.control_name.visible && fields.control_name.required ? ew.Validators.required(fields.control_name.caption) : null], fields.control_name.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["control_ID", [fields.control_ID.visible && fields.control_ID.required ? ew.Validators.required(fields.control_ID.caption) : null], fields.control_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fiso27001_refsadd,
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
    fiso27001_refsadd.validate = function () {
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
    fiso27001_refsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fiso27001_refsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fiso27001_refsadd.lists.control_familyName_id = <?= $Page->control_familyName_id->toClientList($Page) ?>;
    loadjs.done("fiso27001_refsadd");
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
<form name="fiso27001_refsadd" id="fiso27001_refsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="iso27001_refs">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "iso27001_family") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="iso27001_family">
<input type="hidden" name="fk_control_familyName" value="<?= HtmlEncode($Page->control_familyName_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code" class="form-group row">
        <label id="elh_iso27001_refs_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->code->cellAttributes() ?>>
<span id="el_iso27001_refs_code">
<input type="<?= $Page->code->getInputTextType() ?>" data-table="iso27001_refs" data-field="x_code" name="x_code" id="x_code" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>" value="<?= $Page->code->EditValue ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_familyName_id->Visible) { // control_familyName_id ?>
    <div id="r_control_familyName_id" class="form-group row">
        <label id="elh_iso27001_refs_control_familyName_id" for="x_control_familyName_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_familyName_id->caption() ?><?= $Page->control_familyName_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_familyName_id->cellAttributes() ?>>
<?php if ($Page->control_familyName_id->getSessionValue() != "") { ?>
<span id="el_iso27001_refs_control_familyName_id">
<span<?= $Page->control_familyName_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->control_familyName_id->getDisplayValue($Page->control_familyName_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_control_familyName_id" name="x_control_familyName_id" value="<?= HtmlEncode($Page->control_familyName_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_iso27001_refs_control_familyName_id">
    <select
        id="x_control_familyName_id"
        name="x_control_familyName_id"
        class="form-control ew-select<?= $Page->control_familyName_id->isInvalidClass() ?>"
        data-select2-id="iso27001_refs_x_control_familyName_id"
        data-table="iso27001_refs"
        data-field="x_control_familyName_id"
        data-value-separator="<?= $Page->control_familyName_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->control_familyName_id->getPlaceHolder()) ?>"
        <?= $Page->control_familyName_id->editAttributes() ?>>
        <?= $Page->control_familyName_id->selectOptionListHtml("x_control_familyName_id") ?>
    </select>
    <?= $Page->control_familyName_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->control_familyName_id->getErrorMessage() ?></div>
<?= $Page->control_familyName_id->Lookup->getParamTag($Page, "p_x_control_familyName_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='iso27001_refs_x_control_familyName_id']"),
        options = { name: "x_control_familyName_id", selectId: "iso27001_refs_x_control_familyName_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.iso27001_refs.fields.control_familyName_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_name->Visible) { // control_name ?>
    <div id="r_control_name" class="form-group row">
        <label id="elh_iso27001_refs_control_name" for="x_control_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_name->caption() ?><?= $Page->control_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_name->cellAttributes() ?>>
<span id="el_iso27001_refs_control_name">
<input type="<?= $Page->control_name->getInputTextType() ?>" data-table="iso27001_refs" data-field="x_control_name" name="x_control_name" id="x_control_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->control_name->getPlaceHolder()) ?>" value="<?= $Page->control_name->EditValue ?>"<?= $Page->control_name->editAttributes() ?> aria-describedby="x_control_name_help">
<?= $Page->control_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_iso27001_refs_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<span id="el_iso27001_refs_description">
<?php $Page->description->EditAttrs->appendClass("editor"); ?>
<textarea data-table="iso27001_refs" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
<script>
loadjs.ready(["fiso27001_refsadd", "editor"], function() {
	ew.createEditor("fiso27001_refsadd", "x_description", 35, 4, <?= $Page->description->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_ID->Visible) { // control_ID ?>
    <div id="r_control_ID" class="form-group row">
        <label id="elh_iso27001_refs_control_ID" for="x_control_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_ID->caption() ?><?= $Page->control_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_ID->cellAttributes() ?>>
<span id="el_iso27001_refs_control_ID">
<input type="<?= $Page->control_ID->getInputTextType() ?>" data-table="iso27001_refs" data-field="x_control_ID" name="x_control_ID" id="x_control_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->control_ID->getPlaceHolder()) ?>" value="<?= $Page->control_ID->EditValue ?>"<?= $Page->control_ID->editAttributes() ?> aria-describedby="x_control_ID_help">
<?= $Page->control_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->control_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("subcat_iso27001_links", explode(",", $Page->getCurrentDetailTable())) && $subcat_iso27001_links->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subcat_iso27001_links", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubcatIso27001LinksGrid.php" ?>
<?php } ?>
<?php
    if (in_array("questions_library", explode(",", $Page->getCurrentDetailTable())) && $questions_library->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("questions_library", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "QuestionsLibraryGrid.php" ?>
<?php } ?>
<?php
    if (in_array("nist_to_iso27001", explode(",", $Page->getCurrentDetailTable())) && $nist_to_iso27001->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("nist_to_iso27001", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "NistToIso27001Grid.php" ?>
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
    ew.addEventHandlers("iso27001_refs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
