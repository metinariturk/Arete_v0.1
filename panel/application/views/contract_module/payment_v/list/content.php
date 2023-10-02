<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sözleşme Adı</th>
                        <th>Dosya No</th>
                        <th>Hakediş Tarihi</th>
                        <th>Hakediş Tutarı</th>
                        <th>Ödeme Tutar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <?php if (!isAdmin()) { ?>
                            <?php $yetkili = contract_auth($item->contract_id);
                            if (in_array(active_user_id(), $yetkili)) { ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                            <?php echo $item->id; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                            <?php echo get_from_id("contract", "sozlesme_ad", $item->contract_id); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("payment/file_form/$item->id"); ?>">
                                            <?php echo $item->dosya_no; ?>
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
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>








