<div class="row content-container">
    <div class="table-responsive">
        <table class="display" id="basic-1">
            <thead>
            <tr>
                <th>#</th>
                <th>Sözleşme Adı</th>
                <th>Sözleşme Bedel</th>
                <th>Hakediş Bedeli</th>
                <th>Fark Bedel</th>
            </thead>
            </tr>
            <tbody>
            <?php $total_main_payment_A = 0; ?>
            <?php $total_main_payment_B = 0; ?>
            <?php foreach ($contracts as $contract) { ?>
                <?php if ($contract->parent == 0 or $contract->parent = null) { ?>
                    <?php $payment_A = $this->Payment_model->sum_all(array("contract_id" => $contract->id), "A"); ?>
                    <?php $payment_B = $this->Payment_model->sum_all(array("contract_id" => $contract->id), "B"); ?>
                    <?php $contract_price = $contract->sozlesme_bedel; ?>
                    <tr>
                        <td>
                            <a href="<?php echo base_url("contract/new_form_sub/$contract->id"); ?>">
                                <i style="color: darkgreen" class="fa fa-plus-circle fa-lg"></i>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                                <?php echo $contract->sozlesme_ad; ?>
                            </a>
                        </td>
                        <td style="text-align: right">+ <?php echo money_format($contract->sozlesme_bedel); ?></td>
                        <td style="text-align: right">+ <?php echo money_format($payment_A); ?></td>
                        <td style="text-align: right">+ <?php echo money_format($payment_B); ?></td>
                    </tr>
                    <?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $contract->id)); ?>
                    <?php $total_sub_payment_A = 0; ?>
                    <?php $total_sub_payment_B = 0; ?>

                    <?php foreach ($sub_contracts as $sub_contract) { ?>
                        <?php $payment_sub_A = $this->Payment_model->sum_all(array("contract_id" => $sub_contract->id), "A"); ?>
                        <?php $payment_sub_B = $this->Payment_model->sum_all(array("contract_id" => $sub_contract->id), "B"); ?>
                        <?php $sub_contract_price = $sub_contract->sozlesme_bedel; ?>
                        <?php $total_sub_payment_A += $payment_sub_A; ?>
                        <?php $total_sub_payment_B += $payment_sub_B; ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                    <i style="color: darkred" class="fa fa-arrow-circle-right fa-lg"></i>
                                </a>
                            </td>
                            <td><a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                    <?php echo $sub_contract->sozlesme_ad; ?>
                                </a></td>
                            <td style="text-align: right">
                                - <?php echo money_format($sub_contract->sozlesme_bedel); ?></td>
                            <td style="text-align: right">- <?php echo money_format($payment_sub_A); ?></td>
                            <td style="text-align: right">- <?php echo money_format($payment_sub_B); ?></td>
                        </tr>
                    <?php } ?>
                    <?php $total_main_payment_A += $payment_A; ?>
                    <?php $total_main_payment_B += $payment_B; ?>
                <?php } ?>

            <?php } ?>
            </tbody>

            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>TOPLAM</td>
                <td style="text-align: right"><?php echo money_format($total_main_payment_A - $total_sub_payment_A); ?></td>
                <td style="text-align: right"><?php echo money_format($total_main_payment_B - $total_sub_payment_B); ?></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

