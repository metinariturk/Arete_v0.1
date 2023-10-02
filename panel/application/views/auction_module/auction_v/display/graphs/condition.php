<?php if (!empty($idari)) { ?>
    <div class="col-12 box-col-10">
        <div class="card-header text-center">
            <h4>Şartname Hükümleri</h4>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="w40"><b>Teklif Türü</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->teklif_turu; ?></td>
                        </tr>

                        <tr>
                            <td class="w40"><b>İş Bitirme</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo money_format($idari->is_bitirme) . $idari->para_birimi; ?></td>
                        </tr>
                        <tr>
                            <td class="w40"><b>Benzer İş Grubu</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->benzer_is; ?></td>
                        </tr>
                        <tr>
                            <td class="w40"><b>KDV Oran</b></td>
                            <td class="w5"><b>:</b></td>
                            <td>% <?php echo $idari->kdv_oran; ?></td>
                        </tr>

                        <tr>
                            <td class="w40"><b>Damga Oran</b></td>
                            <td class="w5"><b>:</b></td>
                            <td>‰ <?php echo $idari->damga_oran; ?></td>
                        </tr>

                        <tr>
                            <td class="w40"><b>Avans Durum</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo var_yok_name($idari->avans_durum); ?></td>
                        </tr>
                        <tr>
                            <td class="w40"><b>İhzarat Durum</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo var_yok_name($idari->ihzarat); ?></td>
                        </tr>
                        <tr>
                            <td class="w40"><b>Fiyat Farkı</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo var_yok_name($idari->fiyat_fark); ?></td>
                        </tr>
                        <tr>
                            <td class="w40"><b>Kesin Teminat Oran</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->teminat_oran; ?></td>
                        </tr>
                        <tr>
                            <td class="w40"><b>Geçici Kabul Kesintisi</b></td>
                            <td class="w5"><b>:</b></td>
                            <td>% <?php echo $idari->gecici_kabul_kesinti; ?></td>
                        </tr>
                        <tr>
                            <td class="w40"><b>Açıklama</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->aciklama; ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="w50"><b>İşin Türü</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->isin_turu; ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>İşin Süresi</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->isin_suresi; ?> Gün</td>
                        </tr>

                        <tr>
                            <td class="w50"><b>Müteahhit Sınıfı</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->muteahhit_sinif; ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>Tevkifat Oran</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->tevkifat_oran; ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>Stopaj Oran</b></td>
                            <td class="w5"><b>:</b></td>
                            <td>% <?php echo $idari->stopaj_oran; ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>Avans Mahsup Oran</b></td>
                            <td class="w5"><b>:</b></td>
                            <td>% <?php echo $idari->avans_mahsup_oran; ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>İhzarat Durum</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo var_yok_name($idari->ihzarat); ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>Fiyat Farkı</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo var_yok_name($idari->fiyat_fark); ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>Kesin Teminat Oran</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->teminat_oran; ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>Geçici Kabul Kesintisi</b></td>
                            <td class="w5"><b>:</b></td>
                            <td>% <?php echo $idari->gecici_kabul_kesinti; ?></td>
                        </tr>
                        <tr>
                            <td class="w50"><b>Açıklama</b></td>
                            <td class="w5"><b>:</b></td>
                            <td><?php echo $idari->aciklama; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



