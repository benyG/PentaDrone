<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'editors/dynamic_combobox.tpl', 10, false),)), $this); ?>
<div class="input-group" style="width: 100%">
	<input
		type="hidden"
		class="form-control<?php if ($this->_tpl_vars['ColumnViewData']['NestedInsertFormLink']): ?> form-control-nested-form<?php endif; ?>"
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		data-placeholder="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PleaseSelect'); ?>
"
		data-url="<?php echo $this->_tpl_vars['Editor']->GetDataUrl(); ?>
"
		data-minimal-input-length="<?php echo $this->_tpl_vars['Editor']->getMinimumInputLength(); ?>
"
		<?php if ($this->_tpl_vars['Editor']->getFormatResult()): ?>
			data-format-result="<?php echo ((is_array($_tmp=$this->_tpl_vars['Editor']->getFormatResult())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
		<?php endif; ?>
		<?php if ($this->_tpl_vars['Editor']->getFormatSelection()): ?>
			data-format-selection="<?php echo ((is_array($_tmp=$this->_tpl_vars['Editor']->getFormatSelection())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
		<?php endif; ?>
		<?php if ($this->_tpl_vars['Editor']->GetReadonly()): ?>readonly="readonly"<?php endif; ?>
		<?php if ($this->_tpl_vars['Editor']->getAllowClear()): ?>data-allowClear="true"<?php endif; ?>
		value="<?php echo $this->_tpl_vars['Editor']->GetValue(); ?>
"
	/>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'editors/nested_insert_button.tpl', 'smarty_include_vars' => array('NestedInsertFormLink' => $this->_tpl_vars['ColumnViewData']['NestedInsertFormLink'],'LookupDisplayFieldName' => $this->_tpl_vars['ColumnViewData']['DisplayFieldName'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>