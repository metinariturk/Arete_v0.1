<div class="row">
    <div class="col-sm-8">
        <a class="pager-btn btn btn-purple btn-outline" href="<?php echo base_url("fuel/new_form/$item->id"); ?>">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Yeni Yakıt İkmali
        </a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th colspan="9"><h4>Yakıt Tüketimi İşlemleri</h4></th>
            </tr>
            <tr>
                <th colspan="9"><h4>Yakıt Tüketimi Kriteri - Litre / <?php echo km_saat($item->yakit_takip); ?></h4>
                </th>
            </tr>
            </thead>
            <thead>
            <th class="w5">#id</th>
            <th class="w15">İkmal Tarihi</th>
            <th class="w15">Yakıt Türü</th>
            <th class="w15"> <?php echo km_saat($item->yakit_takip); ?></th>
            <th class="w15">Miktar (Litre)</th>
            <th class="w10">Birim Fiyat</th>
            <th class="w10">Toplam</th>
            <th class="w10">Ortalama</th>
            <th class="w25c">İşlem</th>
            </thead>

            <tbody>
            <?php if ($fuels == null) { ?>
                <tr>
                    <td colspan="9">
                        <div class="alert alert-danger" role="alert">
                            Servis/Bakım/Muayene Kaydı Yok
                        </div>
                    </td>
                </tr>

            <?php } else { ?>
                <?php foreach ($fuels as $fuel) { ?>
                    <tr data-toggle="collapse" data-target="#accordion<?php echo $fuel->id; ?>" class="clickable"
                        id="center_row">
                        <td><?php echo $fuel->id; ?></td>
                        <td><?php echo dateFormat_dmy($fuel->ikmal_tarih); ?></td>
                        <td><?php echo fuel($fuel->fuel_type); ?></td>
                        <td><?php echo $fuel->ikmal_km_saat; ?></td>
                        <td><?php echo $fuel->ikmal_miktar ?> TL</td>
                        <td><?php echo money_format($fuel->ikmal_bf); ?> TL</td>
                        <td><?php echo money_format($fuel->ikmal_tutar); ?> TL</td>
                        <td><?php if ($item->yakit_takip == 2) {
                                echo ($fuel->ortalama*100)." (Lt/100KM)";
                            } elseif ($item->yakit_takip == 1) {
                                echo ($fuel->ortalama)."saat";
                            }?></td>

                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Bu Poliçe"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("fuel/file_form/$fuel->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9">
                            <div id="accordion<?php echo $fuel->id; ?>" class="collapse">
                                <?php if (!empty($fuel->id)) {
                                    $fuel_files = get_module_files("fuel_files", "fuel_id", "$fuel->id");
                                    if (!empty($fuel_files)) {
                                        foreach ($fuel_files as $fuel_file) { ?>
                                            <div class="div-table">
                                                <div class="div-table-row">
                                                    <div class="div-table-col">
                                                        <?php echo $fuel_file->id; ?>
                                                        <a href="<?php echo base_url("fuel/file_download/$fuel_file->id/file_form"); ?>">
                                                            <?php echo filenamedisplay($fuel_file->img_url); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="div-table">
                                            <div class="div-table-row">
                                                <div class="div-table-col">
                                                    Dosya Yok, Eklemek İçin Görüntüle Butonundan Yakıt Formu Sayfasına
                                                    Gidiniz
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="w10c"><b>Toplam Yakıt Ödemeleri</b></td>
                <td colspan="3" class="w25c">
                    <b><?php echo money_format(sum_anything("fuel", "ikmal_tutar", "vehicle_id", $item->id)); ?> TL</b>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/fuel_graph"); ?>
    </div>
</div>

