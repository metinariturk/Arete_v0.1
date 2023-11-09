<form id="save_boq"
      action="<?php echo base_url("contract/save_price/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <button type="submit" form="save_boq">Gönder</button>
    <table class="table-container">
        <tbody>
        <tr>
            <td colspan="5" style="width: 72%"></td>
            <td class="table-cell" style="text-align:right; font-size:9pt;">
                <strong>Sözleşme Tarihi :</strong>
            </td>
            <td class="table-cell" style="text-align:left; font-size:9pt; padding-left: 5px">
                <strong></strong>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="width: 72%"></td>
            <td class="table-cell" style="text-align:right; font-size:9pt;">
                <strong>Sözleşme Bedeli :</strong>
            </td>
            <td class="table-cell" style="text-align:left; font-size:9pt; padding-left: 5px ">
                <strong><?php echo money_format(sum_anything("contract_price","total","contract_id","$item->id")); ?>
                <?php echo $item->para_birimi; ?></strong>
            </td>
        </tr>
        </tbody>
    </table>

    <?php foreach ($prices_main_groups as $prices_main_group) { ?>
        <strong style="font-size: 14pt"><?php echo $prices_main_group->name; ?></strong>

        <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC"); ?>
        <?php foreach ($sub_groups as $sub_group) { ?>
            <table class="table-container">
                <tbody>
                <tr>
                    <td>
                        <p class="sub-group"><strong><?php echo $sub_group->name; ?></strong></p>
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
</form>