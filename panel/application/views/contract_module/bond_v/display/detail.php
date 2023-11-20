<?php if ($item->teminat_gerekce == "advance") { ?>
    <tr>
        <td><strong>Teminat Gereği</strong></td>
        <td><strong>:</strong></td>
        <td>Avans Ödemesi Gereği</td>
    </tr>
    <tr>
        <td><strong>Avans Tutarı</strong>
        </td>
        <td><strong>:</strong></td>
        <td><?php echo money_format(get_from_id("advance", "avans_miktar", $item->teminat_avans_id)) . " " . get_currency($item->contract_id); ?></td>
    </tr>
    <tr>
        <td><strong>Teminat Oran (min % 100)</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo two_digits_percantage($item->teminat_miktar / get_from_id("advance", "avans_miktar", $item->teminat_avans_id)); ?></td>
    </tr>


<?php } elseif ($item->teminat_gerekce == "costinc") { ?>
    <tr>
        <td><strong>Teminat Gereği</strong></td>
        <td><strong>:</strong></td>
        <td>Keşif Artışı Gereği</td>
    </tr>
    <tr>
        <td><strong>Keşif Artış Tutarı</strong>
        </td>
        <td><strong>:</strong></td>
        <td><?php echo money_format(get_from_id("costinc", "artis_miktar", $item->teminat_kesif_id)) . " " . get_currency($item->contract_id); ?></td>
    </tr>

    <tr>
        <td><strong>Teminat Oran)</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo two_digits_percantage($item->teminat_miktar / get_from_id("costinc", "artis_miktar", $item->teminat_kesif_id)); ?></td>
    </tr>
<?php } elseif ($item->teminat_gerekce == "contract") { ?>
    <tr>
        <td><strong>Teminat Gereği</strong></td>
        <td><strong>:</strong></td>
        <td>Sözleşme Gereği</td>
    </tr>
    <tr>
        <td><strong>Teminat Oran </strong></td>
        <td><strong>:</strong></td>
        <td><?php echo two_digits_percantage($item->teminat_miktar / get_from_id("contract","sozlesme_bedel",$item->contract_id)); ?></td>
    </tr>
<?php } elseif ($item->teminat_gerekce == "price_diff") { ?>
<tr>
    <td><strong>Teminat Gereği</strong></td>
    <td><strong>:</strong></td>
    <td>Fiyat Farkı Gereği</td>
</tr>
<?php } ?>