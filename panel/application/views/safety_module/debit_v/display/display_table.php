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
        <td><strong>Zimmet Dosya No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td><strong>Zimmet Alan Çalışan</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo worker_name($item->worker_id); ?></td>
    </tr>
    <tr>
        <td><strong>Zimmet Belge No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->belge_no; ?></td>
    </tr>
    <tr>
        <td><strong>Zimmet Adı</strong></td>
        <td><strong>:</strong></td>
        <td><b><?php echo $item->zimmet_turu; ?></b></td>
    </tr>
    <tr>
        <td><strong>Zimmet Mazleme</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->zimmet_malzeme; ?></td>
    </tr>
    <tr>
        <td><strong>Zimmet Verilme Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat_dmy($item->zimmet_tarihi); ?></td>
    </tr>
    <tr>
        <td><strong>Zimmet Veren</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo full_name($item->zimmet_veren); ?></td>
    </tr>

</table>


