<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$nist_refs_controlarea = Container("nist_refs_controlarea");
?>
<?php if ($nist_refs_controlarea->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_nist_refs_controlareamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($nist_refs_controlarea->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $nist_refs_controlarea->TableLeftColumnClass ?>"><?= $nist_refs_controlarea->code->caption() ?></td>
            <td <?= $nist_refs_controlarea->code->cellAttributes() ?>>
<span id="el_nist_refs_controlarea_code">
<span<?= $nist_refs_controlarea->code->viewAttributes() ?>>
<?= $nist_refs_controlarea->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_refs_controlarea->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $nist_refs_controlarea->TableLeftColumnClass ?>"><?= $nist_refs_controlarea->name->caption() ?></td>
            <td <?= $nist_refs_controlarea->name->cellAttributes() ?>>
<span id="el_nist_refs_controlarea_name">
<span<?= $nist_refs_controlarea->name->viewAttributes() ?>>
<?= $nist_refs_controlarea->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
