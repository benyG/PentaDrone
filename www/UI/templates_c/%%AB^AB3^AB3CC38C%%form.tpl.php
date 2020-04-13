<form id="<?php echo $this->_tpl_vars['Grid']['FormId']; ?>
" class="<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>form-horizontal<?php endif; ?>" enctype="multipart/form-data" method="POST" action="<?php echo $this->_tpl_vars['Grid']['FormAction']; ?>
">

    <?php if (! $this->_tpl_vars['isEditOperation'] && $this->_tpl_vars['Grid']['AllowAddMultipleRecords']): ?>
        <div class="btn-group pull-right form-collection-actions">
            <button type="button" class="btn btn-default icon-copy js-form-copy" title=<?php echo $this->_tpl_vars['Captions']->GetMessageString('Copy'); ?>
></button>
            <button type="button" class="btn btn-default icon-remove js-form-remove" style="display: none" title=<?php echo $this->_tpl_vars['Captions']->GetMessageString('Delete'); ?>
></button>
        </div>
    <?php endif; ?>
    <div class="clearfix"></div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'danger','dismissable' => true,'messages' => $this->_tpl_vars['Grid']['ErrorMessages'],'displayTime' => $this->_tpl_vars['Grid']['MessageDisplayTime'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'success','dismissable' => true,'messages' => $this->_tpl_vars['Grid']['Messages'],'displayTime' => $this->_tpl_vars['Grid']['MessageDisplayTime'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_fields.tpl', 'smarty_include_vars' => array('isViewForm' => false)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php if ($this->_tpl_vars['flashMessages']): ?>
        <input type="hidden" name="flash_messages" value="1" />
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 form-error-container"></div>
    </div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_scripts.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</form>