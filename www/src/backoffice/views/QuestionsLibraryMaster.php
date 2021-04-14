<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Table
$questions_library = Container("questions_library");
?>
<?php if ($questions_library->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_questions_librarymaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($questions_library->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $questions_library->TableLeftColumnClass ?>"><?= $questions_library->id->caption() ?></td>
            <td <?= $questions_library->id->cellAttributes() ?>>
<span id="el_questions_library_id">
<span<?= $questions_library->id->viewAttributes() ?>>
<?= $questions_library->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($questions_library->libelle->Visible) { // libelle ?>
        <tr id="r_libelle">
            <td class="<?= $questions_library->TableLeftColumnClass ?>"><?= $questions_library->libelle->caption() ?></td>
            <td <?= $questions_library->libelle->cellAttributes() ?>>
<span id="el_questions_library_libelle">
<span<?= $questions_library->libelle->viewAttributes() ?>>
<?= $questions_library->libelle->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($questions_library->controlObj_id->Visible) { // controlObj_id ?>
        <tr id="r_controlObj_id">
            <td class="<?= $questions_library->TableLeftColumnClass ?>"><?= $questions_library->controlObj_id->caption() ?></td>
            <td <?= $questions_library->controlObj_id->cellAttributes() ?>>
<span id="el_questions_library_controlObj_id">
<span<?= $questions_library->controlObj_id->viewAttributes() ?>>
<?= $questions_library->controlObj_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
