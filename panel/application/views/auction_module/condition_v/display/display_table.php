<div class="row">
    <div class="col-12">
        <h4 class="text-center">Şartname Hükümleri</h4>
    </div>
    <div class="col-sm-12 col-md-6">
        <table class="table">
            <tbody>
            <tr>
                <td><strong>Şartname Türü</strong></td>
                <td>
                    İdari Şartname
                </td>
            </tr>
            <tr>
                <td><b>Teklif Türü</b></td>
                <td><?php echo $item->teklif_turu; ?></td>
            </tr>
            <tr>
                <td><b>İş Bitirme</b></td>
                <td><?php echo money_format($item->is_bitirme) . " " . $item->para_birimi; ?></td>
            </tr>
            <tr>
                <td><b>İşin Türü</b></td>
                <td><?php echo $item->isin_turu; ?></td>
            </tr>
            <tr>
                <td><b>İşin Süresi</b></td>
                <td><?php echo $item->isin_suresi; ?> Gün</td>
            </tr>
            <tr>
                <td><b>Benzer İş Grubu</b></td>
                <td><?php echo $item->benzer_is; ?></td>
            </tr>
            <tr>
                <td><b>Müteahhit Sınıfı</b></td>
                <td><?php echo $item->muteahhit_sinif; ?></td>
            </tr>
            <tr>
                <td><b>KDV Oran</b></td>
                <td>% <?php echo $item->kdv_oran; ?></td>
            </tr>
            <tr>
                <td><b>Tevkifat Oran</b></td>
                <td><?php echo $item->tevkifat_oran; ?></td>
            </tr>
            <tr>
                <td><b>Damga Oran</b></td>
                <td>‰ <?php echo $item->damga_oran; ?></td>
            </tr>
            <tr>
                <td><b>Stopaj Oran</b></td>
                <td>% <?php echo $item->stopaj_oran; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-12 col-md-6">
        <table class="table">
            <tbody>
            <tr>
                <td><b>Avans Durum</b></td>
                <td><?php echo var_yok_name($item->avans_durum); ?></td>
            </tr>
            <tr>
                <td><b>Avans Mahsup Oran</b></td>
                <td>% <?php echo $item->avans_mahsup_oran; ?></td>
            </tr>
            <tr>
                <td><b>İhzarat Durum</b></td>
                <td><?php echo var_yok_name($item->ihzarat); ?></td>
            </tr>
            <tr>
                <td><b>Fiyat Farkı</b></td>
                <td><?php echo var_yok_name($item->fiyat_fark); ?></td>
            </tr>
            <tr>
                <td><b>Kesin Teminat Oran</b></td>
                <td>% <?php echo $item->teminat_oran; ?></td>
            </tr>
            <tr>
                <td><b>Geçici Kabul Kesintisi</b></td>
                <td><?php echo var_yok_name($item->gecici_kabul_kesinti); ?></td>
            </tr>
            <tr>
                <td><strong>Onay</strong></td>
                <td><?php echo full_name($item->onay); ?></td>
            </tr>
            <tr>
                <td><strong>Açıklama</strong></td>
                <td><?php echo $item->aciklama; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>



