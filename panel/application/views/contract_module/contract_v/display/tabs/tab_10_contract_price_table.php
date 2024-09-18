<div class="container mt-4">
    <p class="f-24">Sözleşme Pozları</p>
    <button id="save-button-top" class="btn btn-primary btn-block">Kaydet</button>

    <table class="table-lg table-border-horizontal">
        <tbody>
        <?php foreach ($prices_main_groups as $prices_main_group) { ?>
            <tr>
                <td colspan="5" style="background-color: rgba(168,165,165,0.8)">
                    <p class="f-18"><?php echo $prices_main_group->code; ?> <?php echo $prices_main_group->name; ?></p>
                </td>
            </tr>
            <?php
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC");
            foreach ($sub_groups as $sub_group) {
                ?>
                <tr>
                    <td colspan="5" style="background-color: #d0cece">
                        <p class="f-16"><?php echo $prices_main_group->code; ?>.<?php echo $sub_group->code; ?> <?php echo $sub_group->name; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="w10"><p>Kod</p></th>
                    <th class="55"><p>İsim</p></th>
                    <th class="w10"><p>Miktar</p></th>
                    <th class="w10"><p>Birim Fiyat</p></th>
                    <th class="w10"><p>Toplam</p></th>
                </tr>
                <?php
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC");
                foreach ($boq_items as $boq_item) {
                    $boq_total = $boq_item->price; // Her bir kalemin fiyatı
                    ?>
                    <tr>
                        <td><p class="f-14"><?php echo $boq_item->code; ?></p></td>
                        <td><p class="f-14"><?php echo $boq_item->name; ?> - <?php echo $boq_item->unit; ?></p></td>
                        <td>
                            <p class="f-14"><input type="number" style="width:125px; height: 8px" class="form-control-sm qty" data-unit-price="<?php echo $boq_item->price; ?>" data-row-id="<?php echo $boq_item->id; ?>" value="<?php if (isset($boq_item->qty)){echo $boq_item->qty;} ?>"></p>
                        </td>
                        <td>
                            <p class="f-14"><span class="unit-price" data-row-id="<?php echo $boq_item->id; ?>"><?php echo $boq_item->price; ?></span></p>
                        </td>
                        <td>
                            <p class="f-14"><span class="total" data-row-id="<?php echo $boq_item->id; ?>"><?php echo $boq_total; ?></span></p>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td colspan="5"></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <button id="save-button-bottom" class="btn btn-primary btn-block">Kaydet</button>
</div>
