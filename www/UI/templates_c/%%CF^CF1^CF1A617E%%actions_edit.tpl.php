<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'forms/actions_edit.tpl', 26, false),)), $this); ?>
<?php ob_start(); ?>

    <div class="btn-group">
        <button type="submit" class="btn btn-primary js-save js-primary-save" data-action="open" data-url="<?php echo $this->_tpl_vars['Grid']['CancelUrl']; ?>
">
            <?php if ($this->_tpl_vars['isMultiEditOperation']): ?>
                <?php echo $this->_tpl_vars['Captions']->GetMessageString('Update'); ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['Captions']->GetMessageString('Save'); ?>

            <?php endif; ?>
        </button>
        <?php if (! $this->_tpl_vars['isMultiEditOperation']): ?>
        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="js-save" data-action="open" data-url="<?php echo $this->_tpl_vars['Grid']['CancelUrl']; ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveAndBackToList'); ?>
</a></li>
            <li><a href="#" class="js-save js-multiple-insert-hide" data-action="edit"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveAndEdit'); ?>
</a></li>
            <li><a href="#" class="js-save js-save-insert" data-action="open" data-url="<?php echo $this->_tpl_vars['Grid']['InsertUrl']; ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveAndInsert'); ?>
</a></li>

            <?php if ($this->_tpl_vars['Grid']['Details'] && count ( $this->_tpl_vars['Grid']['Details'] ) > 0): ?>
                <li class="divider js-multiple-insert-hide"></li>
            <?php endif; ?>


            <?php $_from = $this->_tpl_vars['Grid']['Details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Details'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Details']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Detail']):
        $this->_foreach['Details']['iteration']++;
?>
                <li><a class="js-save js-multiple-insert-hide" href="#" data-action="details" data-index="<?php echo ($this->_foreach['Details']['iteration']-1); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['Detail']['Caption'])) ? $this->_run_mod_handler('string_format', true, $_tmp, $this->_tpl_vars['Captions']->GetMessageString('SaveAndOpenDetail')) : smarty_modifier_string_format($_tmp, $this->_tpl_vars['Captions']->GetMessageString('SaveAndOpenDetail'))); ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
        <?php endif; ?>
    </div>

    <div class="btn-group">
        <a class="btn btn-default" href="<?php echo $this->_tpl_vars['Grid']['CancelUrl']; ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>
</a>
    </div>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ActionsContent', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "forms/actions_wrapper.tpl", 'smarty_include_vars' => array('ActionsContent' => $this->_tpl_vars['ActionsContent'],'isHorizontal' => $this->_tpl_vars['isHorizontal'],'top' => $this->_tpl_vars['top'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>