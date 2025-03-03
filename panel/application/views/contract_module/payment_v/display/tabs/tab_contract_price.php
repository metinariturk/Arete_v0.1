<?php $prices_main_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "main_group" => 1), "code ASC");; ?>
<div class="container mt-4">
    <input type="text" id="filterInput" class="form-control mb-2" placeholder="Tabloda ara...">
</div>

<div class="container mt-4" id="contract_price_div">
    <div class="table-responsive">
        <table id="contract_price" style="width: 100%">
            <thead>
            <tr>
                <th colspan="6" style="text-align: center">
                    <h4>Sözleşme Pozları</h4>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($prices_main_groups as $prices_main_group) { ?>
                <tr>
                    <td colspan="6" style="background-color: rgba(168,165,165,0.8)">
                        <?php echo $prices_main_group->code; ?><?php echo $prices_main_group->name; ?>
                    </td>
                </tr>
                <?php
                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $prices_main_group->id), "code ASC");
                foreach ($sub_groups as $sub_group) {
                    ?>
                    <tr>
                        <td colspan="6" style="background-color: #d0cece">
                            <?php echo $prices_main_group->code; ?>
                            .<?php echo $sub_group->code; ?> <?php echo $sub_group->name; ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="w10">Kod</th>
                        <th class="w55">İsim</th>
                        <th class="w10">Birim</th>
                        <th class="w10">Miktar</th>
                        <th class="w10">Birim Fiyat</th>
                        <th class="w10">Toplam</th>
                    </tr>
                    <?php
                    $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id), "code ASC");
                    foreach ($boq_items as $boq_item) {
                        $boq_total = $boq_item->price; // Her bir kalemin fiyatı
                        ?>
                        <tr>
                            <td><?php echo $boq_item->code; ?></td>
                            <td><?php echo $boq_item->name; ?></td>
                            <td><?php echo $boq_item->unit; ?></td>
                            <td>
                              <span class="unit-price"><?php echo $boq_item->qty; ?></span>
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
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>