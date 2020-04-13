<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'forms/single_field_form.tpl', 6, false),)), $this); ?>
<form id="<?php echo $this->_tpl_vars['Grid']['FormId']; ?>
" enctype="multipart/form-data" method="POST" action="<?php echo $this->_tpl_vars['Grid']['FormAction']; ?>
">

    <?php $this->assign('ColumnViewData', $this->_tpl_vars['Column']->getViewData()); ?>
    <div class="col-input">
        <div class="form-group">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp='editors/')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['ColumnViewData']['EditorViewData']['Editor']->getEditorName()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['ColumnViewData']['EditorViewData']['Editor']->getEditorName())))) ? $this->_run_mod_handler('cat', true, $_tmp, '.tpl') : smarty_modifier_cat($_tmp, '.tpl')), 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['ColumnViewData']['EditorViewData']['Editor'],'ViewData' => $this->_tpl_vars['ColumnViewData']['EditorViewData'],'FormId' => $this->_tpl_vars['Grid']['FormId'],'isSingleFieldForm' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        </div>

        <div style="display: none">
            <?php $_from = $this->_tpl_vars['Columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['CurrentColumnName'] => $this->_tpl_vars['CurrentColumn']):
?>
                <?php if ($this->_tpl_vars['CurrentColumnName'] != $this->_tpl_vars['Column']->getName()): ?>
                    <?php $this->assign('CurrentColumnViewData', $this->_tpl_vars['CurrentColumn']->getViewData()); ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp='editors/')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['CurrentColumnViewData']['EditorViewData']['Editor']->getEditorName()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['CurrentColumnViewData']['EditorViewData']['Editor']->getEditorName())))) ? $this->_run_mod_handler('cat', true, $_tmp, '.tpl') : smarty_modifier_cat($_tmp, '.tpl')), 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['CurrentColumnViewData']['EditorViewData']['Editor'],'ViewData' => $this->_tpl_vars['CurrentColumnViewData']['EditorViewData'],'FormId' => $this->_tpl_vars['Grid']['FormId'],'isSingleFieldForm' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>            
        </div>
    </div>

    <div class="form-error-container"></div>

    <span class="pull-right">
        <button type="button" class="js-cancel btn btn-default"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>
</button>
        <button type="button" class="js-save btn btn-primary"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Save'); ?>
</button>
    </span>

    <div class="clearfix"></div>

    <?php $_from = $this->_tpl_vars['HiddenValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenValueName'] => $this->_tpl_vars['HiddenValue']):
?>
        <input type="hidden" name="<?php echo $this->_tpl_vars['HiddenValueName']; ?>
" value="<?php echo $this->_tpl_vars['HiddenValue']; ?>
" />
    <?php endforeach; endif; unset($_from); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_scripts.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</form>