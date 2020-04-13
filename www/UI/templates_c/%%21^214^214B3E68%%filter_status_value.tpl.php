<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'list/filter_status_value.tpl', 2, false),)), $this); ?>
<?php if (! $this->_tpl_vars['filter']->isEmpty() && ! ( $this->_tpl_vars['ignoreDisabled'] && $this->_tpl_vars['filter']->isCommandFilterEmpty() )): ?>
    <div class="filter-status-value filter-status-value-<?php echo $this->_tpl_vars['typeClass']; ?>
<?php if (! $this->_tpl_vars['filter']->isEnabled()): ?> filter-status-value-disabled<?php endif; ?><?php if ($this->_tpl_vars['isEditable']): ?> filter-status-value-editable<?php endif; ?>" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['stringRepresentation'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp, false) : smarty_modifier_strip_tags($_tmp, false)); ?>
">
        <i class="filter-status-value-icon icon-<?php echo $this->_tpl_vars['icon']; ?>
"></i>
        <span class="filter-status-value-expr"><?php echo $this->_tpl_vars['stringRepresentation']; ?>
</span>
        <div class="filter-status-value-controls">

            <?php if ($this->_tpl_vars['isEditable']): ?>
                <a href="#" class="js-edit-filter" data-id="<?php echo $this->_tpl_vars['id']; ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('EditFilter'); ?>
">
                    <i class="icon-edit"></i>
                </a>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['isToggable']): ?>
                <?php if ($this->_tpl_vars['filter']->isEnabled()): ?>
                    <a href="#" class="js-toggle-filter" data-value="false" data-id="<?php echo $this->_tpl_vars['id']; ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('DisableFilter'); ?>
">
                        <i class="icon-disable"></i>
                    </a>
                <?php else: ?>
                    <a href="#" class="js-toggle-filter" data-value="true" data-id="<?php echo $this->_tpl_vars['id']; ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('EnableFilter'); ?>
">
                        <i class="icon-enable"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <a href="#" class="js-reset-filter" data-id="<?php echo $this->_tpl_vars['id']; ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ResetFilter'); ?>
">
                <i class="icon-remove"></i>
            </a>
        </div>
    </div>
<?php endif; ?>