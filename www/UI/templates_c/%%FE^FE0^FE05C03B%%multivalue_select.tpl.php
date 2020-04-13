<select class="form-control" multiple
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'],'Multiple' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    data-max-selection-size="<?php echo $this->_tpl_vars['Editor']->getMaxSelectionSize(); ?>
">
    <?php $_from = $this->_tpl_vars['Editor']->getChoices(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['displayValue']):
?>
        <option value="<?php echo $this->_tpl_vars['value']; ?>
"<?php if ($this->_tpl_vars['Editor']->hasValue($this->_tpl_vars['value'])): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['displayValue']; ?>
</option>
    <?php endforeach; endif; unset($_from); ?>
</select>