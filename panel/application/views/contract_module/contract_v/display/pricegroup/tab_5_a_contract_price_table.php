<div class="container mt-4" id="contract_price_div">
    <button class="btn btn-primary w-100" onclick="saveData()">
    <span style="font-size: 1.25rem;">
        Kaydet <i class="fa fa-floppy-o"></i>
    </span>
    </button>
    <div class="table-responsive">
        <table id="contract_price" style="width: 100%">
            <thead>
            <tr>
                <th colspan="5" style="text-align: center">
                    <h4>Sözleşme Pozları</h4>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($prices_main_groups as $prices_main_group) { ?>
                <tr>
                    <td colspan="5" style="background-color: rgba(168,165,165,0.8)">
                        <?php echo $prices_main_group->code; ?><?php echo $prices_main_group->name; ?>
                    </td>
                </tr>
                <?php
                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");
                foreach ($sub_groups as $sub_group) {
                    ?>
                    <tr>
                        <td colspan="5" style="background-color: #d0cece">
                            <?php echo $prices_main_group->code; ?>
                            .<?php echo $sub_group->code; ?> <?php echo $sub_group->name; ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="w10">Kod</th>
                        <th class="w55">İsim</th>
                        <th class="w10">Miktar</th>
                        <th class="w10">Birim Fiyat</th>
                        <th class="w10">Toplam</th>
                    </tr>
                    <?php
                    $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "code ASC");
                    foreach ($boq_items as $boq_item) {
                        $boq_total = $boq_item->price; // Her bir kalemin fiyatı
                        ?>
                        <tr>
                            <td><?php echo $boq_item->code; ?></td>
                            <td><?php echo $boq_item->name; ?> - <?php echo $boq_item->unit; ?></td>
                            <td>
                                <input type="number" class="form-control-sm qty"
                                       data-unit-price="<?php echo $boq_item->price; ?>"
                                       data-row-id="<?php echo $boq_item->id; ?>"
                                       value="<?php if (isset($boq_item->qty)) {
                                           echo $boq_item->qty;
                                       } ?>">
                            </td>
                            <td>
                                <span class="unit-price"
                                      data-row-id="<?php echo $boq_item->id; ?>"><?php echo $boq_item->price; ?></span>
                            </td>
                            <td>
                                <span class="total"
                                      data-row-id="<?php echo $boq_item->id; ?>"><?php echo $boq_total; ?></span>
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
    </div>
    <button class="btn btn-primary w-100" onclick="saveData()">
    <span style="font-size: 1.25rem;">
        Kaydet <i class="fa fa-floppy-o"></i>
    </span>
    </button>
</div>