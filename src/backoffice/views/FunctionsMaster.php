<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$functions = Container("functions");
?>
<?php if ($functions->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_functionsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($functions->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $functions->TableLeftColumnClass ?>"><?= $functions->id->caption() ?></td>
            <td <?= $functions->id->cellAttributes() ?>>
<span id="el_functions_id">
<span<?= $functions->id->viewAttributes() ?>>
<?= $functions->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($functions->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $functions->TableLeftColumnClass ?>"><?= $functions->name->caption() ?></td>
            <td <?= $functions->name->cellAttributes() ?>>
<span id="el_functions_name">
<span<?= $functions->name->viewAttributes() ?>>
<?= $functions->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
