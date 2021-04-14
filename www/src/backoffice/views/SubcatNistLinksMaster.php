<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Table
$subcat_nist_links = Container("subcat_nist_links");
?>
<?php if ($subcat_nist_links->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_subcat_nist_linksmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($subcat_nist_links->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $subcat_nist_links->TableLeftColumnClass ?>"><?= $subcat_nist_links->id->caption() ?></td>
            <td <?= $subcat_nist_links->id->cellAttributes() ?>>
<span id="el_subcat_nist_links_id">
<span<?= $subcat_nist_links->id->viewAttributes() ?>>
<?= $subcat_nist_links->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($subcat_nist_links->subcat_id->Visible) { // subcat_id ?>
        <tr id="r_subcat_id">
            <td class="<?= $subcat_nist_links->TableLeftColumnClass ?>"><?= $subcat_nist_links->subcat_id->caption() ?></td>
            <td <?= $subcat_nist_links->subcat_id->cellAttributes() ?>>
<span id="el_subcat_nist_links_subcat_id">
<span<?= $subcat_nist_links->subcat_id->viewAttributes() ?>>
<?= $subcat_nist_links->subcat_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($subcat_nist_links->nistrefs_id->Visible) { // nistrefs_id ?>
        <tr id="r_nistrefs_id">
            <td class="<?= $subcat_nist_links->TableLeftColumnClass ?>"><?= $subcat_nist_links->nistrefs_id->caption() ?></td>
            <td <?= $subcat_nist_links->nistrefs_id->cellAttributes() ?>>
<span id="el_subcat_nist_links_nistrefs_id">
<span<?= $subcat_nist_links->nistrefs_id->viewAttributes() ?>>
<?= $subcat_nist_links->nistrefs_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
