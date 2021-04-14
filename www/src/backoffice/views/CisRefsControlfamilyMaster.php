<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$cis_refs_controlfamily = Container("cis_refs_controlfamily");
?>
<?php if ($cis_refs_controlfamily->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cis_refs_controlfamilymaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cis_refs_controlfamily->code->Visible) { // code ?>
        <tr id="r_code">
            <td class="<?= $cis_refs_controlfamily->TableLeftColumnClass ?>"><?= $cis_refs_controlfamily->code->caption() ?></td>
            <td <?= $cis_refs_controlfamily->code->cellAttributes() ?>>
<span id="el_cis_refs_controlfamily_code">
<span<?= $cis_refs_controlfamily->code->viewAttributes() ?>>
<?= $cis_refs_controlfamily->code->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cis_refs_controlfamily->control_familyName->Visible) { // control_familyName ?>
        <tr id="r_control_familyName">
            <td class="<?= $cis_refs_controlfamily->TableLeftColumnClass ?>"><?= $cis_refs_controlfamily->control_familyName->caption() ?></td>
            <td <?= $cis_refs_controlfamily->control_familyName->cellAttributes() ?>>
<span id="el_cis_refs_controlfamily_control_familyName">
<span<?= $cis_refs_controlfamily->control_familyName->viewAttributes() ?>>
<?= $cis_refs_controlfamily->control_familyName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
