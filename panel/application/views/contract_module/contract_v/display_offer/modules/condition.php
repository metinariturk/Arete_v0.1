<div class="row">
    <div class="col-sm-6">
        <table class="table">
            <thead>
            <tr>
                <th class="w10">id</th>
                <th class="w20">Şartname Türü</th>
                <th class="w30">Açıklama</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($sartnameler)) { ?>
                <?php foreach ($sartnameler as $sartname) { ?>
                    <tr data-toggle="collapse" data-target="#accordion<?php echo $sartname->id; ?>"
                        class="clickable"
                        id="center_row">
                        <td>
                            <a href="<?php echo base_url("condition/file_form/$sartname->id"); ?>" target="_blank">
                                <?php echo $sartname->id; ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("condition/file_form/$sartname->id"); ?>" target="_blank">
                                <?php echo condition_type($sartname->condition_type); ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("condition/file_form/$sartname->id"); ?>" target="_blank">
                                <?php echo $sartname->aciklama; ?>
                            </a>
                        </td>
                    </tr>
                    <tr id="accordion<?php echo $sartname->id; ?>" class="collapse">
                        <td colspan="4">
                            <?php if (!empty($sartname->id)) {
                                $sartname_files = get_module_files("cond_files", "cond_id", "$sartname->id");
                                if (!empty($sartname_files)) {
                                    $j = 1;
                                    foreach ($sartname_files as $sartname_file) { ?>
                                        <div class="container-fluid text-left m-t-sm">
                                            <a class="pager-btn btn btn-purple btn-outline"
                                               href="<?php echo base_url("condition/file_download/$sartname_file->id/file_form"); ?>">
                                                <?php echo $j++; ?>
                                                - <?php echo filenamedisplay($sartname_file->img_url); ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="div-table">
                                        <div class="div-table-row">
                                            <div class="div-table-col">
                                                Dosya Yok, Eklemek İçin Görüntüle Butonundan Şartname Sayfasına
                                                Gidiniz
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <table class="table">
            <thead>
            <tr>
                <th colspan="3">
                </th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($idari_sart)) { ?>
                <?php foreach ($idari_sart as $idari) { ?>
                    <tr>
                        <td class="w25"><b>Teklif Türü</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->teklif_turu; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>İş Bitirme</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->is_bitirme . $idari->para_birimi; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>İşin Türü</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->isin_turu; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>İşin Süresi</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->isin_suresi; ?> Gün</td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Benzer İş Grubu</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->benzer_is; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Müteahhit Sınıfı</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->muteahhit_sinif; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>KDV Oran</b></td>
                        <td class="w5"><b>:</b></td>
                        <td>% <?php echo $idari->kdv_oran; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Tevkifat Oran</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->tevkifat_oran; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Damga Oran</b></td>
                        <td class="w5"><b>:</b></td>
                        <td>‰ <?php echo $idari->damga_oran; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Stopaj Oran</b></td>
                        <td class="w5"><b>:</b></td>
                        <td>% <?php echo $idari->stopaj_oran; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Avans Durum</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo var_yok_name($idari->avans_durum); ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Avans Mahsup Oran</b></td>
                        <td class="w5"><b>:</b></td>
                        <td>% <?php echo $idari->avans_mahsup_oran; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>İhzarat Durum</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo var_yok_name($idari->ihzarat); ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Fiyat Farkı</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo var_yok_name($idari->fiyat_fark); ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Kesin Teminat Oran</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->teminat_oran; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Geçici Kabul Kesintisi</b></td>
                        <td class="w5"><b>:</b></td>
                        <td>% <?php echo $idari->gecici_kabul_kesinti; ?></td>
                    </tr>
                    <tr>
                        <td class="w25"><b>Açıklama</b></td>
                        <td class="w5"><b>:</b></td>
                        <td><?php echo $idari->aciklama; ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

