<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'home_page.tpl', 40, false),)), $this); ?>
<?php ob_start(); ?>

    <?php echo $this->_tpl_vars['BeforePageList']; ?>


    <?php $this->assign('ListObj', $this->_tpl_vars['Page']->getReadyPageList()); ?>
    <?php $this->assign('List', $this->_tpl_vars['ListObj']->GetViewData()); ?>
    <?php $this->assign('SelectedGroup', $this->_tpl_vars['Page']->getSelectedGroup()); ?>

    <?php if (is_null ( $this->_tpl_vars['SelectedGroup'] )): ?>
        <?php echo $this->_tpl_vars['Banner']; ?>

    <?php endif; ?>

    <?php $_from = $this->_tpl_vars['List']['Groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Group']):
?>
        <?php $this->assign('GroupCaption', $this->_tpl_vars['Group']->getCaption()); ?>
        <?php $this->assign('GroupDescription', $this->_tpl_vars['Group']->getDescription()); ?>

        <?php if (is_null ( $this->_tpl_vars['SelectedGroup'] ) || $this->_tpl_vars['GroupCaption'] == $this->_tpl_vars['SelectedGroup']): ?>
            <div class="row pgui-home-row<?php if ($this->_tpl_vars['GroupCaption'] == 'Default'): ?> pgui-home-group-default<?php endif; ?>">
            <?php if ($this->_tpl_vars['GroupCaption'] != 'Default'): ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                <h2<?php if ($this->_tpl_vars['GroupDescription'] == ''): ?> class="pgui-home-group"<?php endif; ?>><?php echo $this->_tpl_vars['GroupCaption']; ?>
</h2>
                <?php if ($this->_tpl_vars['GroupDescription'] != ''): ?>
                    <p class="lead"><?php echo $this->_tpl_vars['GroupDescription']; ?>
</p>
                <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php $_from = $this->_tpl_vars['List']['Pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['PageListPage']):
?>

                <?php if ($this->_tpl_vars['PageListPage']['GroupName'] == $this->_tpl_vars['GroupCaption']): ?>
                    <?php if ($this->_tpl_vars['PageListPage']['BeginNewGroup']): ?>
                        </div>
                        <hr>
                        <div class="row pgui-home-group">
                    <?php endif; ?>

                    <div class="col-md-4 col-sm-6 col-xs-12 pgui-home-col">
                        <div class="pgui-home-item-wrapper">
                            <div class="pgui-home-item<?php if ($this->_tpl_vars['PageListPage']['ClassAttribute']): ?> <?php echo $this->_tpl_vars['PageListPage']['ClassAttribute']; ?>
<?php endif; ?>">
                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['PageListPage']['Href'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" title="<?php echo $this->_tpl_vars['PageListPage']['Hint']; ?>
">
                                    <?php echo $this->_tpl_vars['PageListPage']['Caption']; ?>

                                </a>

                                <?php if ($this->_tpl_vars['PageListPage']['Description']): ?>
                                    <p><?php echo $this->_tpl_vars['PageListPage']['Description']; ?>
</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </div>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

    <?php echo $this->_tpl_vars['AfterPageList']; ?>


<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['layoutTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>