<div class="row">
    <div class="col-md-6">
        <div class="widget bg-color-op-green">
            <header class="widget-header">
                <h4 class="widget-title pull-left">Geçirilen Kazalar
                    (<?php $accidents = get_from_any_array("accident", "worker_id", "$item->id");
                    if (isset($accidents)) {
                        echo count($accidents);
                    } else {
                        echo "0";
                    } ?>)
                </h4>
                <small class="pull-right text-muted">
                    <a href="<?php echo base_url("accident/new_form/$item->id"); ?>"
                       target=”_blank”>
                        <i class="fa fa-plus-circle fa-xl"></i>
                    </a>
                </small>
            </header><!-- .widget-header -->
            <div class="widget-body clearfix">
                <div class="pull-left">
                    <table class="table" style="width: 100%">
                        <tbody>
                        <tr>
                            <th>id</th>
                            <th style="width: 30%">Kaza Adı</th>
                            <th>Kaza Tarihi</th>
                            <th>Bildirim Yapılması <br>Gereken Tarih</th>
                            <th>Bildiri Durumu</th>
                            <th>Bildiri Tarihi</th>
                            <th style="width: 15%">Etiketler</th>
                            <th>İşlem</th>
                        </tr>
                        <?php $req_accidents = get_as_array($settings->isg_accident); ?>
                        <?php $i = 1;
                        foreach ($req_accidents as $req_accident) { ?>
                            <?php $type = convertToSEO($req_accident); ?>
                            <?php $control = get_from_any_and_array_fe("accident", "worker_id", $item->id, "kaza_turu", "$req_accident"); ?>
                            <?php if (isset($control)) { ?>
                                <?php foreach ($control as $accident_last) { ?>
                                    <?php $acc_id = $accident_last['id']; ?>
                                    <tr>
                                        <td class="text-center"><b><?php echo $i++; ?></b></td>
                                        <td><?php echo $accident_last['kaza_turu']; ?></td>
                                        <td class="text-center"><?php echo dateFormat_dmy($accident_last['kaza_tarihi']); ?></td>
                                        <td class="text-center">
                                            <?php echo $warning = date_plus_days($accident_last['kaza_tarihi'], "3"); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($accident_last['bildiri_durumu'] == 1) { ?>
                                                <p>Bildirim Yapılmış</p>
                                            <?php } elseif ($warning == FALSE) { ?>
                                                <a href="<?php echo base_url("accident/file_form/$acc_id"); ?>"
                                                   target=”_blank”>
                                                    <i class="fa fa-plus-square fa-xl"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center"><?php echo dateFormat_dmy($accident_last['bildiri_tarihi']); ?></td>
                                        <td class="text-center"><?php echo tags($accident_last['etiketler']); ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo base_url("accident/file_form/$acc_id"); ?>"
                                               target=”_blank”>
                                                <i class="fa fa-arrow-right fa-xl"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php $control2 = get_from_any_and_array("accident", "worker_id", $item->id, "safety_id", "$item->safety_id"); ?>
                        <?php $req_accidents = get_as_array($settings->isg_accident); ?>
                        <?php foreach ($control2 as $a) { ?>
                            <?php
                            $array2 = array_column($a, "kaza_turu");
                            $eksik = count(array_column($a, "kaza_turu"));
                            $array1 = $req_accidents;
                            $results = array_diff($array1, $array2);
                            ?>
                            <?php foreach ($results as $result) { ?>
                                <tr>
                                    <td class="text-center">
                                        <b> <?php echo $i++; ?></b>
                                    </td>
                                    <td>
                                        <?php echo $result; ?>
                                        <?php $acc_type = convertToSEO($result); ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><a
                                                href="<?php echo base_url("accident/new_form/$item->id/$acc_type"); ?>"
                                                target=”_blank”>
                                            <i class="fa fa-plus-circle fa-xl"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- .widget-body -->
            <hr class="widget-separator">
        </div><!-- .widget -->
    </div><!-- Durum -->


    <div class="col-md-6">
        <div class="widget bg-color-op-green">
            <header class="widget-header">
                <h4 class="widget-title pull-left">Sağlık Raporları
                    (<?php $accidents = get_from_any_array("checkup", "worker_id", "$item->id");
                    if (isset($checkups)) {
                        echo count($checkups);
                    } else {
                        echo "0";
                    } ?>)
                </h4>
                <small class="pull-right text-muted">
                    <a href="<?php echo base_url("checkup/new_form/$item->id"); ?>"
                       target=”_blank”>
                        <i class="fa fa-plus-circle fa-xl"></i>
                    </a>
                </small>
            </header><!-- .widget-header -->
            <div class="widget-body clearfix">
                <div class="pull-left">
                    <table class="table" style="width: 100%">
                        <tbody>
                        <tr>
                            <th>id</th>
                            <th style="width: 30%">Kaza Adı</th>
                            <th>Kaza Tarihi</th>
                            <th>Bildirim Yapılması <br>Gereken Tarih</th>
                            <th>Bildiri Durumu</th>
                            <th>Bildiri Tarihi</th>
                            <th style="width: 15%">Etiketler</th>
                            <th>İşlem</th>
                        </tr>
                        <?php $req_checkups = get_as_array($settings->isg_checkup); ?>
                        <?php $i = 1;
                        foreach ($req_checkups as $req_checkup) { ?>
                            <?php $type = convertToSEO($req_checkup); ?>
                            <?php $control = get_from_any_and_array("checkup", "worker_id", $item->id, "checkup_turu", "$req_checkup"); ?>
                            <?php if (isset($control)) { ?>
                                <?php foreach ($control as $checkup_match) { ?>
                                    <?php foreach ($checkup_match as $checkup_last) { ?>
                                        <?php $ckp_id = $checkup_last['id']; ?>
                                        <tr>
                                            <td class="text-center"><b><?php echo $i++; ?></b></td>
                                            <td><?php echo $checkup_last['checkup_turu']; ?></td>
                                            <td class="text-center"><?php echo dateFormat_dmy($checkup_last['checkup_tarihi']); ?></td>
                                            <td class="text-center">
                                                <?php echo $warning = date_plus_days($checkup_last['checkup_tarihi'], "3"); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($checkup_last['checkup_durumu'] == 1) { ?>
                                                    <p>Bildirim Yapılmış</p>
                                                <?php } elseif ($warning == FALSE) { ?>
                                                    <a href="<?php echo base_url("checkup/file_form/$ckp_id"); ?>"
                                                       target=”_blank”>
                                                        <i class="fa fa-plus-square fa-xl"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center"><?php echo dateFormat_dmy($checkup_last['gecerlilik_tarihi']); ?></td>
                                            <td class="text-center"><?php echo tags($checkup_last['etiketler']); ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url("checkup/file_form/$ckp_id"); ?>"
                                                   target=”_blank”>
                                                    <i class="fa fa-arrow-right fa-xl"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php $control2 = get_from_any_and_array("checkup", "worker_id", $item->id, "safety_id", "$item->safety_id"); ?>
                        <?php $req_checkups = get_as_array($settings->isg_checkup); ?>
                        <?php foreach ($control2 as $a) { ?>
                            <?php
                            $array2 = array_column($a, "checkup_turu");
                            $eksik = count(array_column($a, "checkup_turu"));
                            $array1 = $req_checkups;
                            $results = array_diff($array1, $array2);
                            ?>
                            <?php foreach ($results as $result) { ?>
                                <tr>
                                    <td class="text-center">
                                        <b> <?php echo $i++; ?></b>
                                    </td>
                                    <td>
                                        <?php echo $result; ?>
                                        <?php $ckp_type = convertToSEO($result); ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><a
                                                href="<?php echo base_url("checkup/new_form/$item->id/$ckp_type"); ?>"
                                                target=”_blank”>
                                            <i class="fa fa-plus-circle fa-xl"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- .widget-body -->
            <hr class="widget-separator">
        </div><!-- .widget -->
    </div><!-- Durum -->
</div>
