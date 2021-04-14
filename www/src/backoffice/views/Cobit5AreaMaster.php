<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$cobit5_area = Container("cobit5_area");
?>
<?php if ($cobit5_area->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cobit5_areamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cobit5_area->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $cobit5_area->TableLeftColumnClass ?>"><?= $cobit5_area->code->caption() ?></td>
            <td <?= $cobit5_area->code->cellAttributes() ?>>
<span id="el_cobit5_area_code">
<span<?= $cobit5_area->code->viewAttributes() ?>>
<?= $cobit5_area->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cobit5_area->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $cobit5_area->TableLeftColumnClass ?>"><?= $cobit5_area->name->caption() ?></td>
            <td <?= $cobit5_area->name->cellAttributes() ?>>
<span id="el_cobit5_area_name">
<span<?= $cobit5_area->name->viewAttributes() ?>>
<?= $cobit5_area->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
