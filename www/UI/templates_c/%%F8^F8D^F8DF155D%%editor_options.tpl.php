<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'style_block', 'editors/editor_options.tpl', 17, false),)), $this); ?>
<?php if ($this->_tpl_vars['id']): ?>id="<?php echo $this->_tpl_vars['id']; ?>
"<?php endif; ?>
name="<?php echo $this->_tpl_vars['Editor']->GetName(); ?>
<?php if ($this->_tpl_vars['Multiple']): ?>[]<?php endif; ?>"
data-editor="<?php echo $this->_tpl_vars['Editor']->getEditorName(); ?>
"
data-field-name="<?php echo $this->_tpl_vars['Editor']->GetFieldName(); ?>
"
<?php if (! $this->_tpl_vars['Editor']->getEnabled()): ?>
    disabled="disabled"
<?php endif; ?>
<?php if (! $this->_tpl_vars['Editor']->getVisible()): ?>
    data-editor-visible="false"
<?php endif; ?>
<?php if ($this->_tpl_vars['Editor']->GetReadonly()): ?>
    readonly="readonly"
<?php endif; ?>
<?php if ($this->_tpl_vars['Editor']->getCustomAttributes()): ?>
    <?php echo $this->_tpl_vars['Editor']->getCustomAttributes(); ?>

<?php endif; ?>
<?php $this->_tag_stack[] = array('style_block', array()); $_block_repeat=true;smarty_block_style_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo $this->_tpl_vars['Editor']->getInlineStyles(); ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_style_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php echo $this->_tpl_vars['ViewData']['Validators']['InputAttributes']; ?>