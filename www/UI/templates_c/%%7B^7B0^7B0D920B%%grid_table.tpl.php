<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'list/grid_table.tpl', 1, false),)), $this); ?>
<?php ob_start(); ?><?php echo ((is_array($_tmp=@$this->_tpl_vars['tableColumnHeaderTemplate'])) ? $this->_run_mod_handler('default', true, $_tmp, 'list/grid_column_header.tpl') : smarty_modifier_default($_tmp, 'list/grid_column_header.tpl')); ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('tableColumnHeaderTemplate', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?>
    <table class="table text-center <?php echo $this->_tpl_vars['DataGrid']['Classes']; ?>
<?php if ($this->_tpl_vars['DataGrid']['TableIsBordered']): ?> table-bordered<?php endif; ?><?php if ($this->_tpl_vars['DataGrid']['TableIsCondensed']): ?> table-condensed<?php endif; ?>">
        <thead class="js-column-filter-container<?php if ($this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth() > 1): ?> header-bordered" data-has-groups="true<?php endif; ?>">
            <?php unset($this->_sections['header']);
$this->_sections['header']['name'] = 'header';
$this->_sections['header']['loop'] = is_array($_loop=$this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth()) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['header']['show'] = true;
$this->_sections['header']['max'] = $this->_sections['header']['loop'];
$this->_sections['header']['step'] = 1;
$this->_sections['header']['start'] = $this->_sections['header']['step'] > 0 ? 0 : $this->_sections['header']['loop']-1;
if ($this->_sections['header']['show']) {
    $this->_sections['header']['total'] = $this->_sections['header']['loop'];
    if ($this->_sections['header']['total'] == 0)
        $this->_sections['header']['show'] = false;
} else
    $this->_sections['header']['total'] = 0;
if ($this->_sections['header']['show']):

            for ($this->_sections['header']['index'] = $this->_sections['header']['start'], $this->_sections['header']['iteration'] = 1;
                 $this->_sections['header']['iteration'] <= $this->_sections['header']['total'];
                 $this->_sections['header']['index'] += $this->_sections['header']['step'], $this->_sections['header']['iteration']++):
$this->_sections['header']['rownum'] = $this->_sections['header']['iteration'];
$this->_sections['header']['index_prev'] = $this->_sections['header']['index'] - $this->_sections['header']['step'];
$this->_sections['header']['index_next'] = $this->_sections['header']['index'] + $this->_sections['header']['step'];
$this->_sections['header']['first']      = ($this->_sections['header']['iteration'] == 1);
$this->_sections['header']['last']       = ($this->_sections['header']['iteration'] == $this->_sections['header']['total']);
?>
                <?php $this->assign('depth', $this->_sections['header']['index']); ?>
                <tr>
                    <?php if ($this->_tpl_vars['depth'] == 0): ?>
                        <?php if ($this->_tpl_vars['DataGrid']['AllowSelect']): ?>
                            <th style="width:1%;" rowspan="<?php echo $this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth(); ?>
">
                                <div class="row-selection">
                                    <input type="checkbox">
                                </div>
                            </th>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['DataGrid']['HasDetails']): ?>
                            <th class="details" rowspan="<?php echo $this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth(); ?>
">
                                <a class="expand-all-details js-expand-all-details collapsed link-icon" href="#" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ToggleAllDetails'); ?>
">
                                    <i class="icon-detail-plus"></i>
                                    <i class="icon-detail-minus"></i>
                                </a>
                            </th>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['DataGrid']['ShowLineNumbers']): ?>
                            <th style="width:1%;" rowspan="<?php echo $this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth(); ?>
">#</th>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['DataGrid']['Actions'] && $this->_tpl_vars['DataGrid']['Actions']['PositionIsLeft']): ?>
                            <th style="width:1%;" rowspan="<?php echo $this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth(); ?>
">
                                <?php echo $this->_tpl_vars['DataGrid']['Actions']['Caption']; ?>

                            </th>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php $_from = $this->_tpl_vars['DataGrid']['ColumnGroup']->getAtDepth($this->_tpl_vars['depth']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tableColumnHeaderTemplate'], 'smarty_include_vars' => array('childDepth' => $this->_tpl_vars['child']->getDepth())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endforeach; endif; unset($_from); ?>

                    <?php if ($this->_tpl_vars['depth'] == 0): ?>
                        <?php if ($this->_tpl_vars['DataGrid']['Actions'] && $this->_tpl_vars['DataGrid']['Actions']['PositionIsRight']): ?>
                            <th style="width:1%;" rowspan="<?php echo $this->_tpl_vars['DataGrid']['ColumnGroup']->getDepth(); ?>
">
                                <?php echo $this->_tpl_vars['DataGrid']['Actions']['Caption']; ?>

                            </th>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            <?php endfor; endif; ?>
        </thead>
        <tbody class="pg-row-list">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['SingleRowTemplate'], 'smarty_include_vars' => array('Columns' => $this->_tpl_vars['DataGrid']['ColumnGroup']->getLeafs())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

            <tr class="empty-grid<?php if (count ( $this->_tpl_vars['DataGrid']['Rows'] ) > 0): ?> hidden<?php endif; ?>">
                <td colspan="<?php echo $this->_tpl_vars['DataGrid']['ColumnCount']; ?>
">
                    <div class="alert alert-warning empty-grid"><?php echo $this->_tpl_vars['DataGrid']['EmptyGridMessage']; ?>
</div>
                </td>
            </tr>
        </tbody>

        <tfoot>
            <?php if ($this->_tpl_vars['DataGrid']['Totals']): ?>
                <tr class="data-summary">
                    <?php if ($this->_tpl_vars['DataGrid']['AllowSelect']): ?>
                        <td></td>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['DataGrid']['HasDetails']): ?>
                        <td></td>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['DataGrid']['ShowLineNumbers']): ?>
                        <td></td>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['DataGrid']['Actions'] && $this->_tpl_vars['DataGrid']['Actions']['PositionIsLeft']): ?>
                        <td></td>
                    <?php endif; ?>

                    <?php $_from = $this->_tpl_vars['DataGrid']['Totals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Total']):
?>
                        <td class="<?php echo $this->_tpl_vars['Total']['Classes']; ?>
"><?php echo $this->_tpl_vars['Total']['Value']; ?>
</td>
                    <?php endforeach; endif; unset($_from); ?>

                    <?php if ($this->_tpl_vars['DataGrid']['Actions'] && $this->_tpl_vars['DataGrid']['Actions']['PositionIsRight']): ?>
                        <td></td>
                    <?php endif; ?>
                </tr>
            <?php endif; ?>
        </tfoot>
    </table>
    <script id="<?php echo $this->_tpl_vars['DataGrid']['Id']; ?>
_row_template" type="text/html">
        <tr>
            <td class="pg-inline-edit-container" colspan="<%=getColumnCount()%>">
                <div class="col-md-10 col-md-offset-1 js-inline-edit-container pg-inline-edit-container-loading">
                    <img src="components/assets/img/loading.gif">
                </div>
            </td>
        </tr>
    </script>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('GridContent', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/grid.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>