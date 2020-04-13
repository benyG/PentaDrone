<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'to_json', 'list/grid_common.tpl', 36, false),array('modifier', 'escape', 'list/grid_common.tpl', 44, false),array('modifier', 'array_keys', 'list/grid_common.tpl', 46, false),)), $this); ?>
<?php if (! $this->_tpl_vars['isInline']): ?>
    <?php if (! $this->_tpl_vars['isMasterGrid'] && $this->_tpl_vars['DataGrid']['EnableSortDialog']): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/multiple_sorting.tpl", 'smarty_include_vars' => array('GridId' => $this->_tpl_vars['DataGrid']['Id'],'Levels' => $this->_tpl_vars['DataGrid']['DataSortPriority'],'SortableHeaders' => $this->_tpl_vars['DataGrid']['SortableColumns'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['DataGrid']['FilterBuilder']->hasColumns()): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/filter_builder.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['DataGrid']['ColumnFilter']->hasColumns()): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/column_filter.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
<?php endif; ?>

<script type="text/javascript"><?php echo ''; ?><?php echo '
(function () {
    var gridData = {
        filterBuilder: {
            columns: [],
            data: {}
        },
        columnFilter: {
            columns: [],
            isSearchEnabled: {},
            excludedComponents: {},
            data: {}
        },
        quickFilter: {
            columns: [],
        }
    };
    '; ?><?php echo ''; ?><?php if (! $this->_tpl_vars['isInline']): ?><?php echo ''; ?><?php echo '
            gridData.filterBuilder.data = '; ?><?php echo ''; ?><?php echo smarty_function_to_json(array('value' => $this->_tpl_vars['DataGrid']['FilterBuilder']->serialize()), $this);?><?php echo ''; ?><?php echo ';
        '; ?><?php echo ''; ?><?php $_from = $this->_tpl_vars['DataGrid']['FilterBuilder']->getColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?><?php echo ''; ?><?php $this->assign('operators', $this->_tpl_vars['DataGrid']['FilterBuilder']->getOperators($this->_tpl_vars['column'])); ?><?php echo ''; ?><?php echo '
            gridData.filterBuilder.columns.push({
                '; ?><?php echo 'fieldName: \''; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['column']->getFieldName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?><?php echo '\',caption: \''; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['column']->getCaption())) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?><?php echo '\',operators: '; ?><?php echo smarty_function_to_json(array('value' => array_keys($this->_tpl_vars['operators'])), $this);?><?php echo ''; ?><?php echo '
            });
        '; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php echo '

        gridData.columnFilter.data = '; ?><?php echo ''; ?><?php echo smarty_function_to_json(array('value' => $this->_tpl_vars['DataGrid']['ColumnFilter']->serialize()), $this);?><?php echo ''; ?><?php echo ';
        gridData.columnFilter.isDefaultsEnabled = '; ?><?php echo ''; ?><?php echo smarty_function_to_json(array('value' => $this->_tpl_vars['DataGrid']['ColumnFilter']->getDefaultsEnabled()), $this);?><?php echo ''; ?><?php echo ';

        '; ?><?php echo ''; ?><?php $_from = $this->_tpl_vars['DataGrid']['ColumnFilter']->getColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?><?php echo ''; ?><?php echo '
            gridData.columnFilter.columns.push({
                fieldName: '; ?><?php echo '\''; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['column']->getFieldName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?><?php echo '\''; ?><?php echo ',
                caption: '; ?><?php echo '\''; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['column']->getCaption())) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?><?php echo '\''; ?><?php echo ',
                typeIsDateTime: '; ?><?php echo '\''; ?><?php echo $this->_tpl_vars['column']->typeIsDateTime(); ?><?php echo '\''; ?><?php echo '
            });
        '; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo 'gridData.quickFilter.columns = '; ?><?php echo smarty_function_to_json(array('value' => $this->_tpl_vars['DataGrid']['QuickFilter']->getColumnNames()), $this);?><?php echo ';'; ?><?php endif; ?><?php echo ''; ?><?php echo '
    window.gridData_'; ?><?php echo ''; ?><?php echo $this->_tpl_vars['DataGrid']['Id']; ?><?php echo ''; ?><?php echo ' = gridData;
})();
'; ?><?php echo ''; ?>
</script>