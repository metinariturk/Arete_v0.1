<?php if (isset($edit_bond)) { ?>
    <div class="modal fade" id="EditBondModal" tabindex="-1" aria-labelledby="EditBondModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditBondModalLabel">Avans Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBondForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/edit_bond/$edit_bond->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="edit_Bond_input">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/bond/edit_bond_form_input"); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            id="EditBondModal-<?php echo "$edit_bond->id"; ?>"
                            onclick="submit_modal_form('editBondForm', 'EditBondModal', 'bond_table' ,'edit_Bond_input', 'bondTable')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
