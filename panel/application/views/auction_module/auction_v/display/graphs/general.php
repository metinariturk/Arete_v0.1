<?php
$bugun = date("Y-m-d");
?>
<div class="row">
    <div class="card-body">
        <div class="col-12 text-center">
            <h3>Genel Bilgiler</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <table>
            <tbody>
            <tr>
                <td><b>İşveren</b></td>
                <td><?php echo company_name($item->isveren); ?></td>
            </tr>
            <tr>
                <td><b>Planlanan Teklif Yayın Tarihi</td>
                <td><?php echo $item->talep_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->talep_tarih); ?></td>
            </tr>
            <?php if (isset($ilanlar)){ ?>
            <?php foreach ($ilanlar as $ilan) { ?>
                <tr>
                    <td>
                        <b><?php echo cms_isset($ilan->original_notice, "Zeyilname", "Teklif"); ?> Yayın Tarihi</b>
                    </td>
                    <td>
                        <?php echo dateFormat_dmy($ilan->ilan_tarih); ?> - <?php echo dateFormat_dmy($ilan->son_tarih); ?>
                    </td>
                </tr>
            <?php } ?>
            <?php } ?>
            <tr>
                <td><b>Bütçe</b></td>
                <td><?php echo money_format($item->butce) . " " . $item->para_birimi; ?></td>
            </tr>
            <tr>
                <td><b>Aşırı Düşük</b></td>
                <td><?php echo money_format($item->min_cost) . " " . $item->para_birimi; ?></td>
            </tr>
            <tr>
                <td><b>Aşırı Yüksek</b></td>
                <td><?php echo money_format($item->max_cost) . " " . $item->para_birimi; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-6">
        <table>
            <tbody>
            <tr>
                <td><b>Görevliler</b></td>
                <td>
                    <ul>
                        <?php $yetkililer = get_as_array($item->yetkili_personeller); ?>
                        <?php foreach ($yetkililer as $yetkili) { ?>
                            <li class="d-inline-block">
                            <span data-tooltip-location="top" data-tooltip="<?php echo full_name($yetkili); ?>">
                                <img class="img-30 rounded-circle"  <?php echo get_avatar($yetkili); ?> data-tooltip="asd"
                                     alt="" data-original-title="" title="">
                        </span><?php echo full_name($yetkili); ?>
                                (<?php echo get_from_any("users", "profession", "id", "$yetkili"); ?>)
                            </li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td><b>Kapsam</b></td>
                <td><?php echo $item->aciklama; ?></td>
            </tr>
            <?php if (!empty($tesvikler)) { ?>
                <tr>
                    <td colspan="2"><b>Teşvik/Hibe</b></td>
                </tr>

                <?php foreach ($tesvikler as $tesvik) { ?>
                    <tr>
                        <td><b><?php echo $tesvik->tesvik_grup; ?></b></td>
                        <td>Bu ihalede <?php echo $tesvik->tesvik_kurum; ?> tarafından
                            <?php echo $tesvik->kapsam; ?> kapsamında <?php echo $tesvik->tesvik_grup; ?>
                            <i><small>(*)</small></i>
                            uygulanmıştır.
                            <br>
                            <i><small>* <?php echo $tesvik->aciklama; ?></small></i>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>



