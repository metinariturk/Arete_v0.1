<?php if (isset($edit_item)) { ?>
    <div class="modal fade" id="EditContractModal" tabindex="-1" aria-labelledby="editContractModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContractModalLabel">Ödeme Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContractForm"
                          data-form-url="<?php echo base_url("Contract/edit_contract/$edit_item->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="edit_Contract_modal">
                            <?php $this->load->view("contract_module/contract_v/display/contract/edit_contract_form_input"); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            id="EditContractModal-<?php echo "$edit_item->id"; ?>"
                            onclick="submit_modal_form('editContractForm','EditContractModal', 'Contract_card' ,'edit_Contract_modal')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

