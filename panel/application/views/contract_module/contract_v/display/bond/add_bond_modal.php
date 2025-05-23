<div class="modal fade" id="AddBondModal" tabindex="-1" role="dialog" aria-labelledby="AddBondModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Teminat</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBondForm"
                      data-form-url="<?php echo base_url("Contract/create_bond/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Bond_input">
                        <?php $this->load->view("contract_module/contract_v/display/bond/add_bond_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addBondForm', 'AddBondModal', 'bond_table' ,'add_Bond_input', 'bondTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
