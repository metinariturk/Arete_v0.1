<form id="save_boq"
      action="<?php echo base_url("contract/save_price/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="card-body">
        <table>
            <tr>
                <td><strong>Sözleşme Bedeli</strong></td>
                <td>:</td>
                <td style="text-align: right"><?php echo money_format($item->sozlesme_bedel); ?><?php echo $item->para_birimi; ?></td>
            </tr>
            <tr>
                <td><strong>Pozlar Toplam Bedeli</strong></td>
                <td>:</td>
                <td style="text-align: right">

                    <?php $total_boqs = $this->Contract_price_model->sum_all(array("contract_id" => $item->id, "sub_group" => null, "main_group" => null),"total"); ?>
                <?php echo money_format($total_boqs); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Fark</strong></td>
                <td>:</td>
                <td style="text-align: right"><?php echo money_format($total_boqs - $item->sozlesme_bedel); ?><?php echo $item->para_birimi; ?></td>
            </tr>
        </table>
        <hr>
        <?php foreach ($prices_main_groups as $prices_main_group) { ?>
            <strong style="font-size: 14pt"><?php echo upper_tr($prices_main_group->name); ?></strong>

            <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC"); ?>
            <?php foreach ($sub_groups as $sub_group) { ?>
                <table class="table-container">
                    <tbody>
                    <tr>
                        <td>
                            <p class="sub-group"><strong><?php echo upper_tr($sub_group->name); ?></strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td hidden class="table-header-cell">
                            <p><strong>Sub_id</strong></p>
                        </td>
                        <td class="table-header-cell" delete_group>
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
                            <td hidden class="table-cell">
                                <input name="boq[<?php echo $boq_item->id; ?>][id]" onclick="hesaplaT"
                                       style="width: 100%"
                                       value="<?php echo $boq_item->sub_id; ?>">

                            </td>
                            <td class="table-cell w10">
                                <input name="boq[<?php echo $boq_item->id; ?>][code]" onclick="hesaplaT"
                                        style="width: 100%"
                                       value="<?php echo $boq_item->code; ?>">

                            </td>
                            <td class="table-cell w50">
                                <input name="boq[<?php echo $boq_item->id; ?>][name]" onclick="hesaplaT"
                                        style="width: 100%"
                                       value="<?php echo $boq_item->name; ?>">

                            </td>
                            <td class="table-cell w5">
                                <input name="boq[<?php echo $boq_item->id; ?>][unit]" onclick="hesaplaT"
                                        style="width: 100%"
                                       value="<?php echo $boq_item->unit; ?>">

                            </td>
                            <td class="table-cell w10">
                                <input name="boq[<?php echo $boq_item->id; ?>][qty]" onclick="hesaplaT"
                                       id="q-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                       value="<?php echo $boq_item->qty; ?>">
                            </td>
                            <td class="table-cell w10">
                                <input name="boq[<?php echo $boq_item->id; ?>][price]" onclick="hesaplaT"
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
                                    <i style="color: tomato" class="fa fa-minus-circle fa-2x" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td hidden class="table-cell" >
                            <input  style="width: 100%" name="boq[<?php echo $sub_group->id; ?>][id]">
                        </td>
                        <td class="table-cell" delete_group>
                            <input style="width: 100%" name="boq[<?php echo $sub_group->id; ?>][code]"
                                   placeholder="Poz No">
                        </td>
                        <td class="table-cell">
                            <input style="width: 100%" name="boq[<?php echo $sub_group->id; ?>][name]"
                                   placeholder="Tanımı">
                        </td>
                        <td class="table-cell">
                            <input style="width: 100%" name="boq[<?php echo $sub_group->id; ?>][unit]"
                                   placeholder="Birim">
                        </td>
                        <td class="table-cell w10">
                            <input name="boq[<?php echo $sub_group->id; ?>][qty]" onclick="hesaplaT"
                                   id="q-<?php echo $sub_group->id; ?>" style="width: 100%" type="number"
                                   placeholder="Miktar">
                        </td>
                        <td class="table-cell w10">
                            <input name="boq[<?php echo $sub_group->id; ?>][price]" onclick="hesaplaT"
                                   placeholder="Birim Fiyat" id="p-<?php echo $sub_group->id; ?>" style="width: 100%"
                                   type="number"">
                        </td>
                        <td class="table-cell w10">
                            <input name="boq[<?php echo $sub_group->id; ?>][total]" onclick="hesaplaT"
                                   placeholder="Toplam" id="t-<?php echo $sub_group->id; ?>" style="width: 100%"
                                   type="number">
                        </td>
                        <td class="table-cell w10">
                            <a onclick="update_price(this)" form-id="save_boq">
                                <i style="color: green" class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right">
                           TOPLAM
                        </td>
                        <td>
                           <?php echo money_format($sub_group->total); ?>
                           <?php echo $item->para_birimi; ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="content">
        <div class="text-end">
            <a class="btn btn-success" onclick="update_price(this)" form-id="save_boq">
                <i class="menu-icon fa fa-floppy-o fa-lg" aria-hidden="true"></i> Birim Fiyatları Kaydet
            </a>
        </div>
    </div>
</form>
