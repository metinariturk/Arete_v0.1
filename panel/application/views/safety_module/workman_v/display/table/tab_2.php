<div class="row">
    <div class="col-md-6">
        <div class="widget bg-color-op-green">
            <header class="widget-header">
                <h4 class="widget-title pull-left">Alınan Eğitimler
                (<?php $educations = get_from_any_array("education","worker_id","$item->id");
                    if (isset($educations)){
                        echo count($educations);
                    } else {
                        echo "0";
                    }?>

                )
                </h4>
                <small class="pull-right text-muted">
                    <a href="<?php echo base_url("education/new_form/$item->id"); ?>"
                       target=”_blank”>
                        <i class="fa fa-plus-circle fa-xl"></i>
                    </a>
                </small>
            </header><!-- .widget-header -->
            <div class="widget-body clearfix">
                <div class="pull-left">
                    <table class="table" style="width: 100%">
                        <tbody>
                        <tr >
                            <th>id</th>
                            <th style="width: 35%">Eğitim Adı</th>
                            <th>Eğitim Tarihi</th>
                            <th>Geçerlilik Tarihi</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                        <?php $req_educations = get_as_array($settings->isg_education); ?>
                        <?php $i = 1;
                        foreach ($req_educations as $req_education) { ?>
                            <?php $type = convertToSEO($req_education); ?>
                            <?php $control = get_from_any_and_array_fe("education", "worker_id", $item->id, "egitim_turu", "$req_education"); ?>
                            <?php if (isset($control)) { ?>
                                <?php foreach ($control as $education_last) { ?>
                                        <?php $edu_id = $education_last['id']; ?>
                                        <tr>
                                            <td class="text-center"><b><?php echo $i++; ?></b></td>
                                            <td><?php echo $education_last['egitim_turu']; ?></td>
                                            <td class="text-center"><?php echo dateFormat_dmy($education_last['egitim_tarihi']); ?></td>
                                            <td class="text-center"><?php echo dateFormat_dmy($education_last['gecerlilik_tarihi']); ?></td>
                                            <td class="text-center"><?php $warning = time_warning(date("Y-m-d"), $education_last['gecerlilik_tarihi'], 7); ?>
                                                <?php if ($warning == TRUE) { ?>
                                                    AKTİF
                                                <?php } elseif ($warning == FALSE) { ?>
                                                    SÜRESİ DOLDU
                                                <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url("education/file_form/$edu_id"); ?>"
                                                   target=”_blank”>
                                                    <i class="fa fa-arrow-right fa-xl"></i>
                                                </a>
                                            </td>
                                        </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php $control2 = get_from_any_and_array("education", "worker_id", $item->id, "safety_id", "$item->safety_id"); ?>
                        <?php $req_educations = get_as_array($settings->isg_education); ?>
                        <?php foreach ($control2 as $a) { ?>
                            <?php
                            $array2 = array_column($a, "egitim_turu");
                            $eksik = count(array_column($a, "egitim_turu"));
                            $array1 = $req_educations;
                            $results = array_diff($array1, $array2);
                            ?>
                            <?php foreach ($results as $result) { ?>
                                <tr>
                                    <td class="text-center">
                                        <b> <?php echo $i++; ?></b>
                                    </td>
                                    <td>
                                        <?php echo $result; ?>
                                        <?php $edu_type = convertToSEO($result); ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><a href="<?php echo base_url("education/new_form/$item->id/$edu_type"); ?>"
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
        <div class="widget bg-color-op-yellow">
            <header class="widget-header">
                <h4 class="widget-title pull-left">Zimmetler
                    (<?php $debits = get_from_any_array("debit","worker_id","$item->id");
                    if (isset($debits)){
                        echo count($debits);
                    } else {
                        echo "0";
                    }?>

                    )
                </h4>
                <small class="pull-right text-muted">
                    <a href="<?php echo base_url("debit/new_form/$item->id"); ?>"
                       target=”_blank”>
                        <i class="fa fa-plus-circle fa-xl"></i>
                    </a>
                </small>
            </header><!-- .widget-header -->
            <div class="widget-body clearfix">
                <div class="pull-left">
                    <table class="table" style="width: 100%">
                        <tbody>
                        <tr >
                            <th>id</th>
                            <th style="width: 35%">Zimmet Adı</th>
                            <th>Zimmet Tarihi</th>
                            <th>Zimmetlenen</th>
                            <th>İşlem</th>
                        </tr>
                        <?php $req_debits = get_as_array($settings->isg_debit); ?>
                        <?php $i = 1;
                        foreach ($req_debits as $req_debit) { ?>
                            <?php $type = convertToSEO($req_debit); ?>
                            <?php $control = get_from_any_and_array("debit", "worker_id", $item->id, "zimmet_turu", "$req_debit"); ?>
                            <?php if (isset($control)) { ?>
                                <?php foreach ($control as $debit_match) { ?>
                                    <?php foreach ($debit_match as $debit_last) { ?>
                                        <?php $debit_id = $debit_last['id']; ?>
                                        <tr>
                                            <td class="text-center"><b><?php echo $i++; ?></b></td>
                                            <td><?php echo $debit_last['zimmet_turu']; ?></td>
                                            <td class="text-center"><?php echo dateFormat_dmy($debit_last['zimmet_tarihi']); ?></td>
                                            <td><?php echo tags($debit_last['zimmet_malzeme']); ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url("debit/file_form/$debit_id"); ?>"
                                                   target=”_blank”>
                                                    <i class="fa fa-arrow-right fa-xl"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php $control2 = get_from_any_and_array("debit", "worker_id", $item->id, "safety_id", "$item->safety_id"); ?>
                        <?php $req_debits = get_as_array($settings->isg_debit); ?>
                        <?php foreach ($control2 as $a) { ?>
                            <?php
                            $array2 = array_column($a, "zimmet_turu");
                            $eksik = count(array_column($a, "zimmet_turu"));
                            $array1 = $req_debits;
                            $results = array_diff($array1, $array2);
                            ?>
                            <?php foreach ($results as $result) { ?>
                                <tr>
                                    <td class="text-center">
                                        <b> <?php echo $i++; ?></b>
                                    </td>
                                    <td>
                                        <?php echo $result; ?>
                                        <?php $debit_type = convertToSEO($result); ?>
                                    </td>
                                    <td></td>
                                    <td class="text-center"><a href="<?php echo base_url("debit/new_form/$item->id/$debit_type"); ?>"
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
