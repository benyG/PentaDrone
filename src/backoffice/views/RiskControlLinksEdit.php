<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Page object
$RiskControlLinksEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var frisk_control_linksedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    frisk_control_linksedit = currentForm = new ew.Form("frisk_control_linksedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "risk_control_links")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.risk_control_links)
        ew.vars.tables.risk_control_links = currentTable;
    frisk_control_linksedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["control_foreign_id", [fields.control_foreign_id.visible && fields.control_foreign_id.required ? ew.Validators.required(fields.control_foreign_id.caption) : null], fields.control_foreign_id.isInvalid],
        ["risk_foreign_id", [fields.risk_foreign_id.visible && fields.risk_foreign_id.required ? ew.Validators.required(fields.risk_foreign_id.caption) : null], fields.risk_foreign_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = frisk_control_linksedit,
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
    frisk_control_linksedit.validate = function () {
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
    frisk_control_linksedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    frisk_control_linksedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    frisk_control_linksedit.lists.control_foreign_id = <?= $Page->control_foreign_id->toClientList($Page) ?>;
    frisk_control_linksedit.lists.risk_foreign_id = <?= $Page->risk_foreign_id->toClientList($Page) ?>;
    loadjs.done("frisk_control_linksedit");
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
<form name="frisk_control_linksedit" id="frisk_control_linksedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risk_control_links">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "risk_librairies") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="risk_librairies">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->risk_foreign_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "questions_library") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="questions_library">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->control_foreign_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_risk_control_links_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_risk_control_links_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="risk_control_links" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->control_foreign_id->Visible) { // control_foreign_id ?>
    <div id="r_control_foreign_id" class="form-group row">
        <label id="elh_risk_control_links_control_foreign_id" for="x_control_foreign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->control_foreign_id->caption() ?><?= $Page->control_foreign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->control_foreign_id->cellAttributes() ?>>
<?php if ($Page->control_foreign_id->getSessionValue() != "") { ?>
<span id="el_risk_control_links_control_foreign_id">
<span<?= $Page->control_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->control_foreign_id->getDisplayValue($Page->control_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_control_foreign_id" name="x_control_foreign_id" value="<?= HtmlEncode($Page->control_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_risk_control_links_control_foreign_id">
    <select
        id="x_control_foreign_id"
        name="x_control_foreign_id"
        class="form-control ew-select<?= $Page->control_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x_control_foreign_id"
        data-table="risk_control_links"
        data-field="x_control_foreign_id"
        data-value-separator="<?= $Page->control_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->control_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->control_foreign_id->editAttributes() ?>>
        <?= $Page->control_foreign_id->selectOptionListHtml("x_control_foreign_id") ?>
    </select>
    <?= $Page->control_foreign_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->control_foreign_id->getErrorMessage() ?></div>
<?= $Page->control_foreign_id->Lookup->getParamTag($Page, "p_x_control_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x_control_foreign_id']"),
        options = { name: "x_control_foreign_id", selectId: "risk_control_links_x_control_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.control_foreign_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->risk_foreign_id->Visible) { // risk_foreign_id ?>
    <div id="r_risk_foreign_id" class="form-group row">
        <label id="elh_risk_control_links_risk_foreign_id" for="x_risk_foreign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->risk_foreign_id->caption() ?><?= $Page->risk_foreign_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->risk_foreign_id->cellAttributes() ?>>
<?php if ($Page->risk_foreign_id->getSessionValue() != "") { ?>
<span id="el_risk_control_links_risk_foreign_id">
<span<?= $Page->risk_foreign_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->risk_foreign_id->getDisplayValue($Page->risk_foreign_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_risk_foreign_id" name="x_risk_foreign_id" value="<?= HtmlEncode($Page->risk_foreign_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_risk_control_links_risk_foreign_id">
    <select
        id="x_risk_foreign_id"
        name="x_risk_foreign_id"
        class="form-control ew-select<?= $Page->risk_foreign_id->isInvalidClass() ?>"
        data-select2-id="risk_control_links_x_risk_foreign_id"
        data-table="risk_control_links"
        data-field="x_risk_foreign_id"
        data-value-separator="<?= $Page->risk_foreign_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->risk_foreign_id->getPlaceHolder()) ?>"
        <?= $Page->risk_foreign_id->editAttributes() ?>>
        <?= $Page->risk_foreign_id->selectOptionListHtml("x_risk_foreign_id") ?>
    </select>
    <?= $Page->risk_foreign_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->risk_foreign_id->getErrorMessage() ?></div>
<?= $Page->risk_foreign_id->Lookup->getParamTag($Page, "p_x_risk_foreign_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='risk_control_links_x_risk_foreign_id']"),
        options = { name: "x_risk_foreign_id", selectId: "risk_control_links_x_risk_foreign_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.risk_control_links.fields.risk_foreign_id.selectOptions);
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
    ew.addEventHandlers("risk_control_links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
