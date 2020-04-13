<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'list/details_icon.tpl', 5, false),)), $this); ?>
<div class="btn-group text-nowrap">
    <a class="expand-details collapsed js-expand-details link-icon" data-info="<?php echo $this->_tpl_vars['Details']['JSON']; ?>
" href="#" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ToggleDetails'); ?>
"><i class="icon-detail-plus"></i><i class="icon-detail-minus"></i></a><a data-toggle="dropdown" class="link-icon" href="#" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('GoToMasterDetailPage'); ?>
"><i class="icon-detail-additional"></i></a>
    <ul class="dropdown-menu">
        <?php $_from = $this->_tpl_vars['Details']['Items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Detail']):
?>
            <li><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['Detail']['SeparatedPageLink'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"><?php echo $this->_tpl_vars['Detail']['caption']; ?>
</a></li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</div>