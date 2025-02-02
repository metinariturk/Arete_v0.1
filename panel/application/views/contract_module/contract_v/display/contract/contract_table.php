<div class="custom-card-body">
    <table class="table table-sm table-borderless">
        <tbody>
        <tr>
            <td>İmza Tarihi</td>
            <td><?php echo $item->sozlesme_tarih ? dateFormat('d-m-Y', $item->sozlesme_tarih) : 'Belirtilmemiş'; ?></td>
        </tr>
        <tr>
            <td>İşin Süresi</td>
            <td><?php echo $item->isin_suresi; ?> Gün</td>
        </tr>
        <tr>
            <td>Bitiş Tarihi</td>
            <td><?php echo $item->sozlesme_bitis ? dateFormat('d-m-Y', $item->sozlesme_bitis) : 'Belirtilmemiş'; ?></td>
        </tr>
        <tr>
            <td>Yer Teslimi</td>
            <td><?php echo date_control($item->sitedel_date) ? dateFormat('d-m-Y', $item->sitedel_date) : 'Veri Yok'; ?></td>
        </tr>
        <tr>
            <td>İşin Türü</td>
            <td><?php echo $item->isin_turu; ?></td>
        </tr>
        <tr>
            <td>Teklif Türü</td>
            <td><?php echo $item->sozlesme_turu; ?></td>
        </tr>
        <tr>
            <td>Sözleşme Bedeli</td>
            <td><?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></td>
        </tr>
        <tr>
            <td>Toplam Alt Sözleşme Sayısı</td>
            <td><?php echo count($sub_contracts); ?></td>
        </tr>
        </tbody>
    </table>
</div>
