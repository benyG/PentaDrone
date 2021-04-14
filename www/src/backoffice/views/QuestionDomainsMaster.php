<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$question_domains = Container("question_domains");
?>
<?php if ($question_domains->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_question_domainsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($question_domains->domain_name->Visible) { // domain_name ?>
        <tr id="r_domain_name">
            <td class="<?= $question_domains->TableLeftColumnClass ?>"><?= $question_domains->domain_name->caption() ?></td>
            <td <?= $question_domains->domain_name->cellAttributes() ?>>
<span id="el_question_domains_domain_name">
<span<?= $question_domains->domain_name->viewAttributes() ?>>
<?= $question_domains->domain_name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_domains->question_area_id->Visible) { // question_area_id ?>
        <tr id="r_question_area_id">
            <td class="<?= $question_domains->TableLeftColumnClass ?>"><?= $question_domains->question_area_id->caption() ?></td>
            <td <?= $question_domains->question_area_id->cellAttributes() ?>>
<span id="el_question_domains_question_area_id">
<span<?= $question_domains->question_area_id->viewAttributes() ?>>
<?= $question_domains->question_area_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_domains->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $question_domains->TableLeftColumnClass ?>"><?= $question_domains->created_at->caption() ?></td>
            <td <?= $question_domains->created_at->cellAttributes() ?>>
<span id="el_question_domains_created_at">
<span<?= $question_domains->created_at->viewAttributes() ?>>
<?= $question_domains->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($question_domains->updated_at->Visible) { // updated_at ?>
        <tr id="r_updated_at">
            <td class="<?= $question_domains->TableLeftColumnClass ?>"><?= $question_domains->updated_at->caption() ?></td>
            <td <?= $question_domains->updated_at->cellAttributes() ?>>
<span id="el_question_domains_updated_at">
<span<?= $question_domains->updated_at->viewAttributes() ?>>
<?= $question_domains->updated_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
