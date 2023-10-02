<table class="table">
    <tr>
        <td style="width: 150px"><strong>Proje Kodu/Adı</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo get_from_id("projects","proje_kodu",get_from_id("site", "proje_id",$item->site_id)); ?>
            / <?php echo get_from_id("projects","proje_ad",get_from_id("site", "proje_id",$item->site_id)); ?>
        </td>
    </tr>
    <?php $contract_id = get_from_id("site", "contract_id",$item->site_id); ?>
    <?php if (isset($contract_id)) { ?>
    <tr>
        <td style="width: 150px"><strong>Sözleşme Kodu/Adı</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo contract_code($contract_id)." / ".contract_name($contract_id); ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td style="width: 150px"><strong>İş Yeri Kodu/Adı</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo get_from_id("site","dosya_no",$item->site_id); ?>
            / <?php echo get_from_id("site","santiye_ad",$item->site_id); ?></td>
    </tr>
    <tr>
        <td><strong>Sağlık Raporu Dosya No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td><strong>Sağlık Raporu Alan Çalışan</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo worker_name($item->worker_id); ?></td>
    </tr>
    <tr>
        <td><strong>Sağlık Raporu Belge No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->belge_no; ?></td>
    </tr>
    <tr>
        <td><strong>Sağlık Raporu Adı</strong></td>
        <td><strong>:</strong></td>
        <td><b><?php echo $item->checkup_turu; ?></b></td>
    </tr>
    <tr>
        <td><strong>Sağlık Raporu Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat_dmy($item->checkup_tarihi); ?></td>
    </tr>
    <tr>
        <td><strong>Geçerlilik Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat_dmy($item->gecerlilik_tarihi); ?></td>
    </tr>
    <tr>
        <td><strong>Tespit Yapan</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo full_name($item->rapor_duzenleyen); ?></td>
    </tr>
    <tr>
        <td><strong>Etiketler</strong></td>
        <td><strong>:</strong></td>
        <td>
            <?php
            $etiketler = get_as_array($item->etiketler);
            foreach ($etiketler as $etiket) {
                echo '<code>' . $etiket . '</code>&nbsp;&nbsp;';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><strong>Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
</table>


