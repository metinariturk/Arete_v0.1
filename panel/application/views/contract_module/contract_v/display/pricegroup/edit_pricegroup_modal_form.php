<?php if (isset($edit_pricegroup)) { ?>
    <div class="modal fade" id="EditPricegroupModal" tabindex="-1" aria-labelledby="EditPricegroupModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditPricegroupModalLabel">Alt Grup Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPricegroupForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/update_leader_selection/$edit_pricegroup->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="edit_Pricegroup_input">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/pricegroup/edit_pricegroup_form_input"); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            id="EditPricegroupModal-<?php echo "$edit_pricegroup->id"; ?>"
                            onclick="submit_subgroup_leaders('editPricegroupForm', 'EditPricegroupModal', 'pricegroup_table' ,'tab_contract_price_table')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
