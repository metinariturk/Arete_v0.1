<div class="modal fade" id="AddFolderModal" tabindex="-1" role="dialog" aria-labelledby="AddFolderModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Klaösr</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFolderForm"
                      data-form-url="<?php echo base_url("Contract/create_folder/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Folder_input">
                        <?php $this->load->view("contract_module/contract_v/display/folder/add_folder_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addFolderForm', 'AddFolderModal', 'folder_table' ,'add_Folder_input', '')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
