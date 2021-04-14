<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$cis_refs = Container("cis_refs");
?>
<?php if ($cis_refs->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cis_refsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cis_refs->Nidentifier->Visible) { // Nidentifier ?>
        <tr id="r_Nidentifier">
            <td class="<?= $cis_refs->TableLeftColumnClass ?>"><?= $cis_refs->Nidentifier->caption() ?></td>
            <td <?= $cis_refs->Nidentifier->cellAttributes() ?>>
<span id="el_cis_refs_Nidentifier">
<span<?= $cis_refs->Nidentifier->viewAttributes() ?>>
<?= $cis_refs->Nidentifier->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cis_refs->Control_Family_id->Visible) { // Control_Family_id ?>
        <tr id="r_Control_Family_id">
            <td class="<?= $cis_refs->TableLeftColumnClass ?>"><?= $cis_refs->Control_Family_id->caption() ?></td>
            <td <?= $cis_refs->Control_Family_id->cellAttributes() ?>>
<span id="el_cis_refs_Control_Family_id">
<span<?= $cis_refs->Control_Family_id->viewAttributes() ?>>
<?= $cis_refs->Control_Family_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cis_refs->control_Name->Visible) { // control_Name ?>
        <tr id="r_control_Name">
            <td class="<?= $cis_refs->TableLeftColumnClass ?>"><?= $cis_refs->control_Name->caption() ?></td>
            <td <?= $cis_refs->control_Name->cellAttributes() ?>>
<span id="el_cis_refs_control_Name">
<span<?= $cis_refs->control_Name->viewAttributes() ?>>
<?= $cis_refs->control_Name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cis_refs->impl_group1->Visible) { // impl_group1 ?>
        <tr id="r_impl_group1">
            <td class="<?= $cis_refs->TableLeftColumnClass ?>"><?= $cis_refs->impl_group1->caption() ?></td>
            <td <?= $cis_refs->impl_group1->cellAttributes() ?>>
<span id="el_cis_refs_impl_group1">
<span<?= $cis_refs->impl_group1->viewAttributes() ?>>
<?= $cis_refs->impl_group1->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cis_refs->impl_group2->Visible) { // impl_group2 ?>
        <tr id="r_impl_group2">
            <td class="<?= $cis_refs->TableLeftColumnClass ?>"><?= $cis_refs->impl_group2->caption() ?></td>
            <td <?= $cis_refs->impl_group2->cellAttributes() ?>>
<span id="el_cis_refs_impl_group2">
<span<?= $cis_refs->impl_group2->viewAttributes() ?>>
<?= $cis_refs->impl_group2->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cis_refs->impl_group3->Visible) { // impl_group3 ?>
        <tr id="r_impl_group3">
            <td class="<?= $cis_refs->TableLeftColumnClass ?>"><?= $cis_refs->impl_group3->caption() ?></td>
            <td <?= $cis_refs->impl_group3->cellAttributes() ?>>
<span id="el_cis_refs_impl_group3">
<span<?= $cis_refs->impl_group3->viewAttributes() ?>>
<?= $cis_refs->impl_group3->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
