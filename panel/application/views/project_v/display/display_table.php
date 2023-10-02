<table class="table">
    <tbody>
    <tr>
        <td class="w30">İşin Durumu</td>
        <td>
            <?php echo project_cond($item->durumu); ?>
        </td>
    </tr>
    <tr>
        <td 15%
        ">Bağlı Olduğu Birim</td>
        <td>
            <?php echo $item->department; ?>
        </td>
    </tr>
    <tr>
        <td 15%
        ">Proje Türü</td>
        <td>
            <?php echo project_type($item->type); ?>
        </td>
    </tr>
    <tr>
        <td>Bütçe Bedeli (Varsa)</td>
        <td>
            <?php echo money_format($item->butce_bedel) . " " . get_from_id("projects", "butce_para_birimi", $item->id); ?>
        </td>
    </tr>
    <tr>
        <td>Proje Etiketleri</td>
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
        <td>Yetkili Personeller</td>
        <td>
            <div class="customers">
                <ul>
                    <?php if (!empty($item->yetkili_personeller)) { ?>
                        <?php
                        $yetkili_personeller = get_as_array($item->yetkili_personeller);
                        foreach ($yetkili_personeller as $personel) { ?>
                            <li class="d-inline-block">
                                <a href="<?php echo base_url("user/file_form/$personel"); ?>"> <img
                                        class="img-50 rounded-circle" <?php echo get_avatar($personel); ?> alt=""
                                        data-original-title="" title="<?php echo full_name($personel);?>">
                                </a>
                            </li>
                        <?php } ?>

                    <?php } ?>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td>Genel Açıklama - Kapsam</td>
        <td>
            <?php echo $item->genel_bilgi; ?>
        </td>
    </tr>
    </tbody>
</table>



