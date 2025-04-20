<div class="modal fade" id="AddCollectionModal" tabindex="-1" role="dialog" aria-labelledby="AddCollectionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Ödeme</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCollectionForm"
                      data-form-url="<?php echo base_url("Contract/create_collection/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Collection_input">
                        <?php $this->load->view("contract_module/contract_v/display/collection/add_collection_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addCollectionForm', 'AddCollectionModal', 'collection_table' ,'add_Collection_input', 'collectionTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
