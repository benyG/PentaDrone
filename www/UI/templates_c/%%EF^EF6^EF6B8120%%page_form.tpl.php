<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page_header.tpl", 'smarty_include_vars' => array('pageTitle' => $this->_tpl_vars['Grid']['Title'],'pageWithForm' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="col-md-12 js-form-container" data-form-url="<?php echo $this->_tpl_vars['Grid']['FormAction']; ?>
&flash=true">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/actions_edit.tpl', 'smarty_include_vars' => array('top' => true,'isHorizontal' => $this->_tpl_vars['Grid']['FormLayout']->isHorizontal())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="row">
        <div class="js-form-collection <?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>col-lg-8<?php else: ?>col-md-8 col-md-offset-2<?php endif; ?>">
            <?php $_from = $this->_tpl_vars['Forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['forms'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['forms']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Form']):
        $this->_foreach['forms']['iteration']++;
?>
                <?php echo $this->_tpl_vars['Form']; ?>

                <?php if (! ($this->_foreach['forms']['iteration'] == $this->_foreach['forms']['total'])): ?><hr><?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>

    <?php if ($this->_tpl_vars['Grid']['AllowAddMultipleRecords']): ?>
        <div class="row" style="margin-top: 20px">
            <div class="<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>col-lg-8<?php else: ?>col-md-8 col-md-offset-2<?php endif; ?>">
                <a href="#" class="js-form-add<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?> col-md-offset-3<?php endif; ?>"><span class="icon-plus"></span> <?php echo $this->_tpl_vars['Captions']->GetMessageString('FormAdd'); ?>
</a>
            </div>
        </div>
    <?php endif; ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/actions_edit.tpl', 'smarty_include_vars' => array('top' => false,'isHorizontal' => $this->_tpl_vars['Grid']['FormLayout']->isHorizontal())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

