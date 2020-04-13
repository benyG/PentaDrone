<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'list/filter_builder.tpl', 70, false),array('modifier', 'cat', 'list/filter_builder.tpl', 71, false),)), $this); ?>
<script type="text/html" id="filterBuilderGroupTemplate">
    <tr class="filter-builder-group<?php echo '<% if (!isEnabled) { %> filter-builder-group-disabled<% } %>'; ?>
 js-group js-component">
        <td colspan="4">
            <div class="filter-builder-group-wrapper">
                <div class="filter-builder-group-operator">
                    <?php echo $this->_tpl_vars['Captions']->getMessageString('FilterBuilderGroupConditionBeforeRules'); ?>

                    <div class="dropdown">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-underline js-group-operator-text"><%= operator %></span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="js-group-operator-select" data-operator="AND" data-translate="<?php echo $this->_tpl_vars['Captions']->GetMessageString('OperatorAnd'); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('OperatorAnd'); ?>
</a></li>
                            <li><a href="#" class="js-group-operator-select" data-operator="OR" data-translate="<?php echo $this->_tpl_vars['Captions']->GetMessageString('OperatorOr'); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('OperatorOr'); ?>
</a></li>
                            <li><a href="#" class="js-group-operator-select" data-operator="NONE" data-translate="<?php echo $this->_tpl_vars['Captions']->GetMessageString('OperatorNone'); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('OperatorNone'); ?>
</a></li>
                        </ul>
                    </div>
                    <?php echo $this->_tpl_vars['Captions']->getMessageString('FilterBuilderGroupConditionAfterRules'); ?>


                    <div class="btn-group pull-right">
                        <a href="#" class="btn btn-default js-group-add-component" data-type="group" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('AddGroup'); ?>
"><span class="icon-add-group"></span></a>
                        <a href="#" class="btn btn-default js-component-toggle" title="<?php echo '<% if (isEnabled) { %>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('DisableFilter'); ?>
<?php echo '<% } else { %>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('EnableFilter'); ?>
<?php echo '<% } %>'; ?>
">
                            <?php echo '<span class="icon-<% if (isEnabled) { %>disable<%} else { %>enable<% } %>"></span>'; ?>

                        </a>
                        <a href="#" class="btn btn-default js-component-remove" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('RemoveGroup'); ?>
"><span class="icon-remove"></span></a>
                    </div>
                </div>
                <table class="filter-builder-group-content js-group-content"></table>
                <div class="filter-builder-group-footer">
                    <a href="#" class="btn btn-default js-group-add-component" data-type="condition"><span class="icon-add-condition"></span><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddCondition'); ?>
</a>
                </div>
            </div>
        </td>
    </tr>
</script>

<script type="text/html" id="filterBuilderConditionTemplate">
    <tr class="filter-builder-condition js-condition js-component">
        <td class="filter-builder-condition-field">
            <select class="form-control js-condition-field-select"<?php echo '<% if (!isEnabled) { %> disabled="disabled"<% } %>'; ?>
>
                <?php echo '<% _.each(columns, function(column) { %>
                    <option value="<%= column.getName() %>"<% if (column.getName() === columnName) { %> selected="selected"<% } %>><%= column.getCaption() %></option>
                <% }) %>'; ?>

            </select>
        </td>
        <td class="filter-builder-condition-operator">
            <select class="form-control js-condition-operator-select"<?php echo '<% if (!isEnabled) { %> disabled="disabled"<% } %>'; ?>
>
                <?php echo '
                <% _.each(operators, function(caption, operatorKey) { %>
                    <option value="<%=operatorKey %>"<% if (operatorKey === operator) { %> selected="selected"<% } %>><%=caption %></option>
                <% }) %>
                '; ?>

            </select>
        </td>
        <td class="filter-builder-condition-value js-value"></td>
        <td class="filter-builder-condition-actions">
            <div class="btn-group">
                <a href="#" class="btn btn-default js-component-toggle" title="<?php echo '<% if (isEnabled) { %>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('DisableFilter'); ?>
<?php echo '<% } else { %>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('EnableFilter'); ?>
<?php echo '<% } %>'; ?>
">
                    <?php echo '<span class="icon-<% if (isEnabled) { %>disable<% } else { %>enable<% } %>"></span>'; ?>

                </a>
                <a href="#" class="btn btn-default js-component-remove" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('RemoveCondition'); ?>
"><span class="icon-remove"></span></a>
            </div>
        </td>
    </tr>
</script>

<?php $_from = $this->_tpl_vars['DataGrid']['FilterBuilder']->getColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
<?php $this->assign('operators', $this->_tpl_vars['DataGrid']['FilterBuilder']->getOperators($this->_tpl_vars['column'])); ?>
    <?php $_from = $this->_tpl_vars['operators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['operator'] => $this->_tpl_vars['editor']):
?>
        <?php if ($this->_tpl_vars['editor']): ?>
            <script type="text/html" id="filter_builder_editor_<?php echo $this->_tpl_vars['operator']; ?>
_<?php echo ((is_array($_tmp=$this->_tpl_vars['column']->getFieldName())) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
" data-editor="<?php echo $this->_tpl_vars['editor']->getEditorName(); ?>
">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp='editors/')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['editor']->getEditorName()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['editor']->getEditorName())))) ? $this->_run_mod_handler('cat', true, $_tmp, '.tpl') : smarty_modifier_cat($_tmp, '.tpl')), 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['editor'],'ViewData' => $this->_tpl_vars['editor']->getViewData(),'FormId' => $this->_tpl_vars['DataGrid']['Id'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </script>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>

<div class="modal fade filter-builder modal-top js-filter-builder-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->_tpl_vars['Captions']->GetMessageString('FilterBuilder'); ?>
</h4>
            </div>
            <div class="modal-body">
                <table class="js-filter-builder-container">

                </table>
            </div>
            <div class="modal-footer">
                <div class="checkbox pull-left">
                    <label>
                        <input type="checkbox" class="js-filter-builder-disable"> <?php echo $this->_tpl_vars['Captions']->GetMessageString('DisableFilter'); ?>

                    </label>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>
</button>
                <button type="button" class="btn btn-primary js-filter-builder-commit"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ApplyAdvancedFilter'); ?>
</button>
            </div>
        </div>
    </div>
</div>