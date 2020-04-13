<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'forms/form_fields.tpl', 41, false),)), $this); ?>
<?php if ($this->_tpl_vars['isMultiEditOperation']): ?>
<div class="row">
    <div id="form-group-fields-to-be-updated" class="form-group">
        <div class="form-group-label <?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>col-sm-3<?php else: ?>col-sm-12<?php endif; ?>">
            <label class="control-label" for="fields-to-be-updated">
                <?php echo $this->_tpl_vars['Captions']->GetMessageString('FieldsToBeUpdated'); ?>

            </label>
        </div>
        <div class="<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>col-sm-9<?php else: ?>col-sm-12<?php endif; ?>">
            <div class="input-group">
                <div class="col-input" style="width:100%;max-width:100%">
                    <select id="fields-to-be-updated" name="fields_to_be_updated_edit[]" class="form-control" multiple data-editor="multivalue_select">
                        <?php $_from = $this->_tpl_vars['Grid']['MultiEditColumns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
                        <option value="<?php echo $this->_tpl_vars['column']->GetName(); ?>
" selected><?php echo $this->_tpl_vars['column']->GetCaption(); ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
                <span id="clear-fields-to-be-updated" class="input-group-addon" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ClearFieldsToBeUpdated'); ?>
">
                    <span class="icon-remove"></span>
                </span>
            </div>
        </div>
        <div class="col-sm-12">
            <hr>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="row">
<?php $_from = $this->_tpl_vars['Grid']['FormLayout']->getGroups(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Group']):
?>
    <?php if (count ( $this->_tpl_vars['Group']->getRows() ) > 0): ?>
    <<?php if ($this->_tpl_vars['isViewForm']): ?>div<?php else: ?>fieldset<?php endif; ?> class="col-md-<?php echo $this->_tpl_vars['Group']->getWidth(); ?>
">
        <?php if ($this->_tpl_vars['Group']->getName()): ?><legend><?php echo $this->_tpl_vars['Group']->getName(); ?>
</legend><?php endif; ?>
        <?php $_from = $this->_tpl_vars['Group']->getRows(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Row']):
?>
            <div class="row">
                <?php $_from = $this->_tpl_vars['Row']->getCols(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Col']):
?>
                    <?php $this->assign('ColumnViewData', $this->_tpl_vars['Col']->getViewData()); ?>
                    <?php $this->assign('Editor', $this->_tpl_vars['ColumnViewData']['EditorViewData']['Editor']); ?>

                    <?php if ($this->_tpl_vars['Editor']): ?>
                        <?php $this->assign('editorId', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['Grid']['FormId'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['Editor']->getName()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['Editor']->getName()))); ?>
                    <?php endif; ?>

                    <div class="form-group <?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>col-sm-<?php echo $this->_tpl_vars['Col']->getLabelWidth(); ?>
 form-group-label<?php else: ?>col-sm-<?php echo $this->_tpl_vars['Col']->getWidth(); ?>
<?php endif; ?>"<?php if ($this->_tpl_vars['Editor'] && ! $this->_tpl_vars['Editor']->getVisible()): ?> style="display: none"<?php endif; ?>>

                        <?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal() || ! $this->_tpl_vars['ColumnViewData']['EditorViewData'] || ! $this->_tpl_vars['Editor']->isInlineLabel()): ?>
                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/field_label.tpl', 'smarty_include_vars' => array('editorId' => $this->_tpl_vars['editorId'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <?php endif; ?>

                    <?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>
                        </div>
                        <div class="form-group col-sm-<?php echo $this->_tpl_vars['Col']->getInputWidth(); ?>
"<?php if ($this->_tpl_vars['Editor'] && ! $this->_tpl_vars['Editor']->getVisible()): ?> style="display: none"<?php endif; ?>>
                    <?php endif; ?>

                        <?php if (! $this->_tpl_vars['isViewForm']): ?>
                            <div class="col-input" style="width:100%;max-width:<?php echo $this->_tpl_vars['Editor']->getMaxWidth(); ?>
" data-column="<?php echo $this->_tpl_vars['ColumnViewData']['FieldName']; ?>
">
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp='editors/')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['Editor']->getEditorName()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['Editor']->getEditorName())))) ? $this->_run_mod_handler('cat', true, $_tmp, '.tpl') : smarty_modifier_cat($_tmp, '.tpl')), 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'],'ViewData' => $this->_tpl_vars['ColumnViewData']['EditorViewData'],'FormId' => $this->_tpl_vars['Grid']['FormId'],'id' => $this->_tpl_vars['editorId'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                                <?php if (! $this->_tpl_vars['Grid']['FormLayout']->isHorizontal() && $this->_tpl_vars['Editor']->isInlineLabel()): ?>
                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/field_label.tpl', 'smarty_include_vars' => array('editorId' => $this->_tpl_vars['editorId'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php $this->assign('ColumnName', $this->_tpl_vars['Col']->getName()); ?>
                            <?php $this->assign('CellEditUrl', $this->_tpl_vars['Grid']['CellEditUrls'][$this->_tpl_vars['ColumnName']]); ?>

                            <div class="form-control-static<?php if ($this->_tpl_vars['CellEditUrl']): ?> pgui-cell-edit<?php endif; ?>"<?php if ($this->_tpl_vars['CellEditUrl']): ?> data-column-name="<?php echo $this->_tpl_vars['ColumnName']; ?>
" data-edit-url="<?php echo $this->_tpl_vars['CellEditUrl']; ?>
"<?php endif; ?>>
                                <?php echo $this->_tpl_vars['Col']->getDisplayValue($this->_tpl_vars['Renderer']); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </<?php if ($this->_tpl_vars['isViewForm']): ?>div<?php else: ?>fieldset<?php endif; ?>>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</div>

<?php if (! $this->_tpl_vars['isViewForm'] && ! $this->_tpl_vars['isMultiUploadOperation']): ?>
    <div class="row">
        <div class="<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>col-sm-9 col-sm-offset-3<?php else: ?>col-md-12<?php endif; ?>">
            <span class="required-mark">*</span> - <?php echo $this->_tpl_vars['Captions']->GetMessageString('RequiredField'); ?>

        </div>
    </div>

    <?php if ($this->_tpl_vars['isMultiEditOperation']): ?>
        <?php $_from = $this->_tpl_vars['HiddenValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenValueName'] => $this->_tpl_vars['HiddenArray']):
?>
            <?php $_from = $this->_tpl_vars['HiddenArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenValue']):
?>
                <input type="hidden" name="<?php echo $this->_tpl_vars['HiddenValueName']; ?>
[]" value="<?php echo $this->_tpl_vars['HiddenValue']; ?>
" />
            <?php endforeach; endif; unset($_from); ?>
        <?php endforeach; endif; unset($_from); ?>
    <?php else: ?>
        <?php $_from = $this->_tpl_vars['HiddenValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenValueName'] => $this->_tpl_vars['HiddenValue']):
?>
        <input type="hidden" name="<?php echo $this->_tpl_vars['HiddenValueName']; ?>
" value="<?php echo $this->_tpl_vars['HiddenValue']; ?>
" />
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
<?php endif; ?>