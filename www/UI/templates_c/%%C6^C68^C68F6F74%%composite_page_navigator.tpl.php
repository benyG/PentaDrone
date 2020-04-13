<!-- <Pages> -->
<div class="page_navigator">
    <?php $_from = $this->_tpl_vars['PageNavigator']->GetPageNavigators(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['SubPageNavigator']):
?>
        <?php echo $this->_tpl_vars['Renderer']->Render($this->_tpl_vars['SubPageNavigator']); ?>

    <?php endforeach; endif; unset($_from); ?>
</div>
<!-- </Pages> -->