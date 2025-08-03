<?php if (isset($form_error) && $form_error): ?>
    <script>
        $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
        $('body').removeClass('modal-open');
        $('body').css('overflow', 'auto');
        $('#<?php echo $error_modal; ?>').modal('show');

        // DataTable kontrolü ve yeniden başlatılması
        if ($.fn.DataTable.isDataTable('#personelTable')) {
            $('#personelTable').DataTable().destroy(); // Mevcut tabloyu yok et
        }

        // DataTable'ı yeniden başlat
        if (!$.fn.DataTable.isDataTable('#personelTable')) {
            $('#personelTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                // Diğer DataTable ayarları
            });
        }
    </script>
<?php endif; ?>

<?php $file_path = "uploads/project_v/$project->dosya_no/$item->dosya_no/Personel";

// Klasördeki tüm dosya ve klasörleri alıyoruz
$files = scandir($file_path);

// '.' ve '..' gibi klasörleri filtreleyip sadece dosya isimlerini almak için array_filter kullanıyoruz
$files = array_filter($files, function ($file) use ($file_path) {
    return !is_dir($file_path . '/' . $file); // Klasörleri dahil etmiyoruz, sadece dosyalar
});

// Dosya isimlerini uzantıları olmadan yeni bir diziye alıyoruz
$file_names_without_extension = array_map(function ($file) {
    return pathinfo($file, PATHINFO_FILENAME); // Sadece dosya adını (uzantısız) alıyoruz
}, $files);
?>

<div class="card-body">
    <div id="add_personel_modal">
        <div class="modal fade" id="AddPersonelModal" tabindex="-1" role="dialog"
             aria-labelledby="AddPersonelModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Yeni Personel</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view("site_module/site_v/display/modals/new_personel_modal_form"); ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary"
                                onclick="submit_modal_form('addPersonelForm', 'AddPersonelModal', 'tab_personel', 'personelTable')">
                            Gönder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <h5><?php if (isset($situation)) {
                            echo $situation == 1 ? "Çalışan" : ($situation == 0 ? "Çalışmayan" : "");
                        } ?>
                        <?php if (isset($group_code)) {
                            echo group_name($group_code);
                        } ?>
                        <br>Personel Listesi</h5>
                    <?php if (isset($group_code)) { ?>
                        <a href="<?php echo base_url("export/personel_download_excel/$group_code/$situation"); ?>">
                            <i class="fa fa-file-excel-o fa-2x"></i>
                        </a>
                        <a href="<?php echo base_url("export/personel_download_pdf/$group_code/$situation"); ?>">
                            <i class="fa fa-file-pdf-o fa-2x"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table id="personelTable" class="table" style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Adı Soyadı</th>
                        <th class="d-none d-sm-table-cell">TC Kimlik No</th>
                        <th>Meslek</th>
                        <th class="d-none d-sm-table-cell">İşe Giriş/Çıkış</th>
                        <th class="d-none d-sm-table-cell">Hesap No / Banka</th>
                        <th class="d-none d-sm-table-cell">İşlem</th>
                        <th class="d-sm-none">Detaylar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($active_personel_datas as $personel_data) { ?>
                        <tr>
                            <td><?php echo $i++; ?>
                                <?php if ($personel_data->isActive == 1) { ?>
                                    <i class="fa fa-bullseye" style="color: green"></i>
                                <?php } else { ?>
                                    <i class="fa fa-bullseye" style="color: red"></i>
                                <?php } ?>
                            </td>
                            <td><?php echo $personel_data->name_surname; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $personel_data->social_id; ?></td>
                            <td><?php echo group_name($personel_data->group); ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo dateFormat_dmy($personel_data->start_date); ?></td>
                            <td class="d-none d-sm-table-cell">
                                <?php echo wordwrap(str_replace(' ', '', $personel_data->IBAN), 4, ' ', true); ?>
                                <br> <?php echo $personel_data->bank; ?>
                            </td>

                            <td class="d-none d-sm-table-cell">
                            <span class="icon-group">
                            <a data-bs-toggle="modal" class="text-primary"
                               onclick="edit_modal_form('<?php echo base_url("Site/open_edit_personel_modal/$personel_data->id"); ?>','edit_personel_modal','EditPersonelModal')">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <?php if (in_array($personel_data->id, $file_names_without_extension)) { ?>
                                <a href="<?php echo base_url("Site/sitewallet_file_download/$personel_data->id"); ?>">
                                    <i class="fa fa-download f-14 ellips fa-lg"></i>
                                </a>
                            <?php } ?>
                            <a href="javascript:void(0);"
                               onclick="confirmDelete('<?php echo base_url("Site/delete_personel/$personel_data->id"); ?>', '#tab_personel','personelTable')"
                               title="Sil">
                                <i class="fa fa-trash-o fa-lg"></i>
                            </a>
                        </span>
                            </td>
                            <!-- Küçük ekranlar için Detaylar butonu -->
                            <td class="d-sm-none">
                                <button class="btn btn-primary btn-sm"
                                        onclick="openPersonModal(
                                                '<?php echo wordwrap(str_replace(' ', '', $personel_data->IBAN), 4, ' ', true); ?>',
                                                '<?php echo $personel_data->bank; ?>',
                                                '<?php echo $personel_data->name_surname; ?>',
                                                '<?php echo group_name($personel_data->group); ?>',
                                                '<?php echo $personel_data->social_id; ?>',
                                                '<?php echo dateFormat_dmy($personel_data->start_date) . "/" . dateFormat_dmy($personel_data->exit_date); ?>',
                                                '<?php echo base_url("Site/open_edit_personel_modal/$personel_data->id"); ?>')">
                                    Detaylar
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-3">
            <div class="container">

                <?php
                // Aktif, pasif ve tüm personel listelerini alalım
                $active_personel_counts = $this->Workman_model->get_all(array("site_id" => $item->id, "isActive" => 1));
                $passive_personel_counts = $this->Workman_model->get_all(array("site_id" => $item->id, "isActive" => 0));
                $all_personel_counts = $this->Workman_model->get_all(array("site_id" => $item->id));

                // Grup sayımı için boş dizi başlatalım
                $group_counts = [];

                // Aktif personelleri grup sayısına göre sayalım
                foreach ($active_personel_counts as $personel) {
                    $group = $personel->group;

                    // Eğer grup daha önce sayılmadıysa, yeni bir giriş başlat
                    if (!isset($group_counts[$group])) {
                        $group_counts[$group] = 0;
                    }

                    // İlgili grubu bir artır
                    $group_counts[$group]++;
                }
                ?>

                <div class="tabs">
                    <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                        <h5>Çalışan Personel</h5>
                    </div>
                </div>
                <div class="list-group">
                    <a href="javascript:void(0)"
                       onclick="change_list('tab_personel', '<?php echo base_url("Site/chance_list/$item->id/0/1"); ?>','personelTable')"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Tümü
                        <span class="badge bg-primary rounded-pill">
                        <?php echo count($active_personel_counts); ?>
                    </span>
                    </a>
                    <?php foreach ($group_counts as $group => $count) { ?>
                        <a href="javascript:void(0)"
                           onclick="change_list('tab_personel', '<?php echo base_url("Site/chance_list/$item->id/$group/1"); ?>','personelTable')"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                            <?php echo group_name($group); ?>
                            <span class="badge bg-primary rounded-pill">
                        <?php echo $count; ?>
                    </span>
                        </a>
                    <?php } ?>
                </div>
                <hr>

                <div class="tabs">
                    <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                        <h5>Çalışmayan Personel</h5>
                    </div>
                </div>
                <div class="list-group">
                    <a href="javascript:void(0)"
                       onclick="change_list('tab_personel', '<?php echo base_url("Site/chance_list/$item->id/0/0"); ?>','personelTable')"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Tümü
                        <span class="badge bg-primary rounded-pill">
                        <?php echo count($passive_personel_counts); ?>
                    </span>
                    </a>

                    <?php
                    // Passif personelleri grup sayısına göre sayalım
                    $passive_group_counts = [];
                    foreach ($passive_personel_counts as $personel) {
                        $group = $personel->group;
                        if (!isset($passive_group_counts[$group])) {
                            $passive_group_counts[$group] = 0;
                        }
                        $passive_group_counts[$group]++;
                    }

                    foreach ($passive_group_counts as $group => $count) { ?>
                        <a href="javascript:void(0)"
                           onclick="change_list('tab_personel', '<?php echo base_url("Site/chance_list/$item->id/$group/0"); ?>','personelTable')"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                            <?php echo group_name($group); ?>
                            <span class="badge bg-primary rounded-pill">
                        <?php echo $count; ?>
                    </span>
                        </a>
                    <?php } ?>
                </div>
                <hr>

                <div class="tabs">
                    <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                        <h5>Tüm Personel</h5>
                    </div>
                </div>
                <div class="list-group">
                    <a href="javascript:void(0)"
                       onclick="change_list('tab_personel', '<?php echo base_url("Site/chance_list/$item->id"); ?>','personelTable')"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Tümü
                        <span class="badge bg-primary rounded-pill">
                        <?php echo count($all_personel_counts); ?>
                    </span>
                    </a>

                    <?php
                    $all_group_counts = [];
                    foreach ($all_personel_counts as $personel) {
                        $group = $personel->group;
                        if (!isset($all_group_counts[$group])) {
                            $all_group_counts[$group] = 0;
                        }
                        $all_group_counts[$group]++;
                    }

                    foreach ($all_group_counts as $group => $count) { ?>
                        <a href="javascript:void(0)"
                           onclick="change_list('tab_personel', '<?php echo base_url("Site/chance_list/$item->id/$group"); ?>','personelTable')"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                            <?php echo group_name($group); ?>
                            <span class="badge bg-primary rounded-pill">
                        <?php echo $count; ?>
                    </span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="edit_personel_modal">
    <?php $this->load->view("site_module/site_v/display/modals/edit_personel_modal_form"); ?>
</div>

<div class="modal fade" id="personModal" tabindex="-1" aria-labelledby="personModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- modal-lg genişliği artırır, dilerseniz modal-xl kullanabilirsiniz -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="personModalLabel">Personel Bilgileri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="personModalBody">
                <!-- Modal içeriği buraya dinamik olarak yüklenecek -->
            </div>
        </div>
    </div>
</div>

