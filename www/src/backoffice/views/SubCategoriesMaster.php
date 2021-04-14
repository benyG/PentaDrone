<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$sub_categories = Container("sub_categories");
?>
<?php if ($sub_categories->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sub_categoriesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sub_categories->code_nist->Visible) { // code_nist ?>
        <tr id="r_code_nist">
            <td class="<?= $sub_categories->TableLeftColumnClass ?>"><?= $sub_categories->code_nist->caption() ?></td>
            <td <?= $sub_categories->code_nist->cellAttributes() ?>>
<span id="el_sub_categories_code_nist">
<span<?= $sub_categories->code_nist->viewAttributes() ?>>
<?= $sub_categories->code_nist->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sub_categories->statement->Visible) { // statement ?>
        <tr id="r_statement">
            <td class="<?= $sub_categories->TableLeftColumnClass ?>"><?= $sub_categories->statement->caption() ?></td>
            <td <?= $sub_categories->statement->cellAttributes() ?>>
<span id="el_sub_categories_statement">
<span<?= $sub_categories->statement->viewAttributes() ?>>
<?= $sub_categories->statement->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
