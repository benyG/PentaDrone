<script>
    <?php echo '
        function '; ?>
<?php echo $this->_tpl_vars['Grid']['FormId']; ?>
<?php echo '_initd(editors) {
            '; ?>
<?php echo $this->_tpl_vars['Grid']['ClientOnLoadScript']; ?>
<?php echo '
        }
        function '; ?>
<?php echo $this->_tpl_vars['Grid']['FormId']; ?>
<?php echo 'Validation(fieldValues, errorInfo) {
            '; ?>
<?php echo $this->_tpl_vars['Grid']['ClientValidationScript']; ?>
<?php echo '; return true;
        }
        function '; ?>
<?php echo $this->_tpl_vars['Grid']['FormId']; ?>
<?php echo '_EditorValuesChanged(sender, editors) {
            '; ?>
<?php echo $this->_tpl_vars['Grid']['ClientValueChangedScript']; ?>
<?php echo '
        }
        function '; ?>
<?php echo $this->_tpl_vars['Grid']['FormId']; ?>
<?php echo '_CalculateControlValues(editors) {
        '; ?>
<?php echo $this->_tpl_vars['Grid']['ClientCalculateControlValuesScript']; ?>
<?php echo '
    }
    '; ?>

</script>