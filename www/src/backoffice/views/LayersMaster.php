<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$layers = Container("layers");
?>
<?php if ($layers->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_layersmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($layers->name->Visible) { // name ?>
        <tr id="r_name">
            <td class="<?= $layers->TableLeftColumnClass ?>"><?= $layers->name->caption() ?></td>
            <td <?= $layers->name->cellAttributes() ?>>
<span id="el_layers_name">
<span<?= $layers->name->viewAttributes() ?>>
<?= $layers->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($layers->target_table->Visible) { // target_table ?>
        <tr id="r_target_table">
            <td class="<?= $layers->TableLeftColumnClass ?>"><?= $layers->target_table->caption() ?></td>
            <td <?= $layers->target_table->cellAttributes() ?>>
<span id="el_layers_target_table">
<span<?= $layers->target_table->viewAttributes() ?>>
<?= $layers->target_table->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($layers->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $layers->TableLeftColumnClass ?>"><?= $layers->created_at->caption() ?></td>
            <td <?= $layers->created_at->cellAttributes() ?>>
<span id="el_layers_created_at">
<span<?= $layers->created_at->viewAttributes() ?>>
<?= $layers->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($layers->updated_at->Visible) { // updated_at ?>
        <tr id="r_updated_at">
            <td class="<?= $layers->TableLeftColumnClass ?>"><?= $layers->updated_at->caption() ?></td>
            <td <?= $layers->updated_at->cellAttributes() ?>>
<span id="el_layers_updated_at">
<span<?= $layers->updated_at->viewAttributes() ?>>
<?= $layers->updated_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($layers->code_layer->Visible) { // code_layer ?>
        <tr id="r_code_layer">
            <td class="<?= $layers->TableLeftColumnClass ?>"><?= $layers->code_layer->caption() ?></td>
            <td <?= $layers->code_layer->cellAttributes() ?>>
<span id="el_layers_code_layer">
<span<?= $layers->code_layer->viewAttributes() ?>>
<?= $layers->code_layer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
