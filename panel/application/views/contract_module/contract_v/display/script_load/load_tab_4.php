<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);"
                   id="tab4-1-link"
                   data-bs-toggle="tab" href="#tab4-1" role="tab">
                    <h5>Ödemeler</h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab4-2-link"
                   data-bs-toggle="tab" href="#tab4-2" role="tab">
                    <h5>Avanslar</h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab4-3-link"
                   data-bs-toggle="tab" href="#tab4-3" role="tab">
                    <h5>Teminatlar</h5>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab4-1" role="tabpanel"
                 aria-labelledby="tab4-1-link">
                <div class="download_links mt-3">
                    <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;"
                       id="openCollectionModal"
                       onclick="open_modal('AddCollectionModal')"></i>
                    <a href="<?php echo base_url('export/collection_download_excel'); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url('export/collection_download_pdf'); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <div id="collection_table">
                    <?php $this->load->view("contract_module/contract_v/display/collection/collection_table"); ?>
                </div>
                <div id="add_collection_modal">
                    <?php $this->load->view("contract_module/contract_v/display/collection/add_collection_modal"); ?>
                </div>
                <div id="edit_collection_modal">
                    <?php $this->load->view("contract_module/contract_v/display/collection/edit_collection_modal_form"); ?>
                </div>
            </div>

            <div class="tab-pane fade" id="tab4-2" role="tabpanel" aria-labelledby="tab4-2-link">
                <div class="download_links mt-3">
                    <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                       id="openAdvanceModal"
                       data-bs-target="#AddAdvanceModal"></i>
                    <a href="<?php echo base_url('export/advance_download_excel'); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url('export/advance_download_pdf'); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <div id="advance_table">
                    <?php $this->load->view("contract_module/contract_v/display/advance/advance_table"); ?>
                </div>
                <div id="add_advance_modal">
                    <?php $this->load->view("contract_module/contract_v/display/advance/add_advance_modal"); ?>
                </div>
                <div id="edit_advance_modal">
                    <?php $this->load->view("contract_module/contract_v/display/advance/edit_advance_modal_form"); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="tab4-3" role="tabpanel" aria-labelledby="tab4-3-link">
                <div class="download_links mt-3">
                    <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                       id="openBondModal"
                       data-bs-target="#AddBondModal"></i>
                    <a href="<?php echo base_url('export/bond_download_excel'); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url('export/bond_download_pdf'); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <div id="bond_table">
                    <?php $this->load->view("contract_module/contract_v/display/bond/bond_table"); ?>
                </div>
                <div id="add_bond_modal">
                    <?php $this->load->view("contract_module/contract_v/display/bond/add_bond_modal"); ?>
                </div>
                <div id="edit_bond_modal">
                    <?php $this->load->view("contract_module/contract_v/display/bond/edit_bond_modal_form"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
