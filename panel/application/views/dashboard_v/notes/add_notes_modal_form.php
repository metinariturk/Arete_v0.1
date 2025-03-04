<div class="modal fade" id="AddSubContractModal" tabindex="-1" aria-labelledby="addSubContractModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubContractModalLabel">Alt Sözleşme Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSubContractForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/add_sub_contract/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Sub_Contract_modal">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sub_contract/add_sub_contract_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        id="AddSubContractModal"
                        onclick="submit_modal_form('addSubContractForm','AddSubContractModal', 'sub_contract_table' ,'add_Sub_Contract_modal')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>