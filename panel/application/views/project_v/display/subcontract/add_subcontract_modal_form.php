<div class="modal fade" id="AddContractModal" role="dialog" aria-labelledby="AddContractModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Ödeme</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addContractForm"
                      data-form-url="<?php echo base_url("Project/create_contract/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Contract_input">
                        <?php $this->load->view("{$viewFolder}/{$subViewFolder}/contract/add_contract_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addContractForm', 'AddContractModal', 'contract_table' ,'add_Contract_input')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
