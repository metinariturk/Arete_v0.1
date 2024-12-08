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
    alert('#EditCollectionModal-' + <?php echo json_encode($edit_collection->id); ?>);
    $('#EditCollectionModal-' + <?php echo json_encode($edit_collection->id); ?>).click(); // Önce modalı aç
</script>
<?php if (isset($edit_collection)) { ?>
    <div class="modal fade" id="EditCollectionModal" tabindex="-1" aria-labelledby="editCollectionModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCollectionModalLabel">Ödeme Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCollectionForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/edit_collection/$edit_collection->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="mb-2">
                            <div class="col-form-label">Dosya No</div>
                            <div class="input-group">
                                <input class="form-control" value="<?php echo $edit_collection->dosya_no; ?>" readonly>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="col-form-label">Tahsilat Ödeme Tarihi Edit</div>
                            <input class="datepicker-here form-control digits <?php cms_isset(form_error("tahsilat_tarih"), "is-invalid", ""); ?>"
                                   type="text"
                                   name="tahsilat_tarih"
                                   value="<?php echo isset($form_error) ? set_value("tahsilat_tarih") : dateFormat_dmy($edit_collection->tahsilat_tarih); ?>"
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
                                        value="<?php echo isset($form_error) ? set_value("tahsilat_turu") : $edit_collection->tahsilat_turu; ?>"><?php echo isset($form_error) ? set_value("tahsilat_turu") : $edit_collection->tahsilat_turu; ?>
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
                                        <input name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla
                                        tahsilat
                                        yapmak istiyorum!
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <input id="tahsilat_miktar"
                                   class="form-control <?php cms_isset(form_error("tahsilat_miktar"), "is-invalid", ""); ?>"
                                   name="tahsilat_miktar"
                                   placeholder="Tahsilat Tutar"
                                   value="<?php echo isset($form_error) ? set_value("tahsilat_miktar") : $edit_collection->tahsilat_miktar; ?>">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("tahsilat_miktar"); ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-2">
                            <div class="col-form-label">Vade Tarihi</div>
                            <input class="datepicker-here form-control digits <?php cms_isset(form_error("vade_tarih"), "is-invalid", ""); ?>"
                                   type="text"
                                   name="vade_tarih"
                                   value="<?php echo isset($form_error) ? set_value("vade_tarih") : dateFormat_dmy($edit_collection->vade_tarih); ?>"
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
                                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : $edit_collection->aciklama; ?></textarea>

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
                            id="EditCollectionModal-<?php echo "$edit_collection->id"; ?>"
                            onclick="submit_modal_form('editCollectionForm', 'EditCollectionModal', 'tab_Collection', 'collectionTable')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

