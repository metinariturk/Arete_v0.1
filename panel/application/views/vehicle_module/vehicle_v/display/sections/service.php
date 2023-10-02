<div class="row">
    <div class="col-sm-6">
        <a class="pager-btn btn btn-purple btn-outline" href="<?php echo base_url("service/new_form/$item->id"); ?>">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Yeni Servis/Bakım/Muayene
        </a>
        <table class="table table-hover">
            <thead>
            <th colspan="8"><h4>Servis/Bakım/Muayene İşlemleri</h4></th>

            </thead>
            <thead>
            <th class="w5c">Servis No</th>
            <th class="w5c">Servis Tarihi</th>
            <th class="w10c">İşlem</th>
            <th class="w15c">Firma</th>
            <th class="w15c">Saat/Km</th>
            <th class="w20c">Yapılan İş Bedeli</th>
            <th class="w25c">Açıklama</th>
            <th class="w25c">İşlem</th>
            </thead>

            <tbody>
            <?php if ($services == null) { ?>
                <tr>
                    <td colspan="8">
                        <div class="alert alert-danger" role="alert">
                            Servis/Bakım/Muayene Kaydı Yok
                        </div>
                    </td>
                </tr>

            <?php } else { ?>
                <?php foreach ($services as $service) { ?>
                    <tr data-toggle="collapse" data-target="#accordion<?php echo $service->id; ?>" class="clickable"
                        id="center_row">
                        <td><?php echo $service->id; ?></td>
                        <td><?php echo dateFormat_dmy($service->servis_tarih); ?></td>
                        <td><?php echo islem_turu($service->islem_turu); ?></td>
                        <td><?php echo company_name($service->servis_firma); ?></td>
                        <td><?php echo $service->servis_km_saat; ?><?php echo km_saat($service->km_saat); ?></td>
                        <td><?php echo money_format($service->fiyat); ?> TL</td>
                        <td><?php echo $service->genel_bilgi; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Bu Poliçe"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("service/file_form/$service->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <div id="accordion<?php echo $service->id; ?>" class="collapse">
                                <?php if (!empty($service->id)) {
                                    $service_files = get_module_files("service_files", "service_id", "$service->id");
                                    if (!empty($service_files)) {
                                        foreach ($service_files as $service_file) { ?>
                                            <div class="div-table">
                                                <div class="div-table-row">
                                                    <div class="div-table-col">
                                                        <?php echo $service_file->id; ?>
                                                        <a href="<?php echo base_url("service/file_download/$service_file->id/file_form"); ?>">
                                                            <?php echo filenamedisplay($service_file->img_url); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="div-table">
                                            <div class="div-table-row">
                                                <div class="div-table-col">
                                                    Dosya Yok, Eklemek İçin Görüntüle Butonundan Servis Formu Sayfasına
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
                <td colspan="5" class="w10c"><b>Toplam Servis/Bakım/Muayene Ödemeleri</b></td>
                <td colspan="3" class="w25c">
                    <b><?php echo money_format(sum_anything("service", "fiyat", "vehicle_id", $item->id)); ?> TL</b>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-sm-3">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/service_graph"); ?>
    </div>
    <div class="col-sm-3">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/repair_graph"); ?>
    </div>
</div>

