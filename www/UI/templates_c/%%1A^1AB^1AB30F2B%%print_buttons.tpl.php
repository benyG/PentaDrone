<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'view/print_buttons.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['buttons']['print_page'] || $this->_tpl_vars['buttons']['print_all']): ?>
    <div class="btn-group">
        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('Print'); ?>
">
            <i class="icon-print-page"></i>
            <span class="<?php echo $this->_tpl_vars['spanClasses']; ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Print'); ?>
</span>
            <span class="caret"></span>
        </a>

        <ul class="dropdown-menu">
            <?php $_from = $this->_tpl_vars['pageTitleButtons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['printButton']):
?>
                <?php if ($this->_tpl_vars['name'] == 'print_page' || $this->_tpl_vars['name'] == 'print_all'): ?>
                    <li>
                        <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['printButton']['Href'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
">
                            <i class="<?php echo $this->_tpl_vars['printButton']['IconClass']; ?>
"></i>
                            <?php echo $this->_tpl_vars['printButton']['Caption']; ?>

                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
<?php endif; ?>