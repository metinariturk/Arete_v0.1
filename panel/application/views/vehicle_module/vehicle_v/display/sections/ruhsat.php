<div class="row">
    <div class="col-sm-6">
        <table class="table">
            <tbody>
            <tr>
                <td><strong>Plaka</strong></td>
                <td><?php echo $item->plaka; ?></td>
            </tr>
            <tr>
                <td><strong>Motor No</strong></td>
                <td><?php echo $item->motor_no; ?></td>
            </tr>
            <tr>
                <td><strong>Şase No</strong></td>
                <td><?php echo $item->sase_no; ?></td>
            </tr>
            <tr>
                <td><strong>Model Yılı</strong></td>
                <td><?php echo $item->model; ?></td>
            </tr>
            <tr>
                <td><strong>Marka</strong></td>
                <td><?php echo $item->marka; ?></td>
            </tr>
            <tr>
                <td><strong>Ticari Ad</strong></td>
                <td><?php echo $item->ticari_ad; ?></td>
            </tr>
            <tr>
                <td><strong>Tipi</strong></td>
                <td><?php echo $item->tipi; ?></td>
            </tr>
            <tr>
                <td><strong>İlk Tescil</strong></td>
                <td><?php echo $item->ilk_tescil; ?></td>
            </tr>
            <tr>
                <td><strong>Tescil Tarihi</strong></td>
                <td><?php echo $item->tescil_tarih; ?></td>
            </tr>
            <tr>
                <td><strong>Tescil No</strong></td>
                <td><?php echo $item->tescil_no; ?></td>
            </tr>

            <tr>
                <td><strong>Sınıf</strong></td>
                <td><?php echo $item->sinif; ?></td>
            </tr>
            <tr>
                <td><strong>Cins</strong></td>
                <td><?php echo $item->cins; ?></td>
            </tr>
            <tr>
                <td><strong>Renk</strong></td>
                <td><?php echo $item->renk; ?></td>
            </tr>
            <tr>
                <td><strong>Amaç</strong></td>
                <td><?php echo $item->amac; ?></td>
            </tr>
            <tr>
                <td><strong>Araç Sahibi Ünvan</strong></td>
                <td><?php echo company_name($item->sahibi); ?></td>
            </tr>
            <tr>
                <td><strong>Araç Sahibi Vergi No</strong></td>
                <td><?php echo $item->vergi_no; ?></td>
            </tr>
            <tr>
                <td><strong>Şehir</strong></td>
                <td><?php echo city_name($item->adress_city); ?></td>
            </tr>
            <tr>
                <td><strong>İlçe</strong></td>
                <td><?php echo district_name($item->adress_district); ?></td>
            </tr>
            <tr>

            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <table class="table">
            <tbody>
            <tr>
                <td class="text-center" colspan="2"><strong>Evraklar</strong></td>
            </tr>
            <table class="table table-bordered table-striped table-hover pictures_list">
                <thead>
                <th class="order"><i class="fa fa-reorder"></i></th>
                <th>#id</th>
                <th>Dosya Adı</th>
                </thead>
                <tbody>
                <?php foreach ($item_files as $file) { ?>
                    <tr id="ord-<?php echo $file->id; ?>">
                        <td class="w5c"><?php echo ext_img($file->img_url); ?></td>
                        <td class="w5c">#<?php echo $file->id; ?></td>
                        <td ><?php echo filenamedisplay($file->img_url); ?></td>
                        <td class="w15">
                            <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id/display"); ?>">
                                <i style="font-size: 18px;" class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
        </table>
    </div>
</div>
