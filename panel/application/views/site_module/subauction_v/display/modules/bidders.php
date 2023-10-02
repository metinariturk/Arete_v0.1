<?php if ($yeterlilik_kontrol > 0) {
    $sort_by_teminat = json_decode($yeterlilik->qualify, true);
    usort($sort_by_teminat, "cmp");
}
?>

<?php if ($istekli_kontrol == null or $istekli_kontrol == 0) { ?>
    <a class="pager-btn btn btn-purple btn-outline"
       href="<?php echo base_url("bidder/new_form/auction_display/$item->id"); ?>">
        <i class="menu-icon fa fa-plus-circle fa-lg"></i>
        İstekli
    </a>
<?php } ?>

<div class="col-sm-12">
<?php if ($istekli_kontrol != 0 or $istekli_kontrol != null) { ?>
    <div class="text-center">
        <table class="table">
            <tbody>
            <?php if ($yeterlilik_kontrol == 0 or $yeterlilik_kontrol == null) { ?>
                <a class="pager-btn btn btn-purple btn-outline" data-tooltip="Ön Yeterlilik Kontrolü"
                   href="<?php echo base_url("qualify/new_form/auction_display/$item->id"); ?>">
                    <i class="menu-icon fa fa-check-circle fa-lg"></i>
                    Ön Yeterlilik
                </a>
                <a class="pager-btn btn btn-purple btn-outline" data-tooltip="İsteklileri Düzenle"
                   href="<?php echo base_url("bidder/update_form/$istekli_form"); ?>">
                    <i class="menu-icon fa fa-edit fa-lg"></i>
                    İsteklileri Düzenle
                </a>
                <?php $list = get_as_array($istekliler);
                $i = 1;
                foreach ($list as $istekli) { ?>
                    <tr>
                        <th scope="row"><?php echo $i++; ?> </th>
                        <td><?php echo get_from_any("companys", "company_name", "id", $istekli); ?>
                        <td>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="col-sm-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <?php if ($yeterlilik_kontrol>0) { ?>
                <table>
                    <tbody>
                    <a class="pager-btn btn btn-purple btn-outline" data-tooltip="İsteklileri Düzenle"
                       href="<?php echo base_url("bidder/update_form/$istekli_form"); ?>">
                        <i class="menu-icon fa fa-edit fa-lg"></i>
                        İsteklileri Düzenle
                    </a>
                    <a class="pager-btn btn btn-danger btn-outline" onclick="deleteConfirmationFile(this)" data-text="Bu Projeyi"
                       data-note="Bağlı İhaleler ve Tüm Alt Dosyaları Silinecek, Bu İşlem Geri Alınamaz"
                       data-url="<?php echo base_url("qualify/delete/$yeterlilik->id"); ?>">
                        <i class="fa fa-trash"></i> Yeterlilik Formunu Sil
                    </a>
                    <?php
                    foreach ($sort_by_teminat as $data_yeterlilik) {
                        foreach ($data_yeterlilik as $tur => $deger) {
                            if ($tur == "id") { ?>
                                <th style="width: 20%;   vertical-align: bottom;">İstekli Adı</th>
                            <?php } elseif ($tur == "Teminat Mektubu") { ?>
                                <th style="width: 15%;   vertical-align: bottom;"><?php echo $tur; ?></th>
                            <?php } else { ?>
                                <th style="width: 5%" class="traditional-vertical-writing"><?php echo $tur; ?></th>
                            <?php }
                        }
                        break 1;
                    } ?>
                    <tr>
                        <td colspan="<?php echo count($data_yeterlilik); ?>">
                            <hr>
                        </td>
                    </tr>
                    <?php
                    foreach ($sort_by_teminat as $data_yeterlilik) { ?>
                        <tr>
                            <?php foreach ($data_yeterlilik as $tur => $deger) {
                                if ($tur == "id") { ?>
                                    <td style="width: 20%;"> <?php echo company_name($deger); ?></td>
                                <?php } elseif ($tur == "Teminat Mektubu") { ?>
                                    <td style="width: 15%;"><?php echo money_format($deger) . " " . get_from_any("auction", "para_birimi", "id", "$item->id"); ?></td>
                                <?php } else { ?>
                                    <td style="width: 5%;"
                                        ><?php echo qualify($deger); ?></td>
                                <?php }
                            }
                            ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
            </thead>
        </table>
    </div>
</div>



