<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$cobit5_refs = Container("cobit5_refs");
?>
<?php if ($cobit5_refs->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cobit5_refsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cobit5_refs->NIdentifier->Visible) { // NIdentifier ?>
        <tr id="r_NIdentifier">
            <td class="<?= $cobit5_refs->TableLeftColumnClass ?>"><?= $cobit5_refs->NIdentifier->caption() ?></td>
            <td <?= $cobit5_refs->NIdentifier->cellAttributes() ?>>
<span id="el_cobit5_refs_NIdentifier">
<span<?= $cobit5_refs->NIdentifier->viewAttributes() ?>>
<?= $cobit5_refs->NIdentifier->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cobit5_refs->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $cobit5_refs->TableLeftColumnClass ?>"><?= $cobit5_refs->name->caption() ?></td>
            <td <?= $cobit5_refs->name->cellAttributes() ?>>
<span id="el_cobit5_refs_name">
<span<?= $cobit5_refs->name->viewAttributes() ?>>
<?= $cobit5_refs->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cobit5_refs->description->Visible) { // description ?>
        <tr id="r_description">
            <td class="<?= $cobit5_refs->TableLeftColumnClass ?>"><?= $cobit5_refs->description->caption() ?></td>
            <td <?= $cobit5_refs->description->cellAttributes() ?>>
<span id="el_cobit5_refs_description">
<span<?= $cobit5_refs->description->viewAttributes() ?>>
<?= $cobit5_refs->description->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cobit5_refs->code_cobitfamily->Visible) { // code_cobitfamily ?>
        <tr id="r_code_cobitfamily">
            <td class="<?= $cobit5_refs->TableLeftColumnClass ?>"><?= $cobit5_refs->code_cobitfamily->caption() ?></td>
            <td <?= $cobit5_refs->code_cobitfamily->cellAttributes() ?>>
<span id="el_cobit5_refs_code_cobitfamily">
<span<?= $cobit5_refs->code_cobitfamily->viewAttributes() ?>>
<?= $cobit5_refs->code_cobitfamily->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
