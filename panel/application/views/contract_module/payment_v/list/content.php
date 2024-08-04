<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div>
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th class="w5">Hakediş No</th>
                        <th class="w30">Sözleşme Adı</th>
                        <th class="w65">Hakedişler</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($contracts as $contract) { ?>
                        <tr>
                            <td>
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url("payment/file_form/$contract->id"); ?>">
                                    <?php echo contract_name($contract->id); ?>
                                </a>
                            </td>
                            <td>
                                <?php $payments = $this->Payment_model->get_all(array("contract_id" => $contract->id)); ?>
                                <?php if (!empty($payments)) { ?>
                                    <?php $j = 0; ?>
                                    <?php foreach ($payments as $payment) { ?>
                                        <?php if ($j != 0) { ?>
                                            <hr>
                                        <?php }; ?>
                                        <div>
                                            <a href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                                                <?php echo $payment->hakedis_no; ?> Nolu Hakediş
                                                - <?php echo money_format($payment->E) . " " . $contract->para_birimi; ?>
                                            </a>
                                        </div>
                                        <?php $j++; ?>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>








