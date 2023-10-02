<div class="row">
    <div class="col-sm-6">
        <table class="table">
            <tbody>
            <?php foreach ($rents as $rent) { ?>
                <?php if ($rent->isActive == 1) { ?>
                    <tr>
                        <td><strong>Kiralayan Firma</strong></td>
                        <td>
                            <a href="<?php echo base_url("company/file_form/$rent->kiralayan_firma"); ?>"> <?php echo company_name($rent->kiralayan_firma); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Kiralanan Firma</strong></td>
                        <td>
                            <a href="<?php echo base_url("company/file_form/$rent->kiralanan_firma"); ?>"> <?php echo company_name($rent->kiralanan_firma); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Başlangıç Tarihi</strong></td>
                        <td>
                            <a href="<?php echo base_url("rent/file_form/$rent->id"); ?>"> <?php echo dateFormat_dmy($rent->baslangic); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Bitiş Tarihi</strong></td>
                        <td>
                            <a href="<?php echo base_url("rent/file_form/$rent->id"); ?>"> <?php echo dateFormat_dmy($rent->bitis); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Fiyat</strong></td>
                        <td><?php echo money_format($rent->fiyat); ?>
                            / <?php kiralama_turu($rent->kiralama_turu); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Yakıt</strong></td>
                        <td><?php echo liability($rent->yakit); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Operatör</strong></td>
                        <td><?php echo liability($rent->operator); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Bakım ve Servis</strong></td>
                        <td><?php echo liability($rent->bakim_servis); ?></td>
                    </tr>
                <?php } ?>
            <?php }
            if ($rents == null) { ?>
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="text-center" colspan="2"><strong>Aktif Kiralama Anlaşması Yok</strong></td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="2"><strong>Yeni Kiralama Bilgisi Ekle
                                <a href="<?php echo base_url("rent/new_form/$item->id"); ?>">
                                    <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                                </a>
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php } ?>
        </table>
    </div>
    <div class="col-sm-6">
        <table class="table">
            <tbody>
            <tr>
                <td class="text-center" colspan="2"><strong>Kiralamaya Ait Evraklar</strong></td>
            </tr>
            <table class="table table-bordered table-striped table-hover pictures_list">
                <thead>
                <th class="order"><i class="fa fa-reorder"></i></th>
                <th>#id</th>
                <th>Dosya Adı<?php echo "$rent->id"; ?></th>
                </thead>
                <tbody>
                <?php if (!empty($rent->id)) {
                    $rent_files = get_module_files("rent_files", "rent_id", "$rent->id");
                    if (!empty($rent_files)) {
                        foreach ($rent_files as $rent_file) { ?>
                            <tr id="ord-<?php echo $rent_file->id; ?>">
                                <td class="w5c"><?php echo ext_img($rent_file->img_url); ?></td>
                                <td class="w5c">#<?php echo $rent_file->id; ?></td>
                                <td><?php echo filenamedisplay($rent_file->img_url); ?></td>
                                <td class="w15">
                                    <a href="<?php echo base_url("rent/file_download/$rent_file->id/file_form"); ?>">
                                        <i style="font-size: 18px;" class="fa fa-arrow-circle-down"
                                           aria-hidden="true"></i>
                                    </a>
                                    <a onclick="deleteConfirmationFile(this)" data-text="Bu Dosyayı"
                                       data-url="<?php echo base_url("$this->Module_Name/fileDelete/$rent_file->id/file_form"); ?>">
                                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                           aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
    </div>
</div><!-- .widget -->
