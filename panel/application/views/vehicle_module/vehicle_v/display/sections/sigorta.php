<div class="row">
    <div class="col-sm-6">
        <a class="pager-btn btn btn-purple btn-outline" href="<?php echo base_url("insurance/new_form/$item->id/1"); ?>">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Yeni Sigorta Poliçesi
        </a>

        <table class="table table-hover">
            <thead>
            <th colspan="7"><h4>Zorunlu Tarfik Sigortası Bilgileri</h4></th>

            </thead>
            <thead>
            <th class="w5c">No</th>
            <th class="w5c">Poliçe No</th>
            <th class="w10c">Başlangıç Tarihi</th>
            <th class="w10c">Bitiş Tarihi</th>
            <th class="w25c">Firma</th>
            <th class="w20c">Sigorta Prim Bedeli</th>
            <th class="w15c">Kalan Süre</th>
            <th class="w5c">Görüntüle</th>
            </thead>

            <tbody>
            <?php if ($insurances == null) { ?>
                <tr>
                    <td colspan="7">
                        <div class="alert alert-danger" role="alert">
                            Aktif Sigorta veya Kasko Yok!
                        </div>
                    </td>
                </tr>

            <?php } else { ?>
                <?php foreach ($insurances as $insurance) { ?>
                    <tr data-toggle="collapse" data-target="#accordion<?php echo $insurance->id; ?>" class="clickable"
                        id="center_row">

                        <?php if (dateDifference(date("Y-m-d"), $insurance->bitis) < 10) {
                            $alert = 'class="alert alert-danger" role="alert"';
                            $warning = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                            $remain = dateDifference(date("Y-m-d"), $insurance->bitis);
                            if ($remain < 0) {
                                $remain_days = "Süre Doldu";
                            } else {
                                $remain_days = dateDifference(date("Y-m-d"), $insurance->bitis);
                            }
                        } else {
                            $alert = 'class="alert alert-success" role="alert"';
                            $warning = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $remain_days = dateDifference(date("Y-m-d"), $insurance->bitis) . " Gün";
                        } ?>

                        <td><?php echo $insurance->id; ?></td>
                        <td><?php echo $insurance->police_no; ?></td>
                        <td><?php echo dateFormat_dmy($insurance->baslangic); ?></td>
                        <td><?php echo dateFormat_dmy($insurance->bitis); ?></td>
                        <td><?php echo $insurance->sigorta_firma; ?></td>
                        <td><?php echo money_format($insurance->prim_bedel); ?> TL</td>
                        <td <?php echo $alert; ?>><?php echo $warning . " " . $remain_days; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Bu Poliçe"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("insurance/file_form/$insurance->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <div id="accordion<?php echo $insurance->id; ?>" class="collapse">
                                <?php if (!empty($insurance->id)) {
                                    $insurance_files = get_module_files("insurance_files", "insurance_id", "$insurance->id");
                                    if (!empty($insurance_files)) {
                                        foreach ($insurance_files as $insurance_file) { ?>
                                            <div class="div-table">
                                                <div class="div-table-row">
                                                    <div class="div-table-col">
                                                        <?php echo $insurance_file->id; ?>
                                                        <a href="<?php echo base_url("insurance/file_download/$insurance_file->id/file_form"); ?>">
                                                            <?php echo filenamedisplay($insurance_file->img_url); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="div-table">
                                            <div class="div-table-row">
                                                <div class="div-table-col">
                                                    Dosya Yok, Eklemek İçin Görüntüle Butonundan Poliçe Sayfasına
                                                    Gidiniz
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="w10c"><b>Toplam Zorunlu Sigorta Harcamaları</b></td>
                <td colspan="2" class="w25c">
                    <b><?php echo money_format(sum_anything_and("insurance", "prim_bedel", "vehicle_id", $item->id, "kapsam", "1")); ?>
                        TL</b>
                </td>
            </tr>
        </table>


    </div>
    <div class="col-sm-6">
        <a class="pager-btn btn btn-purple btn-outline" href="<?php echo base_url("insurance/new_form/$item->id/2"); ?>">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Yeni Kasko Poliçesi
        </a>

        <table class="table table-hover">
            <thead>
            <th colspan="7"><h4>Kasko Poliçesi Bilgileri</h4></th>

            </thead>
            <thead>
            <th class="w5c">No</th>
            <th class="w5c">Poliçe No</th>
            <th class="w10c">Başlangıç Tarihi</th>
            <th class="w10c">Bitiş Tarihi</th>
            <th class="w25c">Firma</th>
            <th class="w20c">Kasko Prim Bedeli</th>
            <th class="w15c">Kalan Süre</th>
            <th class="w5c">Görüntüle</th>
            </thead>

            <tbody>
            <?php if ($kaskolar == null) { ?>
                <tr>
                    <td colspan="7">
                        <div class="alert alert-danger" role="alert">
                            Aktif Kasko Yok!
                        </div>
                    </td>
                </tr>

            <?php } else { ?>
                <?php foreach ($kaskolar as $kasko) { ?>
                    <tr data-toggle="collapse" data-target="#accordion<?php echo $kasko->id; ?>" class="clickable"
                        id="center_row">

                        <?php if (dateDifference(date("Y-m-d"), $kasko->bitis) < 10) {
                            $alert = 'class="alert alert-danger" role="alert"';
                            $warning = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                            $remain = dateDifference(date("Y-m-d"), $kasko->bitis);
                            if ($remain < 0) {
                                $remain_days = "Süre Doldu";
                            } else {
                                $remain_days = dateDifference(date("Y-m-d"), $kasko->bitis);
                            }
                        } else {
                            $alert = 'class="alert alert-success" role="alert"';
                            $warning = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
                            $remain_days = dateDifference(date("Y-m-d"), $kasko->bitis) . " Gün";
                        } ?>

                        <td><?php echo $kasko->id; ?></td>
                        <td><?php echo $kasko->police_no; ?></td>
                        <td><?php echo dateFormat_dmy($kasko->baslangic); ?></td>
                        <td><?php echo dateFormat_dmy($kasko->bitis); ?></td>
                        <td><?php echo $kasko->sigorta_firma; ?></td>
                        <td><?php echo money_format($kasko->prim_bedel); ?> TL</td>
                        <td <?php echo $alert; ?>><?php echo $warning . " " . $remain_days; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Bu Poliçe"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("insurance/file_form/$kasko->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <div id="accordion<?php echo $kasko->id; ?>" class="collapse">
                                <?php if (!empty($kasko->id)) {
                                    $kasko_files = get_module_files("insurance_files", "insurance_id", "$kasko->id");
                                    if (!empty($kasko_files)) {
                                        foreach ($kasko_files as $kasko_file) { ?>
                                            <div class="div-table">
                                                <div class="div-table-row">
                                                    <div class="div-table-col">
                                                        <?php echo $kasko_file->id; ?>
                                                        <a href="<?php echo base_url("insurance/file_download/$kasko_file->id/file_form"); ?>">
                                                            <?php echo filenamedisplay($kasko_file->img_url); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="div-table">
                                            <div class="div-table-row">
                                                <div class="div-table-col">
                                                    Dosya Yok, Eklemek İçin Görüntüle Butonundan Poliçe Sayfasına
                                                    Gidiniz
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="w10c"><b>Toplam Kasko Harcamaları</b></td>
                <td colspan="2" class="w25c">
                    <b><?php echo money_format(sum_anything_and("insurance", "prim_bedel", "vehicle_id", $item->id, "kapsam", "2")); ?>
                        TL</b>
                </td>
            </tr>
        </table>
    </div>
</div>


