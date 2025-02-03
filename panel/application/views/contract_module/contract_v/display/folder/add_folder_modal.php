<div class="modal fade" id="AddAdvanceModal" tabindex="-1" role="dialog" aria-labelledby="AddAdvanceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Avans</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdvanceForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/create_advance/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Advance_input">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/advance/add_advance_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addAdvanceForm', 'AddAdvanceModal', 'advance_table' ,'add_Advance_input', 'advanceTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
