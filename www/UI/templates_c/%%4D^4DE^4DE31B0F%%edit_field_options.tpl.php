<?php if (! $this->_tpl_vars['isMultiEditOperation']): ?>
<div class="pgui-field-options btn-group btn-group-xs btn-group-justified" data-toggle="buttons">
    <?php if ($this->_tpl_vars['Column']['DisplaySetToNullCheckBox']): ?>
        <label class="btn btn-default<?php if ($this->_tpl_vars['Column']['IsValueNull']): ?> active<?php endif; ?>">
            <input type="checkbox" name="<?php echo $this->_tpl_vars['Column']['SetNullCheckBoxName']; ?>
"<?php if ($this->_tpl_vars['Column']['IsValueNull']): ?> checked<?php endif; ?> autocomplete="off" value="1"> <?php echo $this->_tpl_vars['Captions']->GetMessageString('SetToNull'); ?>

        </label>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['Column']['DisplaySetToDefaultCheckBox']): ?>
        <label class="btn btn-default">
            <input type="checkbox" name="<?php echo $this->_tpl_vars['Column']['SetDefaultCheckBoxName']; ?>
" autocomplete="off" value="1"> <?php echo $this->_tpl_vars['Captions']->GetMessageString('SetToDefault'); ?>

        </label>
    <?php endif; ?>
</div>
<?php endif; ?>