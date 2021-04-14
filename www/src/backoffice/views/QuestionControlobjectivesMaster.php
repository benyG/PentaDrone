<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$question_controlobjectives = Container("question_controlobjectives");
?>
<?php if ($question_controlobjectives->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_question_controlobjectivesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($question_controlobjectives->num_ordre->Visible) { // num_ordre ?>
        <tr id="r_num_ordre">
            <td class="<?= $question_controlobjectives->TableLeftColumnClass ?>"><?= $question_controlobjectives->num_ordre->caption() ?></td>
            <td <?= $question_controlobjectives->num_ordre->cellAttributes() ?>>
<span id="el_question_controlobjectives_num_ordre">
<span<?= $question_controlobjectives->num_ordre->viewAttributes() ?>>
<?= $question_controlobjectives->num_ordre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_controlobjectives->controlObj_name->Visible) { // controlObj_name ?>
        <tr id="r_controlObj_name">
            <td class="<?= $question_controlobjectives->TableLeftColumnClass ?>"><?= $question_controlobjectives->controlObj_name->caption() ?></td>
            <td <?= $question_controlobjectives->controlObj_name->cellAttributes() ?>>
<span id="el_question_controlobjectives_controlObj_name">
<span<?= $question_controlobjectives->controlObj_name->viewAttributes() ?>>
<?= $question_controlobjectives->controlObj_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_controlobjectives->question_domain_id->Visible) { // question_domain_id ?>
        <tr id="r_question_domain_id">
            <td class="<?= $question_controlobjectives->TableLeftColumnClass ?>"><?= $question_controlobjectives->question_domain_id->caption() ?></td>
            <td <?= $question_controlobjectives->question_domain_id->cellAttributes() ?>>
<span id="el_question_controlobjectives_question_domain_id">
<span<?= $question_controlobjectives->question_domain_id->viewAttributes() ?>>
<?= $question_controlobjectives->question_domain_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_controlobjectives->layer_id->Visible) { // layer_id ?>
        <tr id="r_layer_id">
            <td class="<?= $question_controlobjectives->TableLeftColumnClass ?>"><?= $question_controlobjectives->layer_id->caption() ?></td>
            <td <?= $question_controlobjectives->layer_id->cellAttributes() ?>>
<span id="el_question_controlobjectives_layer_id">
<span<?= $question_controlobjectives->layer_id->viewAttributes() ?>>
<?= $question_controlobjectives->layer_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_controlobjectives->function_csf->Visible) { // function_csf ?>
        <tr id="r_function_csf">
            <td class="<?= $question_controlobjectives->TableLeftColumnClass ?>"><?= $question_controlobjectives->function_csf->caption() ?></td>
            <td <?= $question_controlobjectives->function_csf->cellAttributes() ?>>
<span id="el_question_controlobjectives_function_csf">
<span<?= $question_controlobjectives->function_csf->viewAttributes() ?>>
<?= $question_controlobjectives->function_csf->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_controlobjectives->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $question_controlobjectives->TableLeftColumnClass ?>"><?= $question_controlobjectives->created_at->caption() ?></td>
            <td <?= $question_controlobjectives->created_at->cellAttributes() ?>>
<span id="el_question_controlobjectives_created_at">
<span<?= $question_controlobjectives->created_at->viewAttributes() ?>>
<?= $question_controlobjectives->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_controlobjectives->updated_at->Visible) { // updated_at ?>
        <tr id="r_updated_at">
            <td class="<?= $question_controlobjectives->TableLeftColumnClass ?>"><?= $question_controlobjectives->updated_at->caption() ?></td>
            <td <?= $question_controlobjectives->updated_at->cellAttributes() ?>>
<span id="el_question_controlobjectives_updated_at">
<span<?= $question_controlobjectives->updated_at->viewAttributes() ?>>
<?= $question_controlobjectives->updated_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
