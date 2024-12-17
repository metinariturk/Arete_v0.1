<script>
    if ($.fn.DataTable.isDataTable('#bondTable')) {
        $('#bondTable').DataTable().destroy();
    }

    $('#bondTable').DataTable({
        "order": [[1, 'desc']],  // Tarih sütununu yeniden eskiye sıralar (index 1)
        "columnDefs": [
            {
                "targets": 1,  // 1, tarih sütununu belirtir.
                "render": function (data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        // Y-m-d formatındaki tarihi d-m-Y formatına dönüştür
                        var dateParts = data.split('-');  // Y-m-d formatında ayır
                        var day = dateParts[2].replace(/\s+/g, '');  // Day kısmındaki boşlukları temizle
                        var month = dateParts[1].replace(/\s+/g, '');  // Month kısmındaki boşlukları temizle
                        var year = dateParts[0].replace(/\s+/g, '');  // Year kısmındaki boşlukları temizle
                        // d-m-Y formatında birleştir
                        return day + '-' + month + '-' + year;  // - ile birleştir
                    }
                    return data;
                }
            }
        ]
    });

</script>
<?php if (isset($error_modal) && $error_modal == "AddBondModal") { ?>
    <script>
        // Modal açma işlemi ve z-index hatası düzeltme
        $('#openBondModal').click(); // Önce modalı aç
    </script>
<?php } ?>


<?php $path_bond = base_url("uploads/$project->project_code/$item->dosya_no/Bond/"); ?>

<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="bondTable" style="width:100%">
                    <thead>
                    <tr>
                        <th><i class="fa fa-reorder"></i></th>
                        <th>Teminat Teslim Tarihi</th>
                        <th>Teminat No</th>
                        <th>Teminat Türü</th>
                        <th>Banka</th>
                        <th>Tutarı</th>
                        <th>Tutarı</th>
                        <th>Vade Tarih</th>
                        <th>Açıklama</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php if (!empty($bonds)) { ?>
                        <?php foreach ($bonds as $bond) { ?>
                            <tr>
                                <td> <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $bond->avans_tarih; ?>
                                </td>
                                <td>
                                    <p><?php echo $bond->avans_turu; ?></p>
                                </td>
                                <td>
                                    <p><?php echo money_format($bond->avans_miktar) . " " . get_currency($item->id); ?></p>
                                </td>
                                <td>
                                    <p><?php echo dateFormat_dmy($bond->vade_tarih); ?></p>
                                </td>
                                <td>
                                    <p><?php echo $bond->aciklama; ?></p>
                                </td>
                                <td>
                                    <?php
                                    // Dosya varlığını kontrol et
                                    $file_isset = glob("$path_bond.*") !== [];

                                    // Eğer dosya varsa
                                    if ($file_isset) { ?>
                                        <a href="<?php echo base_url("$this->Module_Name/bond_download/$bond->id"); ?>">
                                            <i class="fa fa-download f-14 ellips"></i>
                                        </a>
                                    <?php } else { ?>
                                        <!-- Dosya mevcut değilse alternatif bir ikon gösterebilirsin -->
                                        <i class="fa fa-download fa-lg" style="color: grey;"
                                           title="Dosya mevcut değil"></i>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete('<?php echo base_url("Contract/delete_bond/$bond->id"); ?>', '#tab_Bond','bondTable')"
                                       title="Makbuz">
                                        <i class="fa fa-file fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a data-bs-toggle="modal" class="text-primary" id="open_edit_bond_modal_<?php echo $bond->id;?>"
                                       onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_bond_modal/$bond->id"); ?>','edit_bond_modal','EditBondModal')">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete('<?php echo base_url("Contract/delete_bond/$bond->id"); ?>', '#tab_Bond','bondTable')"
                                       title="Sil">
                                        <i class="fa fa-trash-o fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="edit_bond_modal">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/edit_bond_modal_form"); ?>
</div>


<div class="modal fade" id="AddBondModal" tabindex="-1" role="dialog" aria-labelledby="AddBondModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Teminat</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBondForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/create_bond/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="mb-2">
                        <div class="col-form-label">Teminat Tarihi</div>
                        <input class="datepicker-here form-control digits <?php cms_isset(form_error("avans_tarih"), "is-invalid", ""); ?>"
                               type="text"
                               name="avans_tarih"
                               value="<?php echo isset($form_error) ? set_value("avans_tarih") : ""; ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("avans_tarih"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-2">
                        <div class="col-form-label">Ödeme Türü</div>
                        <select id="select2-demo-1" style="width: 100%;"
                                class="form-control <?php cms_isset(form_error("avans_turu"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="avans_turu">
                            <option selected="selected"
                                    value="<?php echo isset($form_error) ? set_value("avans_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("avans_turu") : "Seçiniz"; ?>
                            </option>
                            <?php $odeme_turleri = get_as_array($settings->odeme_turu);
                            foreach ($odeme_turleri as $odeme_turu) {
                                echo "<option value='$odeme_turu'>$odeme_turu</option>";
                            } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("avans_turu"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-2">
                        <div class="col-form-label">Teminat Tutar</div>
                        <?php if (isset($form_error)) { ?>
                            <?php
                            // Teminat miktarı alanı boş değilse ve sözleşme bedelinden fazla girildiyse kontrol yap
                            if (!empty(set_value("avans_miktar")) && form_error("avans_miktar")) { ?>
                                <div style="color: red">
                                    *** Sözleşme bedelinden fazla tahsilat yapılamaz. Özel bir gerekçe ile fazla
                                    tahsilat yapılması gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                                    <br>
                                    <input name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla tahsilat
                                    yapmak istiyorum!
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <input class="form-control <?php cms_isset(form_error("avans_miktar"), "is-invalid", ""); ?>"
                               name="avans_miktar" type="number"
                               placeholder="Teminat Tutar"
                               value="<?php echo isset($form_error) ? set_value("avans_miktar") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("avans_miktar"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-2">
                        <div class="col-form-label">Vade Tarihi</div>
                        <input class="datepicker-here form-control digits <?php cms_isset(form_error("vade_tarih"), "is-invalid", ""); ?>"
                               type="text"
                               name="vade_tarih"
                               value="<?php echo isset($form_error) ? set_value("vade_tarih") : ""; ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("vade_tarih"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-2">
                        <div class="col-form-label">Açıklama</div>
                        <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                                  name="aciklama"
                                  placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>

                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Dosya Yükle -->
                    <div class="mb-3">
                        <label class="col-form-label" for="file-input">Dosya Yükle:</label>
                        <input class="form-control" name="file" id="file-input" type="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addBondForm', 'AddBondModal', 'tab_Bond', 'bondTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
