<?php if (( $this->_tpl_vars['Editor']->getPrefix() || $this->_tpl_vars['Editor']->getSuffix() )): ?>
    <div class="input-group">
<?php endif; ?>
<?php if ($this->_tpl_vars['Editor']->getPrefix()): ?>
    <span class="input-group-addon"><?php echo $this->_tpl_vars['Editor']->getPrefix(); ?>
</span>
<?php endif; ?>

    <?php echo $this->_tpl_vars['TextEditorContent']; ?>


<?php if ($this->_tpl_vars['Editor']->getSuffix()): ?>
    <span class="input-group-addon"><?php echo $this->_tpl_vars['Editor']->getSuffix(); ?>
</span>
<?php endif; ?>
<?php if ($this->_tpl_vars['Editor']->getPrefix() || $this->_tpl_vars['Editor']->getSuffix()): ?>
    </div>
<?php endif; ?>