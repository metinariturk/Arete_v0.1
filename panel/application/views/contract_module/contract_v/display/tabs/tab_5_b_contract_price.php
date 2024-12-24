<div class="container mt-4 contract_price_div">
    <div class="row">
        <?php foreach ($prices_main_groups as $prices_main_group) { ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white" style="padding: 5px;">
                        <strong style="font-size: 0.9rem;"><?php echo $prices_main_group->code; ?>
                            - <?php echo upper_tr($prices_main_group->name); ?></strong>
                    </div>
                    <div class="card-body" style="padding: 5px;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th>Alt Grup Kodu</th>
                                    <th>Alt Grup Adı</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");
                                foreach ($sub_groups as $sub_group) {
                                    ?>
                                        <tr>
                                            <td colspan="3">
                                                <hr>
                                            </td>
                                        </tr>
                                    <tr>
                                        <td><?php echo $prices_main_group->code . '.' . $sub_group->code; ?></td>
                                        <td>
                                            <?php echo upper_tr($sub_group->name); ?>
                                        </td>
                                        <td>
                                            <a data-bs-toggle="modal" class="text-success"
                                               id="open_edit_contract_price_modal_<?php echo $sub_group->id; ?>"
                                               onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_contract_price/$sub_group->id"); ?>','edit_contract_price_modal','EditContractPriceModal')">
                                                <i class="fa fa-plus-circle fa-xl"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "code ASC");
                                    if (!empty($boq_items)) {
                                        foreach ($boq_items

                                                 as $boq_item) {
                                            ?>
                                            <tr>

                                                <td>
                                                    <?php echo $boq_item->code; ?>
                                                </td>
                                                <td>
                                                    <?php echo $boq_item->name; ?>
                                                </td>
                                                <td>
                                                    (<?php echo $boq_item->unit; ?>)
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div id="edit_contract_price_modal">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/edit_contract_price_modal_form"); ?>
</div>
