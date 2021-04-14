<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$iso27001_family = Container("iso27001_family");
?>
<?php if ($iso27001_family->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_iso27001_familymaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($iso27001_family->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $iso27001_family->TableLeftColumnClass ?>"><?= $iso27001_family->code->caption() ?></td>
            <td <?= $iso27001_family->code->cellAttributes() ?>>
<span id="el_iso27001_family_code">
<span<?= $iso27001_family->code->viewAttributes() ?>>
<?= $iso27001_family->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($iso27001_family->control_area_id->Visible) { // control_area_id ?>
        <tr id="r_control_area_id">
            <td class="<?= $iso27001_family->TableLeftColumnClass ?>"><?= $iso27001_family->control_area_id->caption() ?></td>
            <td <?= $iso27001_family->control_area_id->cellAttributes() ?>>
<span id="el_iso27001_family_control_area_id">
<span<?= $iso27001_family->control_area_id->viewAttributes() ?>>
<?= $iso27001_family->control_area_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($iso27001_family->control_familyName->Visible) { // control_familyName ?>
        <tr id="r_control_familyName">
            <td class="<?= $iso27001_family->TableLeftColumnClass ?>"><?= $iso27001_family->control_familyName->caption() ?></td>
            <td <?= $iso27001_family->control_familyName->cellAttributes() ?>>
<span id="el_iso27001_family_control_familyName">
<span<?= $iso27001_family->control_familyName->viewAttributes() ?>>
<?= $iso27001_family->control_familyName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
