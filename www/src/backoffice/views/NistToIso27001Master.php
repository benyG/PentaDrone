<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$nist_to_iso27001 = Container("nist_to_iso27001");
?>
<?php if ($nist_to_iso27001->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_nist_to_iso27001master" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($nist_to_iso27001->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $nist_to_iso27001->TableLeftColumnClass ?>"><?= $nist_to_iso27001->id->caption() ?></td>
            <td <?= $nist_to_iso27001->id->cellAttributes() ?>>
<span id="el_nist_to_iso27001_id">
<span<?= $nist_to_iso27001->id->viewAttributes() ?>>
<?= $nist_to_iso27001->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_to_iso27001->nistrefs_family->Visible) { // nistrefs_family ?>
        <tr id="r_nistrefs_family">
            <td class="<?= $nist_to_iso27001->TableLeftColumnClass ?>"><?= $nist_to_iso27001->nistrefs_family->caption() ?></td>
            <td <?= $nist_to_iso27001->nistrefs_family->cellAttributes() ?>>
<span id="el_nist_to_iso27001_nistrefs_family">
<span<?= $nist_to_iso27001->nistrefs_family->viewAttributes() ?>>
<?= $nist_to_iso27001->nistrefs_family->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_to_iso27001->isorefs->Visible) { // isorefs ?>
        <tr id="r_isorefs">
            <td class="<?= $nist_to_iso27001->TableLeftColumnClass ?>"><?= $nist_to_iso27001->isorefs->caption() ?></td>
            <td <?= $nist_to_iso27001->isorefs->cellAttributes() ?>>
<span id="el_nist_to_iso27001_isorefs">
<span<?= $nist_to_iso27001->isorefs->viewAttributes() ?>>
<?= $nist_to_iso27001->isorefs->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nist_to_iso27001->just_for_question_link->Visible) { // just_for_question_link ?>
        <tr id="r_just_for_question_link">
            <td class="<?= $nist_to_iso27001->TableLeftColumnClass ?>"><?= $nist_to_iso27001->just_for_question_link->caption() ?></td>
            <td <?= $nist_to_iso27001->just_for_question_link->cellAttributes() ?>>
<span id="el_nist_to_iso27001_just_for_question_link">
<span<?= $nist_to_iso27001->just_for_question_link->viewAttributes() ?>>
<?= $nist_to_iso27001->just_for_question_link->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
