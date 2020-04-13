<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'list/grid_toolbar.tpl', 8, false),array('modifier', 'sprintf', 'list/grid_toolbar.tpl', 32, false),)), $this); ?>
<?php if ($this->_tpl_vars['DataGrid']['ActionsPanelAvailable']): ?>
    <div class="addition-block js-actions">
        <div class="btn-toolbar addition-block-left pull-left">
                <?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton']): ?>
                    <div class="btn-group">
                        <?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'modal' || $this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'inline'): ?>
                            <button class="btn btn-default pgui-add"
                                    data-content-link="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['ModalInsertDialog'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"
                                    data-<?php echo $this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton']; ?>
-insert="true"
                                    title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
">
                                <i class="icon-plus"></i>
                                <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
</span>
                            </button>
                        <?php else: ?>
                            <a class="btn btn-default pgui-add" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['SimpleAddNewRow'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"
                               title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
">
                                <i class="icon-plus"></i>
                                <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
</span>
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['DataGrid']['AddNewChoices']): ?>
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php $_from = $this->_tpl_vars['DataGrid']['AddNewChoices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['choice']):
?>
                                    <li>
                                        <?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'modal'): ?>
                                            <a href="#"
                                                data-modal-insert="true"
                                                data-content-link="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['ModalInsertDialog'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
&count=<?php echo $this->_tpl_vars['choice']; ?>
">
                                                <?php echo sprintf($this->_tpl_vars['Captions']->GetMessageString('AddMultipleRecords'), $this->_tpl_vars['choice']); ?>

                                            </a>
                                        <?php elseif ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'inline'): ?>
                                            <a href="#"
                                                data-inline-insert="true"
                                                data-content-link="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['ModalInsertDialog'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"
                                                data-count="<?php echo $this->_tpl_vars['choice']; ?>
"><?php echo $this->_tpl_vars['choice']; ?>
</a>
                                        <?php else: ?>
                                            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['SimpleAddNewRow'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
&count=<?php echo $this->_tpl_vars['choice']; ?>
">
                                                <?php echo sprintf($this->_tpl_vars['Captions']->GetMessageString('AddMultipleRecords'), $this->_tpl_vars['choice']); ?>

                                            </a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; endif; unset($_from); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['DataGrid']['AllowMultiUpload']): ?>
                    <div class="btn-group">
                        <a class="btn btn-default pgui-multi-upload" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['MultiUpload'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('UploadFiles'); ?>
">
                            <i class="icon-upload"></i>
                            <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('UploadFiles'); ?>
</span>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['RefreshButton'] && ! $this->_tpl_vars['isInline']): ?>
                    <div class="btn-group">
                        <a class="btn btn-default" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['Refresh'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('Refresh'); ?>
">
                            <i class="icon-page-refresh"></i>
                            <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Refresh'); ?>
</span>
                        </a>
                    </div>
                <?php endif; ?>

            <?php $this->assign('pageTitleButtons', $this->_tpl_vars['Page']->GetExportListButtonsViewData()); ?>

            <?php if ($this->_tpl_vars['pageTitleButtons']): ?>
                <div class="btn-group export-button">

                    <?php if ($this->_tpl_vars['Page']->getExportListAvailable()): ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "view/export_buttons.tpl", 'smarty_include_vars' => array('buttons' => $this->_tpl_vars['pageTitleButtons'],'spanClasses' => "visible-lg-inline")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['Page']->getPrintListAvailable()): ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "view/print_buttons.tpl", 'smarty_include_vars' => array('buttons' => $this->_tpl_vars['pageTitleButtons'],'spanClasses' => "visible-lg-inline")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['Page']->GetRssLink()): ?>
                        <a href="<?php echo $this->_tpl_vars['Page']->GetRssLink(); ?>
" class="btn btn-default" title="RSS">
                            <i class="icon-rss"></i>
                            <span class="visible-lg-inline">RSS</span>
                        </a>
                    <?php endif; ?>

                </div>

            <?php endif; ?>

            <?php if ($this->_tpl_vars['DataGrid']['AllowSelect']): ?>
                <div class="btn-group js-selection-actions-container fade" style="display: none">
                    <div class="btn-group">
                        <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">
                                <?php echo sprintf($this->_tpl_vars['Captions']->GetMessageString('ItemsSelected'), '<span class="js-count">0</span>'); ?>

                            </span>
                            <span class="js-count visible-xs-inline">0</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="js-action" data-type="clear"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ClearSelection'); ?>
</a></li>
                            <?php if ($this->_tpl_vars['DataGrid']['AllowCompare']): ?>
                                <li class="divider"></li>
                                <li><a href="#" class="js-action" data-type="compare" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('CompareSelected'); ?>
</a></li>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['DataGrid']['AllowExportSelected']): ?>
                                <li class="divider"></li>
                                <li class="dropdown dropdown-sub-menu">
                                    <a href="#"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Export'); ?>
</a>
                                        <ul class="dropdown-menu sub-menu">
                                            <?php $_from = $this->_tpl_vars['Page']->getExportSelectedRecordsViewData(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Item']):
?>
                                                <li><a href="#" class="js-action" data-type="export" data-export-type="<?php echo $this->_tpl_vars['Item']['Type']; ?>
" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Item']['Caption']; ?>
</a></li>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['DataGrid']['AllowPrintSelected']): ?>
                                <li class="divider"></li>
                                <li><a href="#" class="js-action" data-type="print" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('PrintSelected'); ?>
</a></li>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['DataGrid']['MultiEditAllowed']): ?>
                                <li class="divider"></li>
                                <li><a href="#" class="js-action" data-type="update" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
" <?php if ($this->_tpl_vars['DataGrid']['UseModalMultiEdit']): ?>data-modal-operation="multiple-edit" data-multiple-edit-handler-name="<?php echo $this->_tpl_vars['Page']->GetGridMultiEditHandler(); ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['Captions']->GetMessageString('Update'); ?>
</a></li>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['DataGrid']['AllowDeleteSelected']): ?>
                                <li class="divider"></li>
                                <li><a href="#" class="js-action" data-type="delete" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('DeleteSelected'); ?>
</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (! $this->_tpl_vars['isInline']): ?>
        <div class="addition-block-right pull-right">

            <?php if ($this->_tpl_vars['DataGrid']['FilterBuilder']->hasColumns()): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default js-filter-builder-open" title="<?php if ($this->_tpl_vars['IsActiveFilterEmpty']): ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('CreateFilter'); ?>
<?php else: ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('EditFilter'); ?>
<?php endif; ?>">
                        <i class="icon-filter-alt"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['DataGrid']['EnableSortDialog']): ?>
                <div class="btn-group">
                    <button id="multi-sort-<?php echo $this->_tpl_vars['DataGrid']['Id']; ?>
" class="btn btn-default" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('Sort'); ?>
" data-toggle="modal" data-target="#multiple-sorting-<?php echo $this->_tpl_vars['DataGrid']['Id']; ?>
">
                        <i class="icon-sort"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['PageNavigator'] || $this->_tpl_vars['DataGrid']['EnableRunTimeCustomization']): ?>
                <div class="btn-group">
                    <button class="btn btn-default" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PageSettings'); ?>
" data-toggle="modal" data-target="#page-settings">
                        <i class="icon-settings"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['Page']->getDetailedDescription()): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#detailedDescriptionModal" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PageDescription'); ?>
"><i class="icon-question"></i></button>
                </div>

                <div class="modal fade" id="detailedDescriptionModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $this->_tpl_vars['Page']->getDetailedDescription(); ?>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Close'); ?>
</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['DataGrid']['QuickFilter']->hasColumns() && ! $this->_tpl_vars['isInline']): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/quick_filter.tpl", 'smarty_include_vars' => array('filter' => $this->_tpl_vars['DataGrid']['QuickFilter'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
    </div>

<?php endif; ?>

<?php echo $this->_tpl_vars['GridBeforeFilterStatus']; ?>


<?php if (( $this->_tpl_vars['DataGrid']['FilterBuilder']->hasColumns() || $this->_tpl_vars['DataGrid']['ColumnFilter']->hasColumns() || $this->_tpl_vars['DataGrid']['QuickFilter']->hasColumns() )): ?>
    <div class="filter-status js-filter-status">
        <?php echo $this->_tpl_vars['FilterStatus']; ?>


        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/filter_status_value.tpl', 'smarty_include_vars' => array('filter' => $this->_tpl_vars['DataGrid']['FilterBuilder'],'id' => 'filterBuilder','typeClass' => 'filter-builder','isEditable' => true,'isToggable' => true,'icon' => 'filter-alt','ignoreDisabled' => false,'stringRepresentation' => $this->_tpl_vars['DataGrid']['FilterBuilder']->toString($this->_tpl_vars['Captions'],'<span class="filter-status-value-disabled-component">%s</span>'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/filter_status_value.tpl', 'smarty_include_vars' => array('filter' => $this->_tpl_vars['DataGrid']['ColumnFilter'],'id' => 'columnFilter','typeClass' => 'column-filter','isEditable' => false,'isToggable' => true,'icon' => 'filter','ignoreDisabled' => true,'stringRepresentation' => $this->_tpl_vars['DataGrid']['ColumnFilter']->toString($this->_tpl_vars['Captions']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'danger','dismissable' => true,'messages' => $this->_tpl_vars['DataGrid']['ErrorMessages'],'displayTime' => $this->_tpl_vars['DataGrid']['MessageDisplayTime'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'success','dismissable' => true,'messages' => $this->_tpl_vars['DataGrid']['Messages'],'displayTime' => $this->_tpl_vars['DataGrid']['MessageDisplayTime'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="js-grid-message-container"></div>