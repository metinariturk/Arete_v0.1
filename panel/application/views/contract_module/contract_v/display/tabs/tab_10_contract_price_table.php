<div class="container mt-4">
    <h3>Sözleşme Pozları</h3>
    <button id="save-button-top" class="btn btn-primary btn-block">Kaydet</button>

    <table class="table table-bordered">
        <tbody>
        <?php foreach ($prices_main_groups as $prices_main_group) { ?>
            <tr>
                <td colspan="5" style="background-color: #808080">
                    <?php echo $prices_main_group->code; ?> <?php echo $prices_main_group->name; ?>
                </td>
            </tr>
            <?php
            $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC");
            foreach ($sub_groups as $sub_group) {
                ?>
                <tr>
                    <td colspan="5" style="background-color: #d0cece">
                        <?php echo $prices_main_group->code; ?>.<?php echo $sub_group->code; ?> <?php echo $sub_group->name; ?>
                    </td>
                </tr>
                <tr>
                    <th>Kod</th>
                    <th>İsim</th>
                    <th>Miktar</th>
                    <th>Birim Fiyat</th>
                    <th>Toplam</th>
                </tr>
                <?php
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC");
                foreach ($boq_items as $boq_item) {
                    $boq_total = $boq_item->price; // Her bir kalemin fiyatı
                    ?>
                    <tr>
                        <td><?php echo $boq_item->code; ?></td>
                        <td><?php echo $boq_item->name; ?> - <?php echo $boq_item->unit; ?></td>
                        <td><input type="number" class="form-control qty" data-unit-price="<?php echo $boq_item->price; ?>" data-row-id="<?php echo $boq_item->id; ?>" value="<?php if (isset($boq_item->qty)){echo $boq_item->qty;} ?>"></td>
                        <td><span class="unit-price" data-row-id="<?php echo $boq_item->id; ?>"><?php echo $boq_item->price; ?></span></td>
                        <td><span class="total" data-row-id="<?php echo $boq_item->id; ?>"><?php echo $boq_total; ?></span></td>
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
