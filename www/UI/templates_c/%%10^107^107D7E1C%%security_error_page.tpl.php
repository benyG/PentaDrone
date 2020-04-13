<?php $this->assign('ContentBlockClass', "col-md-8 col-md-offset-2"); ?>

<?php ob_start(); ?>
    <div class="alert alert-danger">
        <h4><?php echo $this->_tpl_vars['Message']; ?>
</h4>
        <?php echo $this->_tpl_vars['Description']; ?>

    </div>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?>
    <?php echo $this->_tpl_vars['Page']->GetFooter(); ?>

<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('Footer', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/layout.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>