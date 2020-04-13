<?php if (( HasHomePage ( ) || count ( $this->_tpl_vars['navigation'] ) > 1 )): ?>
    <ol class="breadcrumb pgui-breadcrumb">
        <?php if (HasHomePage ( )): ?>
            <li><a href="<?php echo GetHomeURL(); ?>"><i class="icon-home"></i></a></li>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['navigation']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['navigation'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['navigation']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['navigation']['iteration']++;
?>
            <li class="dropdown">
                <?php if ($this->_tpl_vars['item']['url'] && ! ($this->_foreach['navigation']['iteration'] == $this->_foreach['navigation']['total'])): ?>
                    <a href="<?php echo $this->_tpl_vars['item']['url']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
                <?php else: ?>
                    <?php echo $this->_tpl_vars['item']['title']; ?>

                <?php endif; ?>


                <?php if ($this->_tpl_vars['item']['siblings'] && count ( $this->_tpl_vars['item']['siblings'] ) > 0): ?>
                    <button class="btn btn-xs btn-default dropdown-toggle pgui-breadcrumb-siblings" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <?php $_from = $this->_tpl_vars['item']['siblings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sibling']):
?>
                            <li><a href="<?php echo $this->_tpl_vars['sibling']['url']; ?>
"><?php echo $this->_tpl_vars['sibling']['title']; ?>
</a></li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; endif; unset($_from); ?>
    </ol>
<?php endif; ?>