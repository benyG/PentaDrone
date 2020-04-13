<?php if ($this->_tpl_vars['charts']): ?>
    <div class="row pgui-charts pgui-charts-<?php echo $this->_tpl_vars['Page']->GetPageId(); ?>
">
        <?php $_from = $this->_tpl_vars['charts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['chart']):
?>
            <div class="<?php echo $this->_tpl_vars['chartsClasses'][$this->_tpl_vars['index']]; ?>
">
                <?php echo $this->_tpl_vars['chart']; ?>

            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>