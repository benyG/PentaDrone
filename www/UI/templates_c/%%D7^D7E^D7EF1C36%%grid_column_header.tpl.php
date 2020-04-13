<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'list/grid_column_header.tpl', 3, false),array('function', 'to_json', 'list/grid_column_header.tpl', 29, false),)), $this); ?>
<th
    colspan="<?php echo $this->_tpl_vars['child']->getColSpan(); ?>
"
    rowspan="<?php echo smarty_function_math(array('equation' => 'x-y-z','x' => $this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth(),'y' => $this->_tpl_vars['childDepth'],'z' => $this->_tpl_vars['depth']), $this);?>
"
    <?php if ($this->_tpl_vars['childDepth'] == 0): ?>
        class="<?php echo $this->_tpl_vars['child']->GetGridColumnClass(); ?>
<?php if ($this->_tpl_vars['child']->allowSorting() && $this->_tpl_vars['DataGrid']['allowSortingByClick'] && ! $this->_tpl_vars['isInline']): ?> sortable<?php endif; ?><?php if ($this->_tpl_vars['DataGrid']['ColumnFilter'] && $this->_tpl_vars['DataGrid']['ColumnFilter']->hasColumn($this->_tpl_vars['child']->getName())): ?> filterable<?php endif; ?>"

        <?php if ($this->_tpl_vars['child']->GetFixedWidth()): ?>
            style="width: <?php echo $this->_tpl_vars['child']->GetFixedWidth(); ?>
;"
        <?php endif; ?>
        data-field-caption="<?php echo $this->_tpl_vars['child']->getCaption(); ?>
"
        data-name="<?php echo $this->_tpl_vars['child']->getName(); ?>
"
        data-field-name="<?php echo $this->_tpl_vars['child']->getFieldName(); ?>
"
        data-column-name="<?php echo $this->_tpl_vars['child']->getFieldName(); ?>
"
        data-sort-index="<?php echo $this->_tpl_vars['child']->getSortIndex(); ?>
"
        <?php if ($this->_tpl_vars['child']->getSortOrderType() == 'ASC'): ?>
            data-sort-order="asc"
        <?php elseif ($this->_tpl_vars['child']->getSortOrderType() == 'DESC'): ?>
            data-sort-order="desc"
        <?php endif; ?>
        <?php if ($this->_tpl_vars['child']->getDescription()): ?>data-comment="<?php echo $this->_tpl_vars['child']->GetDescription(); ?>
"<?php endif; ?>>
        <?php $this->assign('keys', $this->_tpl_vars['child']->GetActualKeys()); ?>
        <?php if ($this->_tpl_vars['keys']['Primary'] && $this->_tpl_vars['keys']['Foreign']): ?>
            <i class="icon-keys-pk-fk"></i>
        <?php elseif ($this->_tpl_vars['keys']['Primary']): ?>
            <i class="icon-keys-pk"></i>
        <?php elseif ($this->_tpl_vars['keys']['Foreign']): ?>
            <i class="icon-keys-fk"></i>
        <?php endif; ?>
    <?php else: ?>class="js-column-group <?php echo $this->_tpl_vars['child']->GetGridColumnClass(); ?>
" data-visibility="<?php echo smarty_function_to_json(array('value' => $this->_tpl_vars['child']->getVisibilityMap(),'escape' => true), $this);?>
"><?php endif; ?>
    <?php echo '<span'; ?><?php if ($this->_tpl_vars['childDepth'] == 0 && $this->_tpl_vars['child']->getDescription()): ?><?php echo ' class="commented"'; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['child']->getCaption(); ?><?php echo '</span>'; ?><?php if ($this->_tpl_vars['childDepth'] === 0 && ! $this->_tpl_vars['isInline'] && ! $this->_tpl_vars['isMasterGrid']): ?><?php echo ''; ?><?php if ($this->_tpl_vars['child']->getSortOrderType() == 'ASC'): ?><?php echo '<i class="icon-sort-asc"></i>'; ?><?php elseif ($this->_tpl_vars['child']->getSortOrderType() == 'DESC'): ?><?php echo '<i class="icon-sort-desc"></i>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['DataGrid']['ColumnFilter'] && $this->_tpl_vars['DataGrid']['ColumnFilter']->hasColumn($this->_tpl_vars['child']->getName())): ?><?php echo '<a href="#" class="column-filter-trigger'; ?><?php if ($this->_tpl_vars['DataGrid']['ColumnFilter']->isColumnActive($this->_tpl_vars['child']->getName())): ?><?php echo ' column-filter-trigger-active'; ?><?php endif; ?><?php echo ' js-filter-trigger" title="'; ?><?php echo $this->_tpl_vars['DataGrid']['ColumnFilter']->toStringFor($this->_tpl_vars['child']->getName(),$this->_tpl_vars['Captions']); ?><?php echo '"><i class="icon-filter"></i></a>'; ?><?php endif; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?>

</th>