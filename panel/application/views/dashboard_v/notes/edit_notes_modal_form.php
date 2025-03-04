<?php if (isset($edit_collection)) { ?>
    <div class="modal fade" id="EditCollectionModal" tabindex="-1" aria-labelledby="editCollectionModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCollectionModalLabel">Ödeme Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCollectionForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/edit_collection/$edit_collection->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="edit_Collection_input">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/collection/edit_collection_form_input"); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            id="EditCollectionModal-<?php echo "$edit_collection->id"; ?>"
                            onclick="submit_modal_form('editCollectionForm', 'EditCollectionModal', 'collection_table' ,'edit_Collection_input', 'collectionTable')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
