<div class="modal fade" id="AddNotesModal" tabindex="-1" aria-labelledby="addNotesModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNotesModalLabel">Alt Sözleşme Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addNotesForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/add_notes"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Notes_modal">
                        <?php $this->load->view("{$viewFolder}/notes/add_notes_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addNotesForm','AddNotesModal', 'notes_table' ,'add_Notes_modal')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>