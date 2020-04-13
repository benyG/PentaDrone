<div class="input-group" style="width: 100%">
    <input
        type="hidden"
        class="form-control"
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        data-max-selection-size="<?php echo $this->_tpl_vars['Editor']->getMaxSelectionSize(); ?>
"
        data-placeholder="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PleaseSelect'); ?>
"
        data-url="<?php echo $this->_tpl_vars['Editor']->GetDataUrl(); ?>
"
        value="<?php echo $this->_tpl_vars['Editor']->GetValue(); ?>
"
    />
</div>