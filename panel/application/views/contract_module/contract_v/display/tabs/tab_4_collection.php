<?php if (isset($error_modal) && $error_modal == "AddCollectionModal") { ?>
    <script>
        if ($.fn.DataTable.isDataTable('#collectionTable')) {
            $('#collectionTable').DataTable().destroy();
        }

        $('#collectionTable').DataTable({
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

        // Modal açma işlemi ve z-index hatası düzeltme
        $('#openCollectionModal').click(); // Önce modalı aç

    </script>
<?php } ?>

<?php $path_collection = base_url("uploads/$project->project_code/$item->dosya_no/Collection/"); ?>

<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="collectionTable" style="width:100%">
                    <thead>
                    <tr>
                        <th><i class="fa fa-reorder"></i></th>
                        <th>Ödeme Tarihi</th>
                        <th>Ödeme Türü</th>
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
                    <?php if (!empty($collections)) { ?>
                        <?php foreach ($collections as $collection) { ?>
                            <tr>
                                <td> <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $collection->tahsilat_tarih; ?>
                                </td>
                                <td>
                                    <p><?php echo $collection->tahsilat_turu; ?></p>
                                </td>
                                <td>
                                    <p><?php echo money_format($collection->tahsilat_miktar) . " " . get_currency($item->id); ?></p>
                                </td>
                                <td>
                                    <p><?php echo dateFormat_dmy($collection->vade_tarih); ?></p>
                                </td>
                                <td>
                                    <p><?php echo $collection->aciklama; ?></p>
                                </td>
                                <td>
                                    <?php
                                    // Dosya varlığını kontrol et
                                    $file_isset = glob("$path_collection.*") !== [];

                                    // Eğer dosya varsa
                                    if ($file_isset) { ?>
                                        <a href="<?php echo base_url("$this->Module_Name/collection_download/$collection->id"); ?>">
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
                                       onclick="confirmDelete('<?php echo base_url("Contract/delete_collection/$collection->id"); ?>', '#tab_Collection','collectionTable')"
                                       title="Makbuz">
                                        <i class="fa fa-file fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a data-bs-toggle="modal" class="text-primary"
                                       onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_collection_modal/$collection->id"); ?>','edit_collection_modal','EditCollectionModal')">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete('<?php echo base_url("Contract/delete_collection/$collection->id"); ?>', '#tab_Collection','collectionTable')"
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

<div id="edit_collection_modal">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/edit_collection_modal_form"); ?>
</div>


<div class="modal fade" id="AddCollectionModal" tabindex="-1" role="dialog" aria-labelledby="AddCollectionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Ödeme</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCollectionForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/create_collection/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="mb-2">
                        <div class="col-form-label">Dosya No</div>
                        <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">TA</span>
                            <?php if (!empty(get_last_fn("collection"))) { ?>
                                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                       readonly
                                       data-bs-original-title="" title="" name="dosya_no"
                                       value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("collection"); ?>">
                                <?php
                            } else { ?>
                                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                                       readonly
                                       required="" data-bs-original-title="" title="" name="dosya_no"
                                       value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                            <?php } ?>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                                <div class="invalid-feedback">* Önerilen Proje Kodu
                                    : <?php echo increase_code_suffix("collection"); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="col-form-label">Tahsilat Ödeme Tarihi</div>
                        <input class="datepicker-here form-control digits <?php cms_isset(form_error("tahsilat_tarih"), "is-invalid", ""); ?>"
                               type="text"
                               name="tahsilat_tarih"
                               value="<?php echo isset($form_error) ? set_value("tahsilat_tarih") : ""; ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("tahsilat_tarih"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-2">
                        <div class="col-form-label">Tahsilat Türü</div>
                        <select id="select2-demo-1" style="width: 100%;"
                                class="form-control <?php cms_isset(form_error("tahsilat_turu"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="tahsilat_turu">
                            <option selected="selected"
                                    value="<?php echo isset($form_error) ? set_value("tahsilat_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("tahsilat_turu") : "Seçiniz"; ?>
                            </option>
                            <?php $odeme_turleri = get_as_array($settings->odeme_turu);
                            foreach ($odeme_turleri as $odeme_turu) {
                                echo "<option value='$odeme_turu'>$odeme_turu</option>";
                            } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("tahsilat_turu"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-2">
                        <div class="col-form-label">Tahsilat Tutar</div>
                        <?php if (isset($form_error)) { ?>
                            <?php
                            // Tahsilat miktarı alanı boş değilse ve sözleşme bedelinden fazla girildiyse kontrol yap
                            if (!empty(set_value("tahsilat_miktar")) && form_error("tahsilat_miktar")) { ?>
                                <div style="color: red">
                                    *** Sözleşme bedelinden fazla tahsilat yapılamaz. Özel bir gerekçe ile fazla
                                    tahsilat yapılması gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                                    <br>
                                    <input name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla tahsilat
                                    yapmak istiyorum!
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <input class="form-control <?php cms_isset(form_error("tahsilat_miktar"), "is-invalid", ""); ?>"
                               name="tahsilat_miktar"
                               placeholder="Tahsilat Tutar"
                               value="<?php echo isset($form_error) ? set_value("tahsilat_miktar") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("tahsilat_miktar"); ?></div>
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
                        onclick="submit_modal_form('addCollectionForm', 'AddCollectionModal', 'tab_Collection', 'collectionTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
