<script>
    $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
    $('body').removeClass('modal-open');
    $('body').css('overflow', 'auto');
</script>
<?php if (isset($edit_bond)) { ?>
    <div class="modal fade" id="EditBondModal" tabindex="-1" aria-labelledby="editBondModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBondModalLabel">Ödeme Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBondForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/edit_bond/$edit_bond->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="mb-2">
                            <div class="col-form-label">Teminat Tarihi</div>
                            <input class="datepicker-here form-control digits <?php cms_isset(form_error("teslim_tarih"), "is-invalid", ""); ?>"
                                   type="text"
                                   name="teslim_tarih"
                                   value="<?php echo isset($form_error) ? set_value("teslim_tarih") : dateFormat_dmy($edit_bond->teslim_tarih); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("teslim_tarih"); ?></div>
                            <?php } ?>
                        </div>

                        <div class="mb-2">
                            <div class="col-form-label">Teminat Türü</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("teminat_turu"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="teminat_turu">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? set_value("teminat_turu") : $edit_bond->teminat_turu; ?>"><?php echo isset($form_error) ? set_value("teminat_turu") : $edit_bond->teminat_turu; ?>
                                </option>
                                <?php $teminat_turleri = get_as_array($settings->teminat_turu);
                                foreach ($teminat_turleri as $teminat_turu) {
                                    echo "<option value='$teminat_turu'>$teminat_turu</option>";
                                } ?>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("teminat_turu"); ?></div>
                            <?php } ?>
                        </div>

                        <div class="mb-2">
                            <div class="col-form-label">Gerekçe</div>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("teminat_gerekce"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="teminat_gerekce">
                                <option selected="selected"
                                        value="<?php echo isset($form_error) ? set_value("teminat_gerekce") : $edit_bond->teminat_gerekce; ?>"><?php echo isset($form_error) ? set_value("teminat_gerekce") : $edit_bond->teminat_gerekce; ?>
                                </option>
                                <option>Sözleşme Teminatı</option>
                                <option>Fiyat Farkı Teminatı</option>
                                <option>Avans Teminatı</option>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("teminat_gerekce"); ?></div>
                            <?php } ?>
                        </div>

                        <div class="mb-2">
                            <div class="col-form-label">Banka</div>
                            <input class="form-control  <?php cms_isset(form_error("teminat_banka"), "is-invalid", ""); ?>" name="teminat_banka"
                                   list="datalistOptions" placeholder="Banka Adı Yazınız" value="<?php echo isset($form_error) ? set_value("teminat_banka") : $edit_bond->teminat_banka; ?>">
                            <datalist id="datalistOptions">
                                <?php $bankalar = get_as_array($settings->bankalar);
                                foreach ($bankalar as $banka) {
                                    echo "<option value='$banka'>$banka</option>";
                                } ?>
                            </datalist>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("teminat_banka"); ?></div>
                            <?php } ?>
                        </div>

                        <div class="mb-2">
                            <div class="col-form-label">Teminat Tutar</div>

                            <input class="form-control <?php cms_isset(form_error("teminat_miktar"), "is-invalid", ""); ?>"
                                   name="teminat_miktar" type="number"
                                   placeholder="Teminat Tutar"
                                   value="<?php echo isset($form_error) ? set_value("teminat_miktar") : $edit_bond->teminat_miktar; ?>">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("teminat_miktar"); ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-2">
                            <div class="col-form-label">Geçerlilik Tarihi</div>
                            <input class="datepicker-here form-control digits <?php cms_isset(form_error("gecerlilik_tarih"), "is-invalid", ""); ?>"
                                   type="text"
                                   name="gecerlilik_tarih"
                                   value="<?php echo isset($form_error) ? set_value("gecerlilik_tarih") : dateFormat_dmy($edit_bond->gecerlilik_tarih); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("gecerlilik_tarih"); ?></div>
                            <?php } ?>
                        </div>
                        <div class="mb-2">
                            <div class="col-form-label">Açıklama</div>
                            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                                      name="aciklama"
                                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : $edit_bond->aciklama; ?></textarea>

                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
                            <?php } ?>
                        </div>

                        <?php
                        $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Bond/$edit_bond->id";

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
                                            <a href="<?php echo base_url("$this->Module_Name/bond_file_download/$edit_bond->id/" . basename($file)); ?>">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            <a onclick="delete_this_item(this)"
                                               data="<?php echo base_url("$this->Module_Name/bond_file_delete/$edit_bond->id/" . basename($file)); ?>">
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
                            id="EditBondModal-<?php echo "$edit_bond->id"; ?>"
                            onclick="submit_modal_form('editBondForm', 'EditBondModal', 'tab_Bond', 'bondTable')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($edit_bond)) { ?>
    <?php if (isset($error_modal) && $error_modal == "EditBondModal") { ?>
        <script>
            $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto');
            $('#EditBondModal').modal('show');
        </script>
    <?php } ?>
<?php } ?>