<div class="modal multiple-sorting modal-top fade" id="multiple-sorting-<?php echo $this->_tpl_vars['GridId']; ?>
" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->_tpl_vars['Captions']->GetMessageString('MultipleColumnSorting'); ?>
</h4>
            </div>

            <div class="modal-body">
                <div class=fixed-table-container>
                    <table class="table table-vcenter multiple-sorting-table">
                        <thead>
                            <tr>
                                <td colspan="3" class="header-panel">
                                    <div class="btn-toolbar pull-left">
                                        <div class="btn-group">
                                            <button class="btn btn-default add-sorting-level">
                                                <i class="icon-plus"></i>
                                                <?php echo $this->_tpl_vars['Captions']->GetMessageString('AddLevel'); ?>

                                            </button>
                                            <button class="btn btn-default delete-sorting-level">
                                                <i class="icon-minus"></i>
                                                <?php echo $this->_tpl_vars['Captions']->GetMessageString('DeleteLevel'); ?>

                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="header">
                                <th style="width: 6em;"></th>
                                <th><?php echo $this->_tpl_vars['Captions']->GetMessageString('Column'); ?>
</th>
                                <th><?php echo $this->_tpl_vars['Captions']->GetMessageString('Order'); ?>
</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $_from = $this->_tpl_vars['Levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Index'] => $this->_tpl_vars['Level']):
?>
                            <tr class="sorting-level">
                                <?php if ($this->_tpl_vars['Index'] == 0): ?>
                                    <td><?php echo $this->_tpl_vars['Captions']->GetMessageString('SortBy'); ?>
</td>
                                <?php else: ?>
                                    <td><?php echo $this->_tpl_vars['Captions']->GetMessageString('ThenBy'); ?>
</td>
                                <?php endif; ?>
                                <td>
                                    <select class="multi-sort-name form-control">
                                    <?php $_from = $this->_tpl_vars['SortableHeaders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
                                        <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if (( $this->_tpl_vars['Level']->getFieldName() == $this->_tpl_vars['key'] )): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['value']['caption']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="multi-sort-order form-control">
                                        <option value="a"<?php if (( $this->_tpl_vars['Level']->getShortOrderType() == 'a' )): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['Captions']->GetMessageString('Ascending'); ?>
</option>
                                        <option value="d"<?php if (( $this->_tpl_vars['Level']->getShortOrderType() == 'd' )): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['Captions']->GetMessageString('Descending'); ?>
</option>
                                    </select>
                                </td>
                            </tr>
                            <?php endforeach; endif; unset($_from); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>
</button>
                <button type="button" class="sort-button btn btn-primary"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Sort'); ?>
</button>
            </div>
        </div>
    </div>

</div>