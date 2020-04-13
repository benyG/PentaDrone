<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'list/quick_filter.tpl', 4, false),array('modifier', 'in_array', 'list/quick_filter.tpl', 14, false),array('modifier', 'cat', 'list/quick_filter.tpl', 25, false),)), $this); ?>
<div class="addition-block-right pull-right js-quick-filter">
    <div class="quick-filter-toolbar btn-group">
        <div class="input-group js-filter-control">
            <input placeholder="<?php echo $this->_tpl_vars['Captions']->GetMessageString('QuickSearch'); ?>
" type="text" size="16" class="js-input form-control" name="quick_filter" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['QuickFilter']->getValue())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">
            <div class="input-group-btn dropdown dropdown-lg">
                <button id="toggle-dropdown" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <form class="form-horizontal quick-filter">
                        <div class="form-group form-group-sm">
                            <label class="control-label" for="quick-filter-fields"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Columns'); ?>
</label>
                            <div class="col-input input-group-sm" style="width:100%;max-width:100%" data-column="quick_filter_fields">
                                <select id="quick-filter-fields" class="form-control" name="quick_filter_fields[]" multiple data-max-selection-size="0" data-placeholder="<?php echo $this->_tpl_vars['Captions']->GetMessageString('All'); ?>
" data-editor="multivalue_select">
                                    <?php $_from = $this->_tpl_vars['filter']->getColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
                                        <option value="<?php echo $this->_tpl_vars['column']->getFieldName(); ?>
" <?php if (((is_array($_tmp=$this->_tpl_vars['column']->getFieldName())) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['filter']->getSelectedFieldNames()) : in_array($_tmp, $this->_tpl_vars['filter']->getSelectedFieldNames()))): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['column']->getCaption(); ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label" for="quick-filter-operator"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SearchCondition'); ?>
</label>
                            <div class="col-input input-group-sm" style="width:100%;max-width:100%" data-column="quick_filter_operator">
                                <select id="quick-filter-operator" class="form-control" name="quick_filter_operator">
                                    <?php $_from = $this->_tpl_vars['filter']->getAvailableOperators(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['operator']):
?>
                                        <option value="<?php echo $this->_tpl_vars['operator']; ?>
" <?php if ($this->_tpl_vars['operator'] == $this->_tpl_vars['filter']->getOperator()): ?> selected<?php endif; ?>>
                                            <?php $this->assign('operatorCaption', ((is_array($_tmp='FilterOperator')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['operator']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['operator']))); ?>
                                            <?php echo $this->_tpl_vars['Captions']->GetMessageString($this->_tpl_vars['operatorCaption']); ?>

                                        </option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </div>
                        </div>
                        <hr class="quick-filter-separator">
                        <span class="pull-right">
                            <button type="button" class="js-cancel btn btn-sm btn-default"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>
</button>
                            <button type="button" class="js-submit btn btn-sm btn-primary"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Apply'); ?>
</button>
                        </span>
                    </form>
                </div>
                <button type="button" class="btn btn-default js-submit" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('QuickSearchApply'); ?>
"><i class="icon-search"></i></button>
                <button type="button" class="btn btn-default js-reset" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('QuickSearchClear'); ?>
"><i class="icon-filter-reset"></i></button>
            </div>
        </div>
    </div>
    <span class="hidden-xs">&thinsp;</span>
</div>