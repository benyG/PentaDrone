<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'common/layout.tpl', 16, false),array('modifier', 'urlencode', 'common/layout.tpl', 115, false),)), $this); ?>
<!DOCTYPE html>
<html<?php if ($this->_tpl_vars['common']->getDirection()): ?> dir="<?php echo $this->_tpl_vars['common']->getDirection(); ?>
"<?php endif; ?>>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
    <?php if ($this->_tpl_vars['common']->getContentEncoding()): ?>
        <meta charset="<?php echo $this->_tpl_vars['common']->getContentEncoding(); ?>
">
    <?php endif; ?>
    <?php echo $this->_tpl_vars['common']->getCustomHead(); ?>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?php if ($this->_tpl_vars['common']): ?>
        <title><?php echo $this->_tpl_vars['common']->getTitle(); ?>
</title>
    <?php else: ?>
        <title>Error</title>
    <?php endif; ?>

    <link rel="stylesheet" type="text/css" href="<?php echo ((is_array($_tmp=@$this->_tpl_vars['StyleFile'])) ? $this->_run_mod_handler('default', true, $_tmp, 'components/assets/css/main.css') : smarty_modifier_default($_tmp, 'components/assets/css/main.css')); ?>
" />
    <?php if (! GetOfflineMode ( )): ?>
        <?php echo $this->_tpl_vars['ExternalServicesLoadingBlock']; ?>

    <?php endif; ?>

    <?php if ($this->_tpl_vars['common']): ?>
    <script><?php echo '
        window.beforePageLoad = function () {
            '; ?>
<?php echo $this->_tpl_vars['common']->getClientSideScript('OnBeforeLoadEvent'); ?>
<?php echo '
        }
        window.afterPageLoad = function () {
            '; ?>
<?php echo $this->_tpl_vars['common']->getClientSideScript('OnAfterLoadEvent'); ?>
<?php echo '
        }
    '; ?>
</script>
    <?php endif; ?>

    <script type="text/javascript" src="components/js/require-config.js"></script>
    <?php if (UseMinifiedJS ( )): ?>
        <script type="text/javascript" src="components/js/libs/require.js"></script>
        <script type="text/javascript" src="components/js/main-bundle.js"></script>
    <?php else: ?>
        <script type="text/javascript" data-main="main" src="components/js/libs/require.js"></script>
    <?php endif; ?>
</head>

<?php if ($this->_tpl_vars['Page']): ?>
    <?php $this->assign('PageListObj', $this->_tpl_vars['Page']->GetReadyPageList()); ?>
    <?php if ($this->_tpl_vars['PageListObj'] && $this->_tpl_vars['Page']->GetShowPageList()): ?>
        <?php if ($this->_tpl_vars['PageListObj']->isTypeSidebar()): ?>
            <?php ob_start(); ?>
                <?php echo $this->_tpl_vars['Sidebar']; ?>

                <?php echo $this->_tpl_vars['PageList']; ?>

            <?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('SideBar', ob_get_contents());ob_end_clean(); ?>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['PageListObj']->isTypeMenu()): ?>
            <?php ob_start(); ?>
                <?php echo $this->_tpl_vars['Menu']; ?>

                <?php echo $this->_tpl_vars['PageList']; ?>

            <?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('Menu', ob_get_contents());ob_end_clean(); ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<body<?php if ($this->_tpl_vars['Page']): ?> id="pgpage-<?php echo $this->_tpl_vars['Page']->GetPageId(); ?>
"<?php endif; ?><?php if ($this->_tpl_vars['SideBar'] && ! $this->_tpl_vars['HideSideBarByDefault']): ?> class="sidebar-desktop-active"<?php endif; ?> data-page-entry="<?php echo $this->_tpl_vars['common']->getEntryPoint(); ?>
" data-inactivity-timeout="<?php echo $this->_tpl_vars['common']->getInactivityTimeout(); ?>
"<?php if ($this->_tpl_vars['InactivityTimeoutExpired']): ?> data-inactivity-timeout-expired="true"<?php endif; ?>>
<nav id="navbar" class="navbar navbar-default navbar-fixed-top">

    <?php if ($this->_tpl_vars['SideBar']): ?>
        <div class="toggle-sidebar pull-left" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('SidebarToggle'); ?>
">
            <button class="icon-toggle-sidebar"></button>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="navbar-header">
            <?php if ($this->_tpl_vars['common']): ?>
                <?php echo $this->_tpl_vars['common']->getHeader(); ?>

            <?php endif; ?>
            <?php if ($this->_tpl_vars['Menu'] || $this->_tpl_vars['NavbarContent'] || $this->_tpl_vars['Authentication']['Enabled']): ?>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navnav" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <?php endif; ?>
        </div>

        <div class="navbar-collapse collapse" id="navnav">
            <?php if ($this->_tpl_vars['NavbarContent']): ?><?php echo $this->_tpl_vars['NavbarContent']; ?>
<?php endif; ?>

            <?php if ($this->_tpl_vars['Authentication']['Enabled']): ?>
                <ul id="nav-menu" class="nav navbar-nav navbar-right">
                    <?php if ($this->_tpl_vars['Authentication']['LoggedIn']): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-user"></i>
                                <?php if ($this->_tpl_vars['Authentication']['CurrentUser']['Name'] == 'guest'): ?>
                                    <?php echo $this->_tpl_vars['Captions']->GetMessageString('Guest'); ?>

                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['Authentication']['CurrentUser']['Name']; ?>

                                <?php endif; ?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($this->_tpl_vars['Authentication']['isAdminPanelVisible']): ?>
                                    <li><a href="phpgen_admin.php" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('AdminPage'); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('AdminPage'); ?>
</a></li>
                                    <li role="separator" class="divider"></li>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['Authentication']['CanChangeOwnPassword']): ?>
                                    <li><a id="self-change-password" href="#" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePassword'); ?>
">
                                            <?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePassword'); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li><a href="login.php?operation=logout"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Logout'); ?>
</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php<?php if ($this->_tpl_vars['Page'] && $this->_tpl_vars['Page']->getLink()): ?>?redirect=<?php echo urlencode($this->_tpl_vars['Page']->getLink()); ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Login'); ?>
</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['Menu']): ?>
                <?php echo $this->_tpl_vars['Menu']; ?>

            <?php endif; ?>
        </div>
    </div>
</nav>


<?php if (! isset ( $this->_tpl_vars['HideSideBarByDefault'] )): ?>
    <?php $this->assign('HideSideBarByDefault', false); ?>
<?php endif; ?>


<div class="container-fluid">

    <div class="row<?php if ($this->_tpl_vars['SideBar']): ?> sidebar-owner<?php endif; ?>">

        <?php if ($this->_tpl_vars['SideBar']): ?>

            <div class="sidebar">
                <div class="content">
                    <?php echo $this->_tpl_vars['SideBar']; ?>

                </div>
            </div>
            <div class="sidebar-backdrop"></div>
        <?php endif; ?>

        <div class="<?php if (isset ( $this->_tpl_vars['ContentBlockClass'] )): ?><?php echo $this->_tpl_vars['ContentBlockClass']; ?>
<?php else: ?>col-md-12<?php endif; ?>">
            <?php if ($this->_tpl_vars['SideBar']): ?><div class="sidebar-outer"><?php endif; ?>
                <div class="container-padding">
                    <?php echo $this->_tpl_vars['ContentBlock']; ?>

                    <?php echo $this->_tpl_vars['Variables']; ?>


                    <?php if ($this->_tpl_vars['common']->getFooter()): ?>
                        <hr>
                        <footer>
                            <?php echo $this->_tpl_vars['common']->getFooter(); ?>

                        </footer>
                    <?php endif; ?>

                    <?php 
                        global $Page;

                        if (DebugUtils::GetDebugLevel() > 0 && $Page instanceOf Page) {
                            echo sprintf('<p><pre>%s queries</pre></p>', count($Page->getConnection()->getQueryLog()));
                            echo sprintf('<p><pre>%s</pre></p>', implode("\n", $Page->getConnection()->getQueryLog()));
                        }

                     ?>
                </div>
            <?php if ($this->_tpl_vars['SideBar']): ?></div><?php endif; ?>
        </div>

    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/change_password_dialog.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>