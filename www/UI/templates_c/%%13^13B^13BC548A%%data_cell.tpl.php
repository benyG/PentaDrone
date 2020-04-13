<td data-column-name="<?php echo $this->_tpl_vars['Cell']['ColumnName']; ?>
"<?php if ($this->_tpl_vars['Cell']['CellClasses'] || $this->_tpl_vars['Cell']['EditUrl']): ?> class="<?php echo $this->_tpl_vars['Cell']['CellClasses']; ?>
<?php if ($this->_tpl_vars['Cell']['EditUrl']): ?> pgui-cell-edit<?php endif; ?>"<?php endif; ?><?php if ($this->_tpl_vars['Cell']['Style']): ?> style="<?php echo $this->_tpl_vars['Cell']['Style']; ?>
"<?php endif; ?> data-edit-url="<?php echo $this->_tpl_vars['Cell']['EditUrl']; ?>
"><?php echo $this->_tpl_vars['Cell']['Data']; ?>
</td>