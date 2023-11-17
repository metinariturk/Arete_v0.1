<form id="save_boq"
      action="<?php echo base_url("contract/save_price/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="card-body">
        <table>
            <tr>
                <td><strong>Sözleşme Bedeli</strong></td>
                <td>:</td>
                <td style="text-align: right"><?php echo money_format($item->sozlesme_bedel); ?> <?php echo $item->para_birimi; ?></td>
            </tr>
            <tr>
                <td><strong>Pozlar Toplam Bedeli</strong></td>
                <td>:</td>
                <td style="text-align: right"><?php echo money_format($total_boqs = sum_anything("contract_price", "total", "contract_id", "$item->id")); ?> <?php echo $item->para_birimi; ?></td>
            </tr>
            <tr>
                <td><strong>Fark</strong></td>
                <td>:</td>
                <td style="text-align: right"><?php echo money_format($total_boqs - $item->sozlesme_bedel); ?> <?php echo $item->para_birimi; ?></td>
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
                    </tr>
                    <?php $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC"); ?>
                    <?php foreach ($boq_items as $boq_item) { ?>
                        <tr>
                            <td class="table-cell">
                                <?php echo $boq_item->code; ?>
                            </td>
                            <td class="table-cell">
                                <?php echo $boq_item->name; ?>
                            </td>
                            <td class="table-cell">
                                <?php echo $boq_item->unit; ?>
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
                            <td class="table-cell w10">
                                <input name="boq[<?php echo $boq_item->id; ?>][total]" onclick="hesaplaT"
                                       id="t-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                       value="<?php echo $boq_item->total; ?>">
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="content">
        <div class="text-end">
            <button class="btn btn-success" type="submit" form="save_boq"><i class="menu-icon fa fa-floppy-o fa-lg"
                                                                             aria-hidden="true"></i> Birim Fiyatları
                Kaydet
            </button>
        </div>
    </div>
</form>
