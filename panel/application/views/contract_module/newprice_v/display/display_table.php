<table class="table">
    <tr>
        <td><strong>Dosya No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Yeni Birim Fiyat Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo $item->ybf_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->ybf_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Yeni Birim Fiyat Miktar</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo money_format($item->ybf_tutar) . " " . get_currency($item->contract_id); ?></td>
    </tr>
    <tr>
        <td><strong>Yeni Birim Fiyat Oran</strong></td>
        <td><strong>:</strong></td>
        <td>% <?php echo $item->ybf_oran; ?></td>
    </tr>
    <tr>
        <td><strong>Gerekçe / Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
    <tr>
        <td>
            <strong>Keşif Artışı
                <?php $kesif_artisi = get_from_any("costinc","id","newprice_id","$item->id"); ?>
            </strong>
        </td>
        <td><strong>:</strong></td>
        <?php if (empty($kesif_artisi)) { ?>
        <td>
            <a  href="<?php echo base_url("costinc/new_form_newprice/$item->id"); ?>">
                <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>
            </a>
        </td>
        <?php } else { ?>
        <td>
            <a  href="<?php echo base_url("costinc/file_form/$kesif_artisi"); ?>">
                <?php echo get_from_any("costinc","dosya_no","id","$kesif_artisi"); ?>
            </a>
        </td>
        <?php } ?>
    </tr>
</table>


