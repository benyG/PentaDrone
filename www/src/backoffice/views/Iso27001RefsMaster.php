<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$iso27001_refs = Container("iso27001_refs");
?>
<?php if ($iso27001_refs->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_iso27001_refsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($iso27001_refs->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $iso27001_refs->TableLeftColumnClass ?>"><?= $iso27001_refs->code->caption() ?></td>
            <td <?= $iso27001_refs->code->cellAttributes() ?>>
<span id="el_iso27001_refs_code">
<span<?= $iso27001_refs->code->viewAttributes() ?>>
<?= $iso27001_refs->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($iso27001_refs->control_familyName_id->Visible) { // control_familyName_id ?>
        <tr id="r_control_familyName_id">
            <td class="<?= $iso27001_refs->TableLeftColumnClass ?>"><?= $iso27001_refs->control_familyName_id->caption() ?></td>
            <td <?= $iso27001_refs->control_familyName_id->cellAttributes() ?>>
<span id="el_iso27001_refs_control_familyName_id">
<span<?= $iso27001_refs->control_familyName_id->viewAttributes() ?>>
<?= $iso27001_refs->control_familyName_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($iso27001_refs->control_name->Visible) { // control_name ?>
        <tr id="r_control_name">
            <td class="<?= $iso27001_refs->TableLeftColumnClass ?>"><?= $iso27001_refs->control_name->caption() ?></td>
            <td <?= $iso27001_refs->control_name->cellAttributes() ?>>
<span id="el_iso27001_refs_control_name">
<span<?= $iso27001_refs->control_name->viewAttributes() ?>>
<?= $iso27001_refs->control_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($iso27001_refs->control_ID->Visible) { // control_ID ?>
        <tr id="r_control_ID">
            <td class="<?= $iso27001_refs->TableLeftColumnClass ?>"><?= $iso27001_refs->control_ID->caption() ?></td>
            <td <?= $iso27001_refs->control_ID->cellAttributes() ?>>
<span id="el_iso27001_refs_control_ID">
<span<?= $iso27001_refs->control_ID->viewAttributes() ?>>
<?= $iso27001_refs->control_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
