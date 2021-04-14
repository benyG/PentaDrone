<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$cobit5_family = Container("cobit5_family");
?>
<?php if ($cobit5_family->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cobit5_familymaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cobit5_family->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $cobit5_family->TableLeftColumnClass ?>"><?= $cobit5_family->code->caption() ?></td>
            <td <?= $cobit5_family->code->cellAttributes() ?>>
<span id="el_cobit5_family_code">
<span<?= $cobit5_family->code->viewAttributes() ?>>
<?= $cobit5_family->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cobit5_family->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $cobit5_family->TableLeftColumnClass ?>"><?= $cobit5_family->name->caption() ?></td>
            <td <?= $cobit5_family->name->cellAttributes() ?>>
<span id="el_cobit5_family_name">
<span<?= $cobit5_family->name->viewAttributes() ?>>
<?= $cobit5_family->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cobit5_family->control_area_id->Visible) { // control_area_id ?>
        <tr id="r_control_area_id">
            <td class="<?= $cobit5_family->TableLeftColumnClass ?>"><?= $cobit5_family->control_area_id->caption() ?></td>
            <td <?= $cobit5_family->control_area_id->cellAttributes() ?>>
<span id="el_cobit5_family_control_area_id">
<span<?= $cobit5_family->control_area_id->viewAttributes() ?>>
<?= $cobit5_family->control_area_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
