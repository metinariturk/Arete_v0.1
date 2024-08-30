<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sözleşme Adı</th>
                        <th>Tahsilat Türü</th>
                        <th>Tahsilat Tarihi</th>
                        <th>Tahsilat Miktarı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>

                        <tr>
                            <td>
                                <a href="<?php echo base_url("collection/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("collection/file_form/$item->id"); ?>">
                                    <?php echo get_from_id("contract", "contract_name", $item->contract_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("collection/file_form/$item->id"); ?>">
                                    <?php echo $item->tahsilat_turu; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("collection/file_form/$item->id"); ?>">
                                    <?php echo dateFormat('d-m-Y', $item->tahsilat_tarih); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("collection/file_form/$item->id"); ?>">
                                    <?php echo money_format($item->tahsilat_miktar) . " " . get_currency($item->id); ?>
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








