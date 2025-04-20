<?php if (isset($edit_payment)) { ?>
<div class="modal fade" id="EditPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentModalLabel">Avans Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPaymentForm"
                      data-form-url="<?php echo base_url("Contract/edit_payment/$edit_payment->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="edit_Payment_input">
                        <?php $this->load->view("contract_module/contract_v/display/payment/edit_payment_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        id="EditPaymentModal-<?php echo "$edit_payment->id"; ?>"
                        onclick="submit_modal_form('editPaymentForm', 'EditPaymentModal', 'payment_table' ,'edit_Payment_input')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

