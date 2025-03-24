<?php if (isset($edit_user)) { ?>
    <div class="modal fade" id="EditUserModal" tabindex="-1" aria-labelledby="EditUserModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditUserModalLabel">Avans Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/edit_user/$edit_user->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="edit_User_input">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/user/edit_user_form_input"); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            id="EditUserModal-<?php echo "$edit_user->id"; ?>"
                            onclick="submit_modal_form('editUserForm', 'EditUserModal', 'user_table' ,'edit_User_input')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
