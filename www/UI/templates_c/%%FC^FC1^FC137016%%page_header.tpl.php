<?php if ($this->_tpl_vars['pageTitle'] || $this->_tpl_vars['navigation']): ?>
    <div class="page-header<?php if ($this->_tpl_vars['pageWithForm']): ?> form-header<?php endif; ?>">
        <?php if ($this->_tpl_vars['navigation']): ?><?php echo $this->_tpl_vars['navigation']; ?>
<?php endif; ?>
        <?php if ($this->_tpl_vars['pageTitle']): ?><h1><?php echo $this->_tpl_vars['pageTitle']; ?>
</h1><?php endif; ?>
    </div>
<?php endif; ?>