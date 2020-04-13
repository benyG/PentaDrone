<div id="pg-change-password-dialog" class="modal fade" tabindex="-1">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span aria-hidden="true">&times;</span></span></button>
        <h4 class="modal-title" id="pg-change-password-dialog-header-user"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangeYourPassword'); ?>
</h4>
        <h4 class="modal-title" id="pg-change-password-dialog-header-admin"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePasswordForUser'); ?>
 '<span data-bind="text: changePasswordUser.name"></span>'</h4>
    </div>

    <div class="modal-body">

        <form class="form-horizontal">
            <fieldset>

                <div class="form-group" id="pg-change-password-dialog-current-password-form-group">
                    <label class="col-sm-3 control-label" for="pg-change-password-dialog-current-password">
                        <?php echo $this->_tpl_vars['Captions']->GetMessageString('CurrentPassword'); ?>

                    </label>
                    <div class="col-sm-9">
                        <input id="pg-change-password-dialog-current-password"
                               type="password"
                               name="currentPassword"
                               class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pg-change-password-dialog-new-password"><?php echo $this->_tpl_vars['Captions']->GetMessageString('NewPassword'); ?>
</label>
                    <div class="col-sm-9">
                        <input id="pg-change-password-dialog-new-password"
                               type="password"
                               name="newPassword"
                               class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pg-change-password-dialog-confirmed-password"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ConfirmPassword'); ?>
</label>
                    <div class="col-sm-9">
                        <input id="pg-change-password-dialog-confirmed-password"
                               type="password"
                               name="confirmedPassword"
                               class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-9 col-offset-sm-3">
                        <div class="alert alert-warning" id="pg-change-password-dialog-confirmed-password-error">
                            <p><?php echo $this->_tpl_vars['Captions']->GetMessageString('ConfirmedPasswordError'); ?>
</p>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>

    <div class="modal-footer">
        <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Close'); ?>
</a>
        <a href="#" class="btn btn-primary" id="pg-change-password-dialog-ok-button"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePassword'); ?>
</a>
    </div>
  </div>
</div>
</div>