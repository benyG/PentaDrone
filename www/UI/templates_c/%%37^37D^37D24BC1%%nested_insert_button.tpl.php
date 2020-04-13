<?php if ($this->_tpl_vars['NestedInsertFormLink'] && ! $this->_tpl_vars['isSingleFieldForm']): ?>
    <div class="btn-group input-group-btn">
        <button
            type="button"
            class="btn btn-default js-nested-insert"
            data-content-link="<?php echo $this->_tpl_vars['NestedInsertFormLink']; ?>
"
            data-display-field-name="<?php echo $this->_tpl_vars['LookupDisplayFieldName']; ?>
"
            title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('InsertRecord'); ?>
">
            <span class="icon-plus"></span>
        </button>
    </div>
<?php endif; ?>