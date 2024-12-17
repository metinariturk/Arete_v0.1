<?php if (isset($edit_advance)) { ?>
    <div class="modal fade" id="EditAdvanceModal" tabindex="-1" aria-labelledby="editAdvanceModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdvanceModalLabel">Avans Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAdvanceForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/edit_advance/$edit_advance->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="mb-2">
                            <div class="col-form-label">Avans Avans Tarihi Edit</div>
                            <input class="datepicker-here form-control digits <?php cms_isset(form_error("avans_tarih"), "is-invalid", ""); ?>"
                                   type="text"
                                   name="avans_tarih"
                                   value="<?php echo isset($form_error) ? set_value("avans_tarih") : dateFormat_dmy($edit_advance->avans_tarih); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("avans_tarih"); ?></div>
                            <?php } ?>
                        </div>

                        <div class="mb-2">
                            <div class="col-form-label">Avans Türü</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("avans_turu"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="avans_turu">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? set_value("avans_turu") : $edit_advance->avans_turu; ?>"><?php echo isset($form_error) ? set_value("avans_turu") : $edit_advance->avans_turu; ?>
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
                            <div class="col-form-label">Avans Tutar</div>
                            <?php if (isset($form_error)) { ?>
                                <?php
                                // Avans miktarı alanı boş değilse ve sözleşme bedelinden fazla girildiyse kontrol yap
                                if (!empty(set_value("avans_miktar")) && form_error("avans_miktar")) { ?>
                                    <div style="color: red">
                                        *** Sözleşme bedelinden fazla avans ödemesi yapılamaz. Özel bir gerekçe ile fazla
                                        avans ödemesi yapılması gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                                        <br>
                                        <input name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla tahsilat yapmak istiyorum!
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <input id="avans_miktar"
                                   class="form-control <?php cms_isset(form_error("avans_miktar"), "is-invalid", ""); ?>"
                                   name="avans_miktar"
                                   placeholder="Avans Tutar"
                                   value="<?php echo isset($form_error) ? set_value("avans_miktar") : $edit_advance->avans_miktar; ?>">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("avans_miktar"); ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-2">
                            <div class="col-form-label">Vade Tarihi</div>
                            <input class="datepicker-here form-control digits <?php cms_isset(form_error("vade_tarih"), "is-invalid", ""); ?>"
                                   type="text"
                                   name="vade_tarih"
                                   value="<?php echo isset($form_error) ? set_value("vade_tarih") : dateFormat_dmy($edit_advance->vade_tarih); ?>"
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
                                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : $edit_advance->aciklama; ?></textarea>

                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
                            <?php } ?>
                        </div>

                        <?php
                        $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Advance/$edit_advance->id";

                        if (!is_dir($file_path)) {
                            mkdir($file_path, 0777, true);
                        }

                        $files = glob("$file_path/*"); // glob ile tüm dosyaları al
                        ?>
                        <div class="mb-2">
                            <label class="col-form-label">Yüklenen Dosyalar</label>
                            <div class="list-group">
                                <?php foreach ($files as $file): ?>
                                    <?php
                                    // Dosya adını kısalt
                                    $filename = basename($file);
                                    $short_filename = strlen($filename) > 40 ? substr($filename, 0, 40) . '...' : $filename;
                                    ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <?php echo ext_img($file); // Dosya simgesi ?>
                                            </div>
                                            <div>
                                                <!-- Kısaltılmış dosya adı -->
                                                <p class="mb-0 small" title="<?php echo $filename; ?>">
                                                    <?php echo $short_filename; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="<?php echo base_url("$this->Module_Name/advance_file_download/$edit_advance->id/" . basename($file)); ?>">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            <a onclick="delete_this_item(this)"
                                               data="<?php echo base_url("$this->Module_Name/advance_file_delete/$edit_advance->id/" . basename($file)); ?>">
                                                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>


                        <div id="file-upload-container" class="mb-3">
                            <label class="col-form-label" for="file-input">Dosya Yükle:</label>
                            <input class="form-control" name="file" id="file-input" type="file">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            id="EditAdvanceModal-<?php echo "$edit_advance->id"; ?>"
                            onclick="submit_modal_form('editAdvanceForm', 'EditAdvanceModal', 'tab_Advance', 'advanceTable')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($edit_advance)) { ?>
    <?php if (isset($error_modal) && $error_modal == "EditAdvanceModal") { ?>
        <script>
            $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto');
            $('#EditAdvanceModal').modal('show');
        </script>
    <?php } ?>
<?php } ?>