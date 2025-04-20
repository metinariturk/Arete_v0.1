<?php if (isset($edit_advance)) { ?>
<div class="modal fade" id="EditAdvanceModal" tabindex="-1" aria-labelledby="editAdvanceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdvanceModalLabel">Avans Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAdvanceForm"
                      data-form-url="<?php echo base_url("Contract/edit_advance/$edit_advance->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="edit_Advance_input">
                        <?php $this->load->view("contract_module/contract_v/display/advance/edit_advance_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        id="EditAdvanceModal-<?php echo "$edit_advance->id"; ?>"
                        onclick="submit_modal_form('editAdvanceForm', 'EditAdvanceModal', 'advance_table' ,'edit_Advance_input', 'advanceTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

