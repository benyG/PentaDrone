<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'view/export_buttons.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['buttons']['excel'] || $this->_tpl_vars['buttons']['pdf'] || $this->_tpl_vars['buttons']['csv'] || $this->_tpl_vars['buttons']['xml'] || $this->_tpl_vars['buttons']['word']): ?>
    <div class="btn-group">
        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('Export'); ?>
">
            <i class="icon-export"></i>
            <span class="<?php echo $this->_tpl_vars['spanClasses']; ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Export'); ?>
</span>
            <span class="caret"></span>
        </a>

        <ul class="dropdown-menu">
            <?php $_from = $this->_tpl_vars['buttons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Name'] => $this->_tpl_vars['Item']):
?>
                <?php if ($this->_tpl_vars['Name'] != 'print_page' && $this->_tpl_vars['Name'] != 'print_all'): ?>
                    <?php if ($this->_tpl_vars['Item']['BeginNewGroup']): ?><li class="divider"></li><?php endif; ?>
                    <li><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['Href'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
">
                            <i class="<?php echo $this->_tpl_vars['Item']['IconClass']; ?>
"></i>
                            <?php echo $this->_tpl_vars['Item']['Caption']; ?>

                        </a></li>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
<?php endif; ?>