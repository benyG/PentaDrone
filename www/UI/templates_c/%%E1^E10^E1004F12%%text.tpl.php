<?php ob_start(); ?>

    <input
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        class="form-control"
        value="<?php echo $this->_tpl_vars['Editor']->GetHTMLValue(); ?>
"
        <?php if ($this->_tpl_vars['Editor']->getPlaceholder()): ?>
            placeholder="<?php echo $this->_tpl_vars['Editor']->getPlaceholder(); ?>
"
        <?php endif; ?>
        <?php if ($this->_tpl_vars['Editor']->GetPasswordMode()): ?>
            type="password"
        <?php else: ?>
            type="text"
        <?php endif; ?>
        <?php if ($this->_tpl_vars['Editor']->GetMaxLength()): ?>
            maxlength="<?php echo $this->_tpl_vars['Editor']->GetMaxLength(); ?>
"
        <?php endif; ?>
        <?php if ($this->_tpl_vars['AdditionalProperties']): ?>
            <?php echo $this->_tpl_vars['AdditionalProperties']; ?>

        <?php endif; ?>
    >

<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('TextEditorContent', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/text_editor_wrapper.tpl", 'smarty_include_vars' => array('TextEditorContent' => $this->_tpl_vars['TextEditorContent'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
