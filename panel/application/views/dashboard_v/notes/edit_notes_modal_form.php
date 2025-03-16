<?php if (isset($edit_note)) { ?>
    <div class="modal fade" id="EditNotesModal" tabindex="-1" aria-labelledby="EditNotesModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditNotesModalLabel">Not Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="EditNotesForm"
                          data-form-url="<?php echo base_url("Dashboard/edit_Notes/$edit_note->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="edit_Notes_input">
                            <?php $this->load->view("dashboard_v/notes/edit_notes_form_input"); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            id="EditNotesModal-<?php echo "$edit_note->id"; ?>"
                            onclick="submit_modal_form('EditNotesForm','EditNotesModal', 'notes_table' ,'edit_Notes_input')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
