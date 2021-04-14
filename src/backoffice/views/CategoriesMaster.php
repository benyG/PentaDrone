<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$categories = Container("categories");
?>
<?php if ($categories->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_categoriesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($categories->code_nist->Visible) { // code_nist ?>
        <tr id="r_code_nist">
            <td class="<?= $categories->TableLeftColumnClass ?>"><?= $categories->code_nist->caption() ?></td>
            <td <?= $categories->code_nist->cellAttributes() ?>>
<span id="el_categories_code_nist">
<span<?= $categories->code_nist->viewAttributes() ?>>
<?= $categories->code_nist->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($categories->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $categories->TableLeftColumnClass ?>"><?= $categories->name->caption() ?></td>
            <td <?= $categories->name->cellAttributes() ?>>
<span id="el_categories_name">
<span<?= $categories->name->viewAttributes() ?>>
<?= $categories->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($categories->description->Visible) { // description ?>
        <tr id="r_description">
            <td class="<?= $categories->TableLeftColumnClass ?>"><?= $categories->description->caption() ?></td>
            <td <?= $categories->description->cellAttributes() ?>>
<span id="el_categories_description">
<span<?= $categories->description->viewAttributes() ?>>
<?= $categories->description->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
