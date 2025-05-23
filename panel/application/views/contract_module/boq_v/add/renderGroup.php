<div class="table-responsive">
    <table class="table table-xs">
        <thead>
        <tr>
            <th colspan="4" style="text-align: center">
                <a onclick="renderGroup(this)"
                   class="btn btn-success me-3" href="#" style="width: 250px;"
                   data-bs-original-title=""
                   title=""
                   url="<?php echo base_url("Boq/select_group/$contract->id/$payment_no"); ?>">
                    <span style="text-align: center">İş Grupları</span>
                </a>
                <a onclick="renderGroup(this)"
                   class="btn btn-success me-3 auto-refresh-button" href="#" style="width: 250px;"
                   data-bs-original-title=""
                   title="" hidden
                   url="<?php echo base_url("Boq/select_group/$contract->id/$payment_no/$group_id"); ?>">
                    <span style="text-align: center">Yenile</span>
                </a>
            </th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center; font-size: 15px"><strong>Grup Pozları</strong></th>
        </tr>
        <tr>
            <th scope="col">İmalat Adı</th>
            <th scope="col">Önceki Miktar</th>
            <th scope="col">Bu Miktar</th>
            <th scope="col">Tomlam Miktar</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($gorup_items as $boq_ids => $boq_id) { ?>
            <tr>
                <th scope="row"><a onclick="renderCalculate(this)"
                                   href="#"
                                   data-bs-original-title=""
                                   title=""
                                   url="<?php echo base_url("Boq/calculate_render/$contract->id/$payment_no/$boq_id"); ?>">
                        <?php echo boq_name($boq_id); ?>
                    </a>
                </th>
                <td><?php
                    $contract_price = $this->Contract_price_model->get(array("id" => $boq_id));

                    $old_payments = $this->Boq_model->get_all(
                        array(
                            "contract_id" => $contract->id,
                            "payment_no <" => $payment_no,
                            "boq_id" => $boq_id
                        )
                    );
                    $old_total = 0.00;
                    if (isset($old_payments)) {
                        foreach ($old_payments as $item) {
                            $old_total += $item->total;
                        }
                        echo money_format($old_total); ?><?php echo $contract_price->unit;
                    } ?></td>
                <td>  <?php
                    $old_record = $this->Boq_model->get(
                        array(
                            "contract_id" => $contract->id,
                            "payment_no" => $payment_no,
                            "boq_id" => $boq_id
                        )
                    );
                    if (!empty($old_record)) {
                        $this_total = $old_record->total;
                    } else {
                        $this_total = 0;
                    }
                    ?><?php echo money_format($this_total) . " " . $contract_price->unit; ?></td>
                <td><?php
                    echo money_format($this_total + $old_total);
                    ?><?php echo $contract_price->unit; ?></td>
            </tr>

        <?php } ?>
        </tbody>
    </table>
</div>