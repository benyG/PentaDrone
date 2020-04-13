<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'list/page_navigator.tpl', 5, false),)), $this); ?>
<div class="pgui-pagination" data-total-record-count="<?php echo $this->_tpl_vars['PageNavigator']->GetRowCount(); ?>
">

    <ul class="pagination">
        <li<?php if (! $this->_tpl_vars['PageNavigator']->HasPreviousPage()): ?> class="disabled"<?php endif; ?>>
            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['PageNavigator']->GetPreviousPageLink())) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" aria-label="Previous" class="pgui-pagination-prev">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php $_from = $this->_tpl_vars['PageNavigatorPages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['PageNavigatorPage']):
?><?php echo ''; ?><?php if ($this->_tpl_vars['PageNavigatorPage']->GetPageLink()): ?><?php echo '<li class="'; ?><?php if ($this->_tpl_vars['PageNavigatorPage']->IsCurrent()): ?><?php echo 'active'; ?><?php else: ?><?php echo 'hidden-xs'; ?><?php endif; ?><?php echo '"><a href="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['PageNavigatorPage']->GetPageLink())) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?><?php echo '" title="'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetHint(); ?><?php echo '"'; ?><?php if ($this->_tpl_vars['PageNavigatorPage']->HasShortCut()): ?><?php echo ' data-pgui-shortcut="'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetShortCut(); ?><?php echo '"'; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?><?php echo '</a></li>'; ?><?php else: ?><?php echo '<li class="pagination-spacer hidden-xs"><a href="#" title="'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetHint(); ?><?php echo '" onclick="return false;">'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?><?php echo '</a></li>'; ?><?php endif; ?><?php echo ''; ?>
<?php endforeach; endif; unset($_from); ?>
        <li<?php if (! $this->_tpl_vars['PageNavigator']->HasNextPage()): ?> class="disabled"<?php endif; ?>>
            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['PageNavigator']->GetNextPageLink())) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" aria-label="Next" class="pgui-pagination-next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>

</div>