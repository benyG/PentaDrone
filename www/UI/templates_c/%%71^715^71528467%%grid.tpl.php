<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'list/grid.tpl', 6, false),)), $this); ?>
<div<?php if ($this->_tpl_vars['DataGrid']['MaxWidth']): ?> style="max-width: <?php echo $this->_tpl_vars['DataGrid']['MaxWidth']; ?>
"<?php endif; ?>
        class="grid grid-table<?php if ($this->_tpl_vars['isMasterGrid']): ?> grid-master<?php endif; ?><?php if ($this->_tpl_vars['GridClass']): ?> <?php echo $this->_tpl_vars['GridClass']; ?>
<?php endif; ?> js-grid"
        id="<?php echo $this->_tpl_vars['DataGrid']['Id']; ?>
"
        data-selection-id="<?php echo $this->_tpl_vars['DataGrid']['SelectionId']; ?>
"
        data-is-master="<?php echo $this->_tpl_vars['isMasterGrid']; ?>
"
        data-grid-hidden-values="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['HiddenValuesJson'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"
        data-sortable-columns="<?php if (! $this->_tpl_vars['isInline']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['SortableColumnsJSON'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php else: ?>[]<?php endif; ?>"
        data-column-count="<?php echo $this->_tpl_vars['DataGrid']['ColumnCount']; ?>
"
        <?php echo $this->_tpl_vars['DataGrid']['Attributes']; ?>
>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php echo $this->_tpl_vars['GridContent']; ?>


    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_common.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>