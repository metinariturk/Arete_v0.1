<table class="table">
    <tbody>
        <tr>
            <td colspan="3" class="text-center"><h3>
                    <strong><?php echo $item->hakedis_no; ?> <?php cms_if_echo($item->final, "1", " NO'LU ve KESİN", "NO'LU"); ?>
                        HAKEDİŞ</strong>
                </h3>
            </td>
        </tr>
    <tr>
        <td class="w5c">#</td>
        <td class="w50"><strong>Dosya No</strong></td>
        <td class="w30"><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td class="w5c">#</td>
        <td><strong>Son İmalat Tarihi</strong></td>
        <td><?php echo dateFormat_dmy($item->imalat_tarihi); ?></td>
    </tr>
    <tr>
        <td class="text-center" colspan="3"><strong>HAKEDİŞ BEDELİ</strong></td>
    </tr>
        <?php if (!empty($item->toplam_ihzarat)) { ?>
    <tr>
        <td class="w5c"><strong>A1</strong></td>
        <td><strong>Bu Hakediş İmalat Tutarı</strong></td>
        <td><?php echo money_format($item->bu_imalat) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>A2</strong></td>
        <td><strong>Bu Hakediş İhzarat Tutarı</strong></td>
        <td><?php echo money_format($item->bu_ihzarat) . " " . get_currency($contract->id); ?></td>
    </tr>
        <?php } ?>
    <tr>
        <td class="w5c"><strong>A3</strong></td>
        <td><strong>Önceki İmalat Toplam</strong></td>
        <td><?php echo money_format($item->toplam_imalat-$item->bu_imalat) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>A4</strong></td>
        <td><strong>Önceki İhzarat Toplam</strong></td>
        <td><?php echo money_format($item->toplam_ihzarat-$item->bu_ihzarat) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>A</strong></td>
        <td><strong>Toplam İmalat + İhzarat Bedeli</strong></td>
        <td><strong><?php echo money_format($item->toplam_imalat_ihzarat) . " " . get_currency($contract->id); ?></strong></td>
    </tr>
    <tr>
        <td class="w5c"><strong>B1</strong></td>
        <td><strong>Önceki Hakedişler Fiyat Farkı Tutarı</strong></td>
        <td><?php echo money_format($item->toplam_fiyat_fark - $item->bu_fiyat_fark) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>B2</strong></td>
        <td><strong>Bu Hakediş Fiyat Farkı Tutarı</strong></td>
        <td><?php echo money_format($item->bu_fiyat_fark) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>B</strong></td>
        <td><strong>Toplam Fiyat Farkı</strong></td>
        <td><strong><?php echo money_format($item->toplam_fiyat_fark) . " " . get_currency($contract->id); ?></strong></td>
    </tr>
    <tr>
        <td class="w5c"><strong>C</strong></td>
        <td><strong>Toplam Tutar ( A + B )</strong></td>
        <td><strong><?php echo money_format($item->bu_iif+$item->onceki_iif) . " " . get_currency($contract->id); ?></strong></td>
    </tr>
    <tr>
        <td class="w5c"><strong>D</strong></td>
        <td><strong>Önceki Hakedişler Toplamı ( B1 + A3 + A4 )</strong></td>
        <td><?php echo money_format($item->onceki_iif) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>E</strong></td>
        <td><strong>Bu Hakedişin Tutarı ( C - D )</strong></td>
        <td><b><?php echo money_format($item->bu_iif) . " " . get_currency($contract->id); ?></b></td>
    </tr>
    <tr>
        <td class="w5c"><strong>F</strong></td>
        <td><strong>KDV ( E x % <?php echo $item->kdv_oran; ?> )</strong></td>
        <td><?php echo money_format($item->kdv_tutar) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>G</strong></td>
        <td><strong>Taahhuk Tutarı ( E + F )</strong></td>
        <td><b><?php echo money_format($item->taahhuk) . " " . get_currency($contract->id); ?></b></td>
    </tr>
    <tr>
        <td class="text-center" colspan="3"><strong>KESİNTİ VE MAHSUPLAR</strong></td>
    </tr>
    <tr>
        <td class="w5c"><strong>a</strong></td>
        <td><strong>Gelir Kurumlar Vergisi ( % <?php echo $item->stopaj_oran; ?> )</strong></td>
        <td><?php echo money_format($item->stopaj_tutar) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>b</strong></td>
        <td><strong>Damga Vergisi ( E X ‰ <?php echo $item->damga_oran; ?> )</strong></td>
        <td><?php echo money_format($item->damga_tutar) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>c</strong></td>
        <td><strong>KDV Tevkifatı ( F X <?php echo fractional($item->tevkifat_oran); ?>)</strong></td>
        <td><?php echo money_format($item->tevkifat_tutar) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>d</strong></td>
        <td><strong>SGK Kesintisi</strong></td>
        <td><?php echo money_format($item->sgk) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>e</strong></td>
        <td><strong>İş Makinesi Kesintisi</strong></td>
        <td><?php echo money_format($item->makine) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>f</strong></td>
        <td><strong>Gecikme Cezası</strong></td>
        <td><?php echo money_format($item->gecikme) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>g</strong></td>
        <td><strong>Avans Mahsubu ( % <?php echo $item->avans_mahsup_oran; ?> )</strong></td>
        <td><?php echo money_format($item->avans_mahsup_miktar) . " " . get_currency($contract->id); ?></td>
    </tr>
        <tr>
            <td class="w5c"><strong>k</strong></td>
            <td><strong>Nakit Geçici Kabul Kesintisi ( %<?php echo $contract->teminat_oran; ?> )</strong></td>
            <td><?php echo money_format($item->gecici_kabul_kesinti) . " " . get_currency($contract->id); ?></td>
        </tr>
    <tr>
        <td class="w5c"><strong>h</strong></td>
        <td><strong>Diğer Kesinti (1)</strong></td>
        <td><?php echo money_format($item->diger_1) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>i</strong></td>
        <td><strong>Diğer Kesinti (2)</strong></td>
        <td><?php echo money_format($item->diger_2) . " " . get_currency($contract->id); ?></td>
    </tr>
    <tr>
        <td class="w5c"><strong>j</strong></td>
        <td><strong>Bu Hakedişte Ödenen Fiyat Farkı Teminat Kesintisi <br>( B2 x % <?php echo $contract->teminat_oran; ?> )</strong></td>
        <td><?php echo money_format($item->fiyat_fark_teminat) . " " . get_currency($contract->id); ?></td>
    </tr>

    <tr>
        <td class="w5c"><strong>#</strong></td>
        <td><strong>KESİNTİ VE MAHSUPLAR TOPLAMI</strong></td>
        <td><b><?php echo money_format($item->kesinti_toplam) . " " . get_currency($contract->id); ?></b></td>
    </tr>
    <tr>
        <td class="text-center" colspan="3"><strong>TOPLAM</strong></td>
    </tr>
    <tr>
        <td class="w5c"><strong>#</strong></td>
        <td><strong>ÖDENECEK NET TUTAR</strong></td>
        <td><b><?php echo money_format($item->net_bedel) . " " . get_currency($contract->id); ?></b></td>
    </tr>
    </tbody>
</table>


