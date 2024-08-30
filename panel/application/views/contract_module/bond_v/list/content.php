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
                        <th>Veriliş Tarihi</th>
                        <th>Geçerlilik Tarihi</th>
                        <th>İade Tarihi</th>
                        <th>Teminat Miktarı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>

                                <tr>
                                    <td>
                                        <a href="<?php echo base_url("bond/file_form/$item->id"); ?>">
                                            <?php echo $item->id; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("bond/file_form/$item->id"); ?>">
                                            <?php echo get_from_id("contract", "contract_name", $item->contract_id); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("bond/file_form/$item->id"); ?>">
                                            <?php echo $item->dosya_no; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("bond/file_form/$item->id"); ?>">
                                            <?php echo dateFormat('d-m-Y', $item->teslim_tarihi); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("bond/file_form/$item->id"); ?>">
                                            <?php if (empty($item->gecerlilik_tarihi)) { ?>
                                                <?php echo "Süresiz Teminat"; ?>
                                            <?php } else { ?>
                                                <?php echo dateFormat('d-m-Y', $item->gecerlilik_tarihi); ?>
                                            <?php } ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("bond/file_form/$item->id"); ?>">
                                            <?php if (empty($item->iade_tarihi)) { ?>
                                                <?php echo "İade Edilmedi"; ?>
                                            <?php } else { ?>
                                                <?php echo dateFormat('d-m-Y', $item->iade_tarihi); ?>
                                            <?php } ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url("bond/file_form/$item->id"); ?>">
                                            <?php echo money_format($item->teminat_miktar) . " " . get_currency($item->contract_id); ?>
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








