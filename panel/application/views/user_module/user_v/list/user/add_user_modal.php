<div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="AddUserModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Personel</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/create_user"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_User_input">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/user/add_user_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addUserForm', 'AddUserModal', 'user_table' ,'add_User_input')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
