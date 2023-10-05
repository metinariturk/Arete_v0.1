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
                        <th>Karar Tarihi</th>
                        <th>YBF Tutarı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <?php if (!isAdmin()) { ?>
                            <?php $yetkili = contract_auth($item->contract_id);
                            if (in_array(active_user_id(), $yetkili)) { ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url("newprice/file_form/$item->id"); ?>">
                                            <?php echo $item->id; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("newprice/file_form/$item->id"); ?>">
                                            <?php echo get_from_id("contract", "sozlesme_ad", $item->contract_id); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("newprice/file_form/$item->id"); ?>">
                                            <?php echo $item->dosya_no; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("newprice/file_form/$item->id"); ?>">
                                            <?php echo dateFormat('d-m-Y', $item->ybf_tarih); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("newprice/file_form/$item->id"); ?>">
                                            <?php echo money_format($item->ybf_tutar) . " " . get_currency($item->contract_id); ?>
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








