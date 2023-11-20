<table class="table">
    <tr>
        <td><strong>Dosya No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Tahsilat Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->avans_tarih); ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Sözleşme Tutar</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo money_format(get_from_id("contract","sozlesme_bedel",get_from_id("collection", "contract_id",$item->id)))." ".get_currency(get_from_id("collection", "contract_id",$item->id)); ?></td>
    </tr>
    <tr>
        <td><strong>Tahsilat Miktar</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo money_format($item->avans_miktar) . " " . get_currency($item->contract_id); ?></td>
    </tr>
    <tr>
        <td><strong>Tahsilat Oran</strong></td>
        <td><strong>:</strong></td>
        <td>% <?php echo money_format($item->avans_miktar / contract_price($item->contract_id) * 100); ?></td>
    </tr>
    <tr>
        <td><strong>Tahsilat Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
    <tr>
        <td><strong>Tahsilat Teminatı</strong></td>
        <td><strong>:</strong></td>
        <?php if (empty($teminat = get_from_any_and("bond","contract_id","$item->contract_id","teminat_avans_id","$item->id"))) { ?>
            <td>
                <a  href="<?php echo base_url("bond/new_form_collection/$item->id"); ?>">
                    <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                </a>
            </td>
        <?php } else { ?>
            <td>
                <a  href="<?php echo base_url("bond/file_form/$teminat"); ?>">
                    <?php echo get_from_any("bond","dosya_no","id","$teminat"); ?>
                </a>
            </td>
        <?php } ?>
    </tr>
</table>


