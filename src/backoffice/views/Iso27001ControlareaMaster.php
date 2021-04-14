<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$iso27001_controlarea = Container("iso27001_controlarea");
?>
<?php if ($iso27001_controlarea->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_iso27001_controlareamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($iso27001_controlarea->control_area->Visible) { // control_area ?>
        <tr id="r_control_area">
            <td class="<?= $iso27001_controlarea->TableLeftColumnClass ?>"><?= $iso27001_controlarea->control_area->caption() ?></td>
            <td <?= $iso27001_controlarea->control_area->cellAttributes() ?>>
<span id="el_iso27001_controlarea_control_area">
<span<?= $iso27001_controlarea->control_area->viewAttributes() ?>>
<?= $iso27001_controlarea->control_area->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($iso27001_controlarea->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $iso27001_controlarea->TableLeftColumnClass ?>"><?= $iso27001_controlarea->code->caption() ?></td>
            <td <?= $iso27001_controlarea->code->cellAttributes() ?>>
<span id="el_iso27001_controlarea_code">
<span<?= $iso27001_controlarea->code->viewAttributes() ?>>
<?= $iso27001_controlarea->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($iso27001_controlarea->ordre->Visible) { // ordre ?>
        <tr id="r_ordre">
            <td class="<?= $iso27001_controlarea->TableLeftColumnClass ?>"><?= $iso27001_controlarea->ordre->caption() ?></td>
            <td <?= $iso27001_controlarea->ordre->cellAttributes() ?>>
<span id="el_iso27001_controlarea_ordre">
<span<?= $iso27001_controlarea->ordre->viewAttributes() ?>>
<?= $iso27001_controlarea->ordre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
