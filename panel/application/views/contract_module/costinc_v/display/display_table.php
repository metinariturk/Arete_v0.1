<table class="table">
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Keşif Artış Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo $item->artis_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->artis_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Keşif Artış Miktar</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo money_format($item->artis_miktar) . " " . get_currency($item->contract_id); ?></td>
    </tr>
    <tr>
        <td><strong>Keşif Artış Oran</strong></td>
        <td><strong>:</strong></td>
        <td>% <?php echo $item->artis_oran; ?></td>
    </tr>
    <tr>
        <td><strong>Keşif Artışı Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
    <?php if (isset($item->newprice_id)) { ?>
        <tr>
            <td><strong>YBF No</strong></td>
            <td><strong>:</strong></td>
            <td><a href="<?php echo base_url("newprice/file_form/$item->newprice_id"); ?>">
                    <?php echo get_from_any("newprice","dosya_no","id", $item->newprice_id); ?>
                </a>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td><strong>Teminat</strong></td>
        <td><strong>:</strong></td>
        <?php if (empty($teminat = get_from_any_and("bond", "contract_id", "$item->contract_id", "teminat_kesif_id", "$item->id"))) { ?>
            <td>
                <a href="<?php echo base_url("bond/new_form_costinc/$item->id"); ?>">
                    <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                </a>
            </td>
        <?php } else { ?>
            <td>
                <a href="<?php echo base_url("bond/file_form/$teminat"); ?>">
                    <?php echo get_from_any("bond", "dosya_no", "id", "$teminat"); ?>
                </a>
            </td>
        <?php } ?>

    </tr>
    <tr>
        <td><strong>Süre Uzatımı</strong></td>
        <td><strong>:</strong></td>
        <?php if (empty($sure_uzatim = get_from_any_and("extime", "contract_id", "$item->contract_id", "costinc_id", "$item->id"))) { ?>
            <td>
                <a href="<?php echo base_url("extime/new_form_costinc/$item->id"); ?>">
                    <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                </a>
            </td>
        <?php } else { ?>
            <td>
                <a href="<?php echo base_url("extime/file_form/$sure_uzatim"); ?>">
                    <?php echo get_from_any("extime", "dosya_no", "id", "$sure_uzatim"); ?>
                </a>
            </td>
        <?php } ?>

    </tr>

</table>


