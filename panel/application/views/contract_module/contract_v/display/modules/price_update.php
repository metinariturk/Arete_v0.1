<form id="save_boq"
      action="<?php echo base_url("contract/save_price/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row price_update">
        <div class="col-8">
            <div class="card-body ">
                <div class="content">
                    <div class="text-start">
                        <a class="btn btn-success" onclick="update_price(this)" form-id="save_boq">
                            <i class="menu-icon fa fa-floppy-o fa-lg" aria-hidden="true"></i> Birim Fiyatları Kaydet
                        </a>
                    </div>
                </div>
                <h4><?php echo money_format(sum_anything("contract_price", "total", "contract_id", "$item->id")); ?></h4>
                <hr>
                <?php foreach ($prices_main_groups as $prices_main_group) { ?>
                    <h5><?php echo $prices_main_group->code." - ".upper_tr($prices_main_group->name); ?> - <?php echo money_format(sum_anything("contract_price", "total", "main_id", "$prices_main_group->id")); ?></h5>
                    <?php $i = 1; ?>
                    <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC"); ?>
                    <?php foreach ($sub_groups as $sub_group) { ?>
                        <?php $i++; ?>
                        <div class="dropTarget" data-info="<?php echo $sub_group->id; ?>">
                            <table class="table-s">
                                <tbody>
                                <tr>
                                    <td colspan="7">
                                        <h6><?php echo $sub_group->code." - ".upper_tr($sub_group->name); ?></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-header-cell">
                                        <p><strong>Poz No:</strong></p>
                                    </td>
                                    <td class="table-header-cell">
                                        <p><strong>Poz Tanımı</strong></p>
                                    </td>
                                    <td class="table-header-cell">
                                        <p><strong>Birim</strong></p>
                                    </td>
                                    <td class="table-header-cell">
                                        <p><strong>Miktar</strong></p>
                                    </td>
                                    <td class="table-header-cell">
                                        <p><strong>Fiyat</strong></p>
                                    </td>
                                    <td class="table-header-cell">
                                        <p><strong>Toplam</strong></p>
                                    </td>
                                    <td class="table-header-cell">
                                        <p><strong>İşlem</strong></p>
                                    </td>
                                </tr>
                                <?php $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC"); ?>
                                <?php foreach ($boq_items as $boq_item) { ?>
                                    <tr>
                                        <td class="table-cell w10">
                                            <input name="boq[<?php echo $boq_item->id; ?>][code]" onclick="hesaplaT"
                                                   style="width: 100%" disabled
                                                   value="<?php echo $boq_item->code; ?>">
                                        </td>
                                        <td class="table-cell w35">
                                            <input name="boq[<?php echo $boq_item->id; ?>][name]" onclick="hesaplaT"
                                                   style="width: 100%" disabled
                                                   value="<?php echo $boq_item->name; ?>">
                                        </td>
                                        <td class="table-cell w5">
                                            <input name="boq[<?php echo $boq_item->id; ?>][unit]" onclick="hesaplaT"
                                                   style="width: 100%" disabled
                                                   value="<?php echo $boq_item->unit; ?>">
                                        </td>
                                        <td class="table-cell w10">
                                            <input name="boq[<?php echo $boq_item->id; ?>][qty]" onclick="hesaplaT"
                                                   id="q-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                                   value="<?php echo $boq_item->qty; ?>">
                                        </td>
                                        <td class="table-cell w15">
                                            <input name="boq[<?php echo $boq_item->id; ?>][price]" onclick="hesaplaT"
                                                   disabled
                                                   id="p-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                                   value="<?php echo $boq_item->price; ?>">
                                        </td>
                                        <td class="table-cell w15">
                                            <input name="boq[<?php echo $boq_item->id; ?>][total]" onclick="hesaplaT"
                                                   id="t-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                                   value="<?php echo $boq_item->total; ?>">
                                        </td>
                                        <td class="table-cell w5">
                                            <a onclick="delete_price_item(this)" id="<?php echo $boq_item->id; ?>">
                                                <i style="color: tomato" class="fa fa-minus-circle fa-2x"
                                                   aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="5">
                                        <h6>TOPLAM</h6>
                                    </td>
                                    <td class="w10">
                                        <input type="number" disabled style="width: 100%"
                                               value="<?php echo sum_anything("contract_price", "total", "sub_id", "$sub_group->id"); ?>">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="col-4">
            <h5>Poz Listesi</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Poz Adı</th>
                    <th>Birimi</th>
                    <th>Fiyat</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($leaders as $leader) { ?>
                    <tr>
                        <td id="dragSource" draggable="true"
                            data-info="<?php echo $leader->id; ?>"><?php echo $leader->code; ?></td>
                        <td id="dragSource" draggable="true"
                            data-info="<?php echo $leader->id; ?>"><?php echo $leader->name; ?> </td>
                        <td id="dragSource" draggable="true"
                            data-info="<?php echo $leader->id; ?>"><?php echo $leader->unit; ?></td>
                        <td id="dragSource" draggable="true"
                            data-info="<?php echo $leader->id; ?>"><?php echo $leader->price; ?></td>
                        <td>
                            <a onclick="delete_price_item(this)" id="<?php echo $leader->id; ?>">
                                <i style="color: tomato" class="fa fa-minus-circle fa-2x"
                                   aria-hidden="true"></i>
                            </a>
                        </td>

                    </tr>
                <?php }; ?>
                </tbody>
            </table>
            <div class="form-control">
                <input name="leader_code" id="leader_code" onclick="hesaplaT"
                       style="width: 100%" type="number"
                       placeholder="Kodu">
            </div>
            <div class="form-control">
                <input name="leader_name" id="leader_name" onclick="hesaplaT"
                       style="width: 100%"
                       placeholder="Poz Adı">
            </div>

            <div class="form-control">
                <input name="leader_unit" id="leader_unit" onclick="hesaplaT"
                       placeholder="Birimi" style="width: 100%"
                       type="Birimi">
            </div>
            <div class="form-control">
                <input name="leader_price" id="leader_price" onclick="hesaplaT"
                       placeholder="Fiyat" style="width: 100%" type="number"
                       type="Fiyat">
            </div>
            <a href="#" id="add_leader_btn">
                <i style="color: green" class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
            </a>
        </div>
    </div>

</form>
