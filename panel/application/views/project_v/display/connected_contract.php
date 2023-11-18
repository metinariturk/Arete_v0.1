<div class="row content-container">
    <table class="table table-bordered table-striped table-hover pictures_list">
        <thead>
        <th style="text-align: center">#</th>
        <th>Sözleşme Adı</th>
        <th style="text-align: center">Sözleşme Bedel</th>
        <th style="text-align: center">İş Bedeli</th>
        <th style="text-align: center">Fark Bedel</th>
        <th class="w20c">Gerçekleşme Oran</th>
        <th class="w20c">Alt Sözleşme Ekle</th>
        </thead>
        <tbody>
        <?php $total_main_payment_A = 0; ?>
        <?php $total_main_payment_B = 0; ?>
        <?php foreach ($contracts as $contract) { ?>
            <?php if ($contract->parent == 0 or $contract->parent = null) { ?>

                <?php $payment_A = $this->Payment_model->sum_all(array("contract_id" => $contract->id), "A"); ?>
                <?php $payment_B = $this->Payment_model->sum_all(array("contract_id" => $contract->id), "B"); ?>
                <?php $contract_price = $contract->sozlesme_bedel; ?>
                <tr>
                    <td style="text-align: center">
                        <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                            <i style="color: green" class="fa fa-arrow-circle-up fa-lg"></i>
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
                    <td style="text-align: right">%
                        <?php if ($contract_price != 0 or $contract_price != null) { ?>
                            <?php echo floatval($payment_A / $contract->sozlesme_bedel * 100); ?>
                        <?php } ?>
                    </td>
                    <td style="text-align: center">
                        <a href="<?php echo base_url("contract/new_form_sub/$contract->id"); ?>">
                            <i style="color: darkgreen" class="fa fa-plus-circle fa-lg"></i>
                        </a>
                    </td>
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
                        <td style="text-align: center">
                            <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                <i style="color: darkred" class="fa fa-arrow-circle-right fa-lg"></i>
                            </a>
                        </td>
                        <td><a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                <?php echo $sub_contract->sozlesme_ad; ?>
                            </a></td>
                        <td style="text-align: right">- <?php echo money_format($sub_contract->sozlesme_bedel); ?></td>
                        <td style="text-align: right">- <?php echo money_format($payment_sub_A); ?></td>
                        <td style="text-align: right">- <?php echo money_format($payment_sub_B); ?></td>
                        <td style="text-align: right">%
                            <?php if ($contract_price != 0 or $contract_price != null) { ?>
                                <?php echo $payment_sub_A / $sub_contract->sozlesme_bedel * 100; ?>
                            <?php } ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                <?php } ?>
                <?php $total_main_payment_A += $payment_A; ?>
                <?php $total_main_payment_B += $payment_B; ?>
            <?php } ?>

        <?php } ?>
        <tr>
            <td style="text-align: center">
                <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">

                </a>
            </td>
            <td>
               Toplam
            </td>
            <td style="text-align: right"></td>
            <td style="text-align: right"><?php echo $total_main_payment_A-$total_sub_payment_A; ?></td>
            <td style="text-align: right"><?php echo $total_main_payment_B-$total_sub_payment_B; ?></td>
            <td style="text-align: right"></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

