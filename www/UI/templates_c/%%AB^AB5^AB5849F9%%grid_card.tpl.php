<?php $this->assign('GridClass', 'grid-card'); ?>

<?php ob_start(); ?>
    <?php if ($this->_tpl_vars['DataGrid']['ColumnFilter']->hasColumns()): ?>
        <ul class="nav nav-pills pull-right js-column-filter-container grid-card-column-filter">
            <?php $_from = $this->_tpl_vars['DataGrid']['ColumnFilter']->getColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Column']):
?>
                <li data-name="<?php echo $this->_tpl_vars['Column']->getFieldName(); ?>
"<?php if ($this->_tpl_vars['DataGrid']['ColumnFilter']->isColumnActive($this->_tpl_vars['Column']->getFieldName())): ?> class="active"<?php endif; ?>>
                    <a href="#" class="js-filter-trigger" title="<?php echo $this->_tpl_vars['DataGrid']['ColumnFilter']->toStringFor($this->_tpl_vars['Column']->getFieldName(),$this->_tpl_vars['Captions']); ?>
">
                        <i class="icon-filter"></i>&nbsp;
                        <?php echo $this->_tpl_vars['Column']->getCaption(); ?>

                    </a>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    <?php endif; ?>

    <div class="clearfix"></div>

    <?php echo $this->_tpl_vars['GridBeforeFilterStatus']; ?>

<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('GridBeforeFilterStatus', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?>
    <div class="row">
        <div class="<?php echo $this->_tpl_vars['DataGrid']['Classes']; ?>
 col-md-12" <?php echo $this->_tpl_vars['DataGrid']['Attributes']; ?>
>

            <div class="alert alert-warning empty-grid<?php if (count ( $this->_tpl_vars['DataGrid']['Rows'] ) > 0): ?> hidden<?php endif; ?>">
                <?php echo $this->_tpl_vars['DataGrid']['EmptyGridMessage']; ?>

            </div>

            <div class="pg-row-list row">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['SingleRowTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>

            <div>
                <?php if ($this->_tpl_vars['DataGrid']['Totals']): ?>
                    <table class="table table-bordered table-totals">
                        <?php $_from = $this->_tpl_vars['DataGrid']['Totals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Total']):
?>
                            <?php if ($this->_tpl_vars['Total']['Value']): ?>
                                <tr>
                                    <th><?php echo $this->_tpl_vars['Total']['Caption']; ?>
</th>
                                    <td><?php echo $this->_tpl_vars['Total']['Value']; ?>
</td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script id="<?php echo $this->_tpl_vars['DataGrid']['Id']; ?>
_row_template" type="text/html">
        <div class="grid-card-item pg-row <?php if ($this->_tpl_vars['isMasterGrid']): ?>col-md-12<?php else: ?><?php echo $this->_tpl_vars['DataGrid']['CardClasses']; ?>
<?php endif; ?>">
            <div class="well">
                <div class="js-inline-edit-container pg-inline-edit-container-loading">
                    <img src="components/assets/img/loading.gif">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </script>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('GridContent', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/grid.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>