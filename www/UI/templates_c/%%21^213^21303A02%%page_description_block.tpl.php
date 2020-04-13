<?php if ($this->_tpl_vars['Description']): ?>
<div class="well description">
    <a href="#" class="close" onclick="$(this).closest('.well').hide(); return false;"><span aria-hidden="true">&times;</span></a>
    <?php echo $this->_tpl_vars['Description']; ?>

</div>
<?php endif; ?>