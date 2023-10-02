<?php if (isset($teklifler->offer)) { ?>
    <table class="table">
        <thead>
        <tr>
            <a class="pager-btn btn btn-danger btn-outline" onclick="deleteConfirmationFile(this)" data-text="Bu Oturumu"
               data-note="Bu İşlem Geri Alınamaz"
               data-url="<?php echo base_url("offer/delete/$teklifler->id"); ?>">
                <i class="fa fa-trash"></i> Teklif Oturumunu Sil
            </a>
        </tr>
        <tr>
            <?php
            foreach (json_decode($teklifler->offer) as $data_yeterlilik) {

                foreach ($data_yeterlilik as $tur => $deger) {
                    $gelen_dizin = explode(":", $deger);
                    if ($gelen_dizin[0] == "id") { ?>
                        <th>İstekli Adı</th>
                    <?php } elseif ($gelen_dizin[0] > 0) { ?>
                        <th><?php echo $tur; ?></th>
                    <?php } ?>
                <?php }
                break 1;
            } ?>
            <th>En Düşük</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $find_lowest = array();
        $find_higher = array();
        foreach (json_decode($teklifler->offer) as $data_yeterlilik) { ?>
            <?php array_push($find_lowest, min(array_diff($data_yeterlilik, array("", "0")))); ?>
            <?php array_push($find_higher, max(array_diff($data_yeterlilik, array("", "0")))); ?>
            <tr>
                <?php foreach ($data_yeterlilik as $tur => $deger) {

                    $gelen_dizin = explode(":", $deger);
                    if ($gelen_dizin[0] == "id") { ?>
                        <?php $convert_to_contract = $gelen_dizin[1] . "-" . "$item->id" ?>

                        <td>
                            <?php echo company_name($gelen_dizin[1]); ?>

                        </td>
                    <?php } elseif ($gelen_dizin[0] > 0) { ?>
                        <td class="text-center"><?php echo money_format($deger) . " " . get_currency_auc($teklifler->auction_id); ?></td>
                    <?php } ?>
                <?php } ?>
                <td class="text-center">
                    <b>
                        <?php $min = min(array_diff($data_yeterlilik, array("", "0")));
                        echo money_format($min) . " " . get_currency_auc($item->id);
                        $qwe = array_diff($data_yeterlilik, array("", "0"));
                        ?>
                        <a class="pager-btn btn btn-purple btn-outline" data-tooltip="Sözleşmeye Çevir"
                           href="<?php echo base_url("contract/new_form/$item->proje_id/$convert_to_contract-$min"); ?>">
                            <i class="menu-icon fa fa-check-circle fa-lg"></i>
                            Sözleşmeye Çevir
                        </a>
                    </b>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr class="bg-success">
            <td class="text-right" colspan="<?php echo count($qwe) - 1; ?>">
            </td>
            <td class="text-center"><h4>En Düşük Teklif</h4>
            </td>
            <td class="text-center">
                <h4><?php $search_value = min($find_lowest);
                    $find_in_array = json_decode($teklifler->offer);
                    $key = array_search($search_value, array_column($find_in_array, count($qwe) - 1));
                    $en_dusuk_istekli = $find_in_array[$key][0];
                    $a = explode(":", $en_dusuk_istekli);
                    echo company_name($a[1]);
                    ?>
                </h4>
                <h4><?php echo money_format(min($find_lowest)) . " " . get_currency_auc($item->id); ?></h4>
            </td>
        </tr>
        <tr class="bg-purple">
            <td class="text-right" colspan="<?php echo count($qwe) - 1; ?>">
            </td>
            <td class="text-center"><h4>En Yüksek Teklifasd</h4>
            </td>
            <td class="text-center">
                <h4><?php $search_higher = max($find_higher);
                    $find_in_higher = json_decode($teklifler->offer);
                    $key = array_search($search_higher, array_column($find_in_higher, 1));
                    echo $key;
                    $en_yuksek_istekli = $find_in_higher[$key][0];
                    $b = explode(":", $en_yuksek_istekli);
                    echo company_name($b[1]);
                    ?>
                </h4>
                <h4><?php echo money_format(max($find_higher)) . " " . get_currency_auc($item->id); ?></h4>
            </td>
        </tr>
        </tfoot>
    </table>
<?php } else { ?>
    <table class="table">
        <thead>
        <tr>
            <a class="pager-btn btn btn-purple btn-outline" data-tooltip="Ön Yeterlilik Kontrolü"
               href="<?php echo base_url("offer/new_form/auction_display/$item->id"); ?>">
                <i class="menu-icon fa fa-check-circle fa-lg"></i>
                Teklif Formu
            </a>
        </tr>
        </thead>
    </table>
<?php } ?>
