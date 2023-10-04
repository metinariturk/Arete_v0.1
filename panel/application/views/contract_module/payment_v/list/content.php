<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>Hakediş No</th>
                        <th>Sözleşme Adı</th>
                        <th>Hakediş Tarihi</th>
                        <th>Hakediş Tutarı</th>
                        <th>Ödeme Tutar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td style="width: 5%">
                                <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                    <?php echo str_pad($item->hakedis_no, 2, "0", STR_PAD_LEFT);; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                    <?php echo get_from_id("contract", "sozlesme_ad", $item->contract_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                    <?php echo dateFormat('d-m-Y', $item->imalat_tarihi); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                    <?php echo money_format($item->bu_imalat_ihzarat) . " " . get_currency($item->id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                    <?php echo money_format($item->net_bedel) . " " . get_currency($item->id); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>








