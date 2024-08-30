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
                        <th>Başlangıç/Bitiş Tarihi</th>
                        <th>Ek Süre</th>
                        <th>Gerekçe</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items

                                   as $item) { ?>

                        <tr>
                            <td>
                                <a href="<?php echo base_url("extime/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("extime/file_form/$item->id"); ?>">
                                    <?php echo get_from_id("contract", "contract_name", $item->contract_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("extime/file_form/$item->id"); ?>">
                                    <?php echo $item->dosya_no; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("extime/file_form/$item->id"); ?>">
                                    <?php echo dateFormat('d-m-Y', $item->karar_tarih); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("extime/file_form/$item->id"); ?>">
                                    <?php echo dateFormat('d-m-Y', $item->baslangic_tarih); ?>
                                    / <?php echo dateFormat('d-m-Y', $item->bitis_tarih); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("extime/file_form/$item->id"); ?>">
                                    <?php echo $item->uzatim_miktar; ?> Gün
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("extime/file_form/$item->id"); ?>">
                                    <?php echo $item->uzatim_turu; ?>
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








