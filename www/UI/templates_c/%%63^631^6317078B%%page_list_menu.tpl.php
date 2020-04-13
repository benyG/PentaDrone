<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'page_list_menu.tpl', 22, false),)), $this); ?>
<ul class="nav navbar-nav">
    <?php $_from = $this->_tpl_vars['List']['Groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Group']):
?>
        <?php $this->assign('GroupCaption', $this->_tpl_vars['Group']->getCaption()); ?>

        <?php if ($this->_tpl_vars['GroupCaption'] != 'Default'): ?>
            <li class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $this->_tpl_vars['GroupCaption']; ?>

                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['List']['Pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['PageListPage']):
?>

            <?php if ($this->_tpl_vars['PageListPage']['GroupName'] == $this->_tpl_vars['GroupCaption']): ?>
                <?php if ($this->_tpl_vars['PageListPage']['BeginNewGroup']): ?>
                    <li role="separator" class="divider"></li>
                <?php endif; ?>
                <li<?php if ($this->_tpl_vars['PageListPage']['ClassAttribute']): ?> class="<?php echo $this->_tpl_vars['PageListPage']['ClassAttribute']; ?>
"<?php endif; ?>>
                    <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['PageListPage']['Href'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" title="<?php echo $this->_tpl_vars['PageListPage']['Hint']; ?>
"<?php if ($this->_tpl_vars['PageListPage']['Target']): ?> target="<?php echo $this->_tpl_vars['PageListPage']['Target']; ?>
"<?php endif; ?>>
                        <?php echo $this->_tpl_vars['PageListPage']['Caption']; ?>

                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['GroupCaption'] != 'Default'): ?>
            </ul>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
</ul>