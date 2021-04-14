<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Table
$controls_library = Container("controls_library");
?>
<?php if ($controls_library->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_controls_librarymaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($controls_library->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $controls_library->TableLeftColumnClass ?>"><?= $controls_library->id->caption() ?></td>
            <td <?= $controls_library->id->cellAttributes() ?>>
<span id="el_controls_library_id">
<span<?= $controls_library->id->viewAttributes() ?>>
<?= $controls_library->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($controls_library->nist_subcategory_id->Visible) { // nist_subcategory_id ?>
        <tr id="r_nist_subcategory_id">
            <td class="<?= $controls_library->TableLeftColumnClass ?>"><?= $controls_library->nist_subcategory_id->caption() ?></td>
            <td <?= $controls_library->nist_subcategory_id->cellAttributes() ?>>
<span id="el_controls_library_nist_subcategory_id">
<span<?= $controls_library->nist_subcategory_id->viewAttributes() ?>>
<?= $controls_library->nist_subcategory_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($controls_library->title->Visible) { // title ?>
        <tr id="r_title">
            <td class="<?= $controls_library->TableLeftColumnClass ?>"><?= $controls_library->title->caption() ?></td>
            <td <?= $controls_library->title->cellAttributes() ?>>
<span id="el_controls_library_title">
<span<?= $controls_library->title->viewAttributes() ?>>
<?= $controls_library->title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($controls_library->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $controls_library->TableLeftColumnClass ?>"><?= $controls_library->created_at->caption() ?></td>
            <td <?= $controls_library->created_at->cellAttributes() ?>>
<span id="el_controls_library_created_at">
<span<?= $controls_library->created_at->viewAttributes() ?>>
<?= $controls_library->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($controls_library->updated_at->Visible) { // updated_at ?>
        <tr id="r_updated_at">
            <td class="<?= $controls_library->TableLeftColumnClass ?>"><?= $controls_library->updated_at->caption() ?></td>
            <td <?= $controls_library->updated_at->cellAttributes() ?>>
<span id="el_controls_library_updated_at">
<span<?= $controls_library->updated_at->viewAttributes() ?>>
<?= $controls_library->updated_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
