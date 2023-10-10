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
                        <th>Artış Miktarı</th>
                        <th>Artış Oranı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>

                        <tr>
                            <td>
                                <a href="<?php echo base_url("costinc/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("costinc/file_form/$item->id"); ?>">
                                    <?php echo get_from_id("contract", "sozlesme_ad", $item->contract_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("costinc/file_form/$item->id"); ?>">
                                    <?php echo $item->dosya_no; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("costinc/file_form/$item->id"); ?>">
                                    <?php echo dateFormat('d-m-Y', $item->artis_tarih); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("costinc/file_form/$item->id"); ?>">
                                    <?php echo money_format($item->artis_miktar) . " " . get_currency($item->id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("costinc/file_form/$item->id"); ?>">
                                    % <?php echo $item->artis_oran; ?>
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








