<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'list/detail_page.tpl', 15, false),array('modifier', 'sprintf', 'list/detail_page.tpl', 57, false),)), $this); ?>
<?php ob_start(); ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/external_services.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ExternalServicesLoadingBlock', ob_get_contents());ob_end_clean(); ?>

<?php $this->assign('ContentBlockClass', 'col-md-12 grid-details'); ?>

<?php ob_start(); ?>

    <?php if (! $this->_tpl_vars['isInline']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page_header.tpl", 'smarty_include_vars' => array('pageTitle' => $this->_tpl_vars['PageTitle'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page_description_block.tpl", 'smarty_include_vars' => array('Description' => $this->_tpl_vars['Page']->getDescription())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <p><?php echo $this->_tpl_vars['Captions']->GetMessageString('MasterRecord'); ?>

        (<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['Page']->GetParentPageLink())) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ReturnFromDetailToMaster'); ?>
</a>)
    </p>

        <?php echo $this->_tpl_vars['MasterGrid']; ?>


    <?php if (count ( $this->_tpl_vars['SiblingDetails'] ) > 1): ?>
        <ul class="nav nav-tabs grid-details-tabs">
            <?php $_from = $this->_tpl_vars['SiblingDetails']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['SiblingDetailsSection'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['SiblingDetailsSection']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['SiblingDetail']):
        $this->_foreach['SiblingDetailsSection']['iteration']++;
?>
                <li class="<?php if ($this->_tpl_vars['DetailPageName'] == $this->_tpl_vars['SiblingDetail']['Name']): ?>active<?php endif; ?>">
                    <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['SiblingDetail']['Link'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
">
                        <?php echo $this->_tpl_vars['SiblingDetail']['Caption']; ?>

                    </a>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    <?php endif; ?>
    <?php endif; ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "charts/collection.tpl", 'smarty_include_vars' => array('charts' => $this->_tpl_vars['ChartsBeforeGrid'],'chartsClasses' => $this->_tpl_vars['ChartsBeforeGridClasses'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php if (! $this->_tpl_vars['isInline']): ?>
        <?php echo $this->_tpl_vars['PageNavigator1']; ?>

    <?php endif; ?>

    <?php echo $this->_tpl_vars['Grid']; ?>


    <?php if (! $this->_tpl_vars['isInline']): ?>
        <?php echo $this->_tpl_vars['PageNavigator2']; ?>

    <?php endif; ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "charts/collection.tpl", 'smarty_include_vars' => array('charts' => $this->_tpl_vars['ChartsAfterGrid'],'chartsClasses' => $this->_tpl_vars['ChartsAfterGridClasses'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php if (! $this->_tpl_vars['isInline']): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/page_navigator_modal.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php if (! $this->_tpl_vars['isInline']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/list_page_template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
    <p>
        <?php echo sprintf($this->_tpl_vars['Captions']->GetMessageString('ShownFirstMofNRecords'), $this->_tpl_vars['Page']->getFirstPageRecordCount(), $this->_tpl_vars['Page']->getTotalRowCount()); ?>

        (<a href="<?php echo $this->_tpl_vars['Page']->GetLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('FullView'); ?>
</a>)
    </p>

    <?php echo $this->_tpl_vars['ContentBlock']; ?>

<?php endif; ?>