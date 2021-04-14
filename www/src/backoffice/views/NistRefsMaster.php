<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Table
$nist_refs = Container("nist_refs");
?>
<?php if ($nist_refs->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_nist_refsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($nist_refs->Nidentifier->Visible) { // Nidentifier ?>
        <tr id="r_Nidentifier">
            <td class="<?= $nist_refs->TableLeftColumnClass ?>"><?= $nist_refs->Nidentifier->caption() ?></td>
            <td <?= $nist_refs->Nidentifier->cellAttributes() ?>>
<span id="el_nist_refs_Nidentifier">
<span<?= $nist_refs->Nidentifier->viewAttributes() ?>>
<?= $nist_refs->Nidentifier->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_refs->N_ordre->Visible) { // N_ordre ?>
        <tr id="r_N_ordre">
            <td class="<?= $nist_refs->TableLeftColumnClass ?>"><?= $nist_refs->N_ordre->caption() ?></td>
            <td <?= $nist_refs->N_ordre->cellAttributes() ?>>
<span id="el_nist_refs_N_ordre">
<span<?= $nist_refs->N_ordre->viewAttributes() ?>>
<?= $nist_refs->N_ordre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_refs->Control_Family_id->Visible) { // Control_Family_id ?>
        <tr id="r_Control_Family_id">
            <td class="<?= $nist_refs->TableLeftColumnClass ?>"><?= $nist_refs->Control_Family_id->caption() ?></td>
            <td <?= $nist_refs->Control_Family_id->cellAttributes() ?>>
<span id="el_nist_refs_Control_Family_id">
<span<?= $nist_refs->Control_Family_id->viewAttributes() ?>>
<?= $nist_refs->Control_Family_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_refs->Control_Name->Visible) { // Control_Name ?>
        <tr id="r_Control_Name">
            <td class="<?= $nist_refs->TableLeftColumnClass ?>"><?= $nist_refs->Control_Name->caption() ?></td>
            <td <?= $nist_refs->Control_Name->cellAttributes() ?>>
<span id="el_nist_refs_Control_Name">
<span<?= $nist_refs->Control_Name->viewAttributes() ?>>
<?= $nist_refs->Control_Name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
