<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$nist_refs_controlfamily = Container("nist_refs_controlfamily");
?>
<?php if ($nist_refs_controlfamily->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_nist_refs_controlfamilymaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($nist_refs_controlfamily->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $nist_refs_controlfamily->TableLeftColumnClass ?>"><?= $nist_refs_controlfamily->code->caption() ?></td>
            <td <?= $nist_refs_controlfamily->code->cellAttributes() ?>>
<span id="el_nist_refs_controlfamily_code">
<span<?= $nist_refs_controlfamily->code->viewAttributes() ?>>
<?= $nist_refs_controlfamily->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_refs_controlfamily->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $nist_refs_controlfamily->TableLeftColumnClass ?>"><?= $nist_refs_controlfamily->name->caption() ?></td>
            <td <?= $nist_refs_controlfamily->name->cellAttributes() ?>>
<span id="el_nist_refs_controlfamily_name">
<span<?= $nist_refs_controlfamily->name->viewAttributes() ?>>
<?= $nist_refs_controlfamily->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_refs_controlfamily->controlarea_id->Visible) { // controlarea_id ?>
        <tr id="r_controlarea_id">
            <td class="<?= $nist_refs_controlfamily->TableLeftColumnClass ?>"><?= $nist_refs_controlfamily->controlarea_id->caption() ?></td>
            <td <?= $nist_refs_controlfamily->controlarea_id->cellAttributes() ?>>
<span id="el_nist_refs_controlfamily_controlarea_id">
<span<?= $nist_refs_controlfamily->controlarea_id->viewAttributes() ?>>
<?= $nist_refs_controlfamily->controlarea_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
