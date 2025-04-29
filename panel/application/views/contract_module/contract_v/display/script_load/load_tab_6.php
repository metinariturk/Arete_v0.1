<div class="card-body">
    <h5>Dosya Yöneticisi</h5>
    <div class="download_links mt-3">
        <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;"
           id="openCollectionModal"
           onclick="open_modal('AddFolderModal')"></i>
    </div>
    <div id="folder_table">
        <?php $this->load->view("contract_module/contract_v/display/folder/folder_table"); ?>
    </div>
    <div id="add_folder_modal">
        <?php $this->load->view("contract_module/contract_v/display/folder/add_folder_modal"); ?>
    </div>
    <div id="edit_folder_modal">
        <?php $this->load->view("contract_module/contract_v/display/folder/edit_folder_modal_form"); ?>
    </div>
</div>
