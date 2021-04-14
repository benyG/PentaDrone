<?php

namespace PHPMaker2021\ITaudit_backoffice;

// Table
$risk_librairies = Container("risk_librairies");
?>
<?php if ($risk_librairies->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_risk_librairiesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($risk_librairies->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $risk_librairies->TableLeftColumnClass ?>"><?= $risk_librairies->id->caption() ?></td>
            <td <?= $risk_librairies->id->cellAttributes() ?>>
<span id="el_risk_librairies_id">
<span<?= $risk_librairies->id->viewAttributes() ?>>
<?= $risk_librairies->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risk_librairies->title->Visible) { // title ?>
        <tr id="r_title">
            <td class="<?= $risk_librairies->TableLeftColumnClass ?>"><?= $risk_librairies->title->caption() ?></td>
            <td <?= $risk_librairies->title->cellAttributes() ?>>
<span id="el_risk_librairies_title">
<span<?= $risk_librairies->title->viewAttributes() ?>>
<?= $risk_librairies->title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
