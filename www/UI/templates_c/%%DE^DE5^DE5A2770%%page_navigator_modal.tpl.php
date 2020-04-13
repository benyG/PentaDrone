<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ucfirst', 'list/page_navigator_modal.tpl', 53, false),array('modifier', 'cat', 'list/page_navigator_modal.tpl', 54, false),array('modifier', 'escape', 'list/page_navigator_modal.tpl', 92, false),array('function', 'eval', 'list/page_navigator_modal.tpl', 74, false),)), $this); ?>
<?php if ($this->_tpl_vars['PageNavigator']): ?>
    <?php $this->assign('totalRecords', $this->_tpl_vars['PageNavigator']->GetRowCount()); ?>
    <?php $this->assign('countPerPage', $this->_tpl_vars['PageNavigator']->GetRowsPerPage()); ?>
<?php else: ?>
    <?php $this->assign('totalRecords', 0); ?>
    <?php $this->assign('countPerPage', 0); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['PageNavigator'] || $this->_tpl_vars['EnableRunTimeCustomization']): ?>
    <div id="page-settings" class="modal modal-top fade js-page-settings-dialog" data-total-record-count="<?php echo $this->_tpl_vars['totalRecords']; ?>
" data-record-count-per-page="<?php echo $this->_tpl_vars['countPerPage']; ?>
" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><?php echo $this->_tpl_vars['Captions']->GetMessageString('PageSettings'); ?>
</h3>
                </div>

                <div class="modal-body">

                    <h4><?php echo $this->_tpl_vars['Captions']->GetMessageString('Appearance'); ?>
</h4>

                    <table class="table table-bordered table-condensed form-inline">
                        <?php $this->assign('Grid', $this->_tpl_vars['Page']->GetGrid()); ?>
                        <tr>
                            <td class="page-settings-label-container">
                                <label for="page-settings-viewmode-control"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ViewMode'); ?>
</label>
                            </td>
                            <td class="page-settings-control-container" colspan="2">
                                <select id="page-settings-viewmode-control" class="form-control js-page-settings-viewmode-control">
                                    <?php $this->assign('CurrentViewMode', $this->_tpl_vars['Grid']->GetViewMode()); ?>
                                    <?php $_from = $this->_tpl_vars['ViewModes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mode'] => $this->_tpl_vars['caption']):
?>
                                        <option value="<?php echo $this->_tpl_vars['mode']; ?>
" data-name="<?php echo $this->_tpl_vars['caption']; ?>
"<?php if ($this->_tpl_vars['CurrentViewMode'] == $this->_tpl_vars['mode']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['Captions']->GetMessageString($this->_tpl_vars['caption']); ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="5" class="page-settings-label-container">
                                <label><?php echo $this->_tpl_vars['Captions']->GetMessageString('CardRowCount'); ?>
</label>
                                <p><?php echo $this->_tpl_vars['Captions']->GetMessageString('CardRowCountDescription'); ?>
</p>
                            </td>
                        </tr>

                        <?php $this->assign('AvailableCardCountInRow', $this->_tpl_vars['Grid']->GetAvailableCardCountInRow()); ?>
                        <?php $this->assign('CardCountInRow', $this->_tpl_vars['Grid']->GetCardCountInRow()); ?>

                        <?php $_from = $this->_tpl_vars['Grid']->getAvailableScreenSizes(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['size']):
?>
                            <tr class="page-settings-hightlight-<?php echo $this->_tpl_vars['size']; ?>
">
                                <td style="width: 25%;">
                                    <label for="page-settings-card-column-count-<?php echo $this->_tpl_vars['size']; ?>
">
                                        <?php $this->assign('SizeName', ucfirst($this->_tpl_vars['size'])); ?>
                                        <?php $this->assign('SizeTranslateString', smarty_modifier_cat('ScreenSize', $this->_tpl_vars['SizeName'])); ?>
                                        <?php echo $this->_tpl_vars['Captions']->GetMessageString($this->_tpl_vars['SizeTranslateString']); ?>

                                    </label>
                                </td>
                                <td class="page-settings-control-container">
                                <select class="form-control js-page-settings-card-column-count" data-size="<?php echo $this->_tpl_vars['size']; ?>
" id="page-settings-card-column-count-<?php echo $this->_tpl_vars['size']; ?>
">
                                    <?php $_from = $this->_tpl_vars['AvailableCardCountInRow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Count']):
?>
                                        <option<?php if ($this->_tpl_vars['CardCountInRow'][$this->_tpl_vars['size']] == $this->_tpl_vars['Count']): ?> selected="selected"<?php endif; ?> value="<?php echo $this->_tpl_vars['Count']; ?>
"><?php echo $this->_tpl_vars['Count']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                                </td>
                            </tr>
                        <?php endforeach; endif; unset($_from); ?>

                    </table>

                    <?php if ($this->_tpl_vars['PageNavigator']): ?>
                        <h4><?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePageSizeTitle'); ?>
</h4>

                        <?php $this->assign('row_count', $this->_tpl_vars['PageNavigator']->GetRowCount()); ?>
                        <p><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('ChangePageSizeText')), $this);?>
</p>

                        <table class="table table-bordered table-condensed form-inline">
                            <tr>
                                <th style="width:50%;"> <label for="page-settings-page-size-control"><?php echo $this->_tpl_vars['Captions']->GetMessageString('RecordsPerPage'); ?>
</label></th>
                                <td class="page-settings-control-container">
                                    <span class="js-page-settings-page-size-container ">
                                        <select id="page-settings-page-size-control" class="form-control js-page-settings-page-size-control">
                                            <?php $_from = $this->_tpl_vars['PageNavigator']->GetRecordsPerPageValues(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
                                                <?php $this->assign('record_count', $this->_tpl_vars['value']); ?>
                                                <?php $this->assign('page_count', $this->_tpl_vars['PageNavigator']->GetPageCountForPageSize($this->_tpl_vars['name'])); ?>
                                                <option value="<?php echo $this->_tpl_vars['name']; ?>
"><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('CountRowsWithCountPages')), $this);?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                            <option value="custom"><?php echo $this->_tpl_vars['Captions']->GetMessageString('CustomRecordsPerPage'); ?>
</option>
                                        </select>
                                    </span>

                                    <span class="js-page-settings-custom-page-size-container" style="display: none">
                                        <input type="number" min="1" max="<?php echo $this->_tpl_vars['PageNavigator']->GetRowCount(); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['PageNavigator']->GetRowsPerPage())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" id="page-settings-custom-page-size-control" class="js-page-settings-custom-page-size-control form-control">
                                        <span style="margin-left: .5em;">
                                            <?php $this->assign('current_page_count', '<span class="js-page-settings-custom-page-size-pager"></span>'); ?>
                                            <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('CurrentPageCount')), $this);?>

                                        </span>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>

                </div>

                <div class="modal-footer">
                    <a href="#" class="js-page-settings-cancel btn btn-default" data-dismiss="modal"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>
</a>
                    <a href="#" class="js-page-settings-save btn btn-primary"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveChanges'); ?>
</a>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>