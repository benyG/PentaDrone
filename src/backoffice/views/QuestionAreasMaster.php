<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$question_areas = Container("question_areas");
?>
<?php if ($question_areas->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_question_areasmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($question_areas->area_name->Visible) { // area_name ?>
        <tr id="r_area_name">
            <td class="<?= $question_areas->TableLeftColumnClass ?>"><?= $question_areas->area_name->caption() ?></td>
            <td <?= $question_areas->area_name->cellAttributes() ?>>
<span id="el_question_areas_area_name">
<span<?= $question_areas->area_name->viewAttributes() ?>>
<?= $question_areas->area_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_areas->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $question_areas->TableLeftColumnClass ?>"><?= $question_areas->created_at->caption() ?></td>
            <td <?= $question_areas->created_at->cellAttributes() ?>>
<span id="el_question_areas_created_at">
<span<?= $question_areas->created_at->viewAttributes() ?>>
<?= $question_areas->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_areas->updated_at->Visible) { // updated_at ?>
        <tr id="r_updated_at">
            <td class="<?= $question_areas->TableLeftColumnClass ?>"><?= $question_areas->updated_at->caption() ?></td>
            <td <?= $question_areas->updated_at->cellAttributes() ?>>
<span id="el_question_areas_updated_at">
<span<?= $question_areas->updated_at->viewAttributes() ?>>
<?= $question_areas->updated_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
