<?php if (!empty($edit_personel)) { ?>
    <div class="card-body">
        <div class="modal fade" id="EditPersonelModal" tabindex="-1" role="dialog"
             aria-labelledby="EditPersonelModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personel Düzenle</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPersonelForm"
                              data-form-url="<?php echo base_url("$this->Module_Name/edit_personel/$edit_personel->id"); ?>"
                              method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="mb-3">
                                <label class="col-form-label" for="name_surname">Adı Soyadı:</label>
                                <input id="name_surname" type="text"
                                       class="form-control <?php cms_isset(form_error("name_surname"), "is-invalid", ""); ?>"
                                       name="name_surname"
                                       value="<?php echo isset($form_error) ? set_value("name_surname") : "$edit_personel->name_surname"; ?>"
                                       placeholder="Adı Soyadı">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('name_surname'); ?></div>
                                <?php } ?>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label" for="social_id">TC Kimlik No:</label>
                                <input id="social_id" type="text"
                                       class="form-control <?php cms_isset(form_error("social_id"), "is-invalid", ""); ?>"
                                       name="social_id" maxlength="11" minlength="11"
                                       pattern="[0-9]{11}"
                                       placeholder="TC NO"
                                       value="<?php echo isset($form_error) ? set_value("social_id") : "$edit_personel->social_id"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('social_id'); ?></div>
                                <?php } ?>
                            </div>


                            <!-- Tarih -->
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Giriş Tarihi</label>
                                <input type="date" name="start_date" id="start_date"
                                       value="<?php echo isset($form_error) ? date(set_value('start_date')) : date($edit_personel->start_date); ?>"
                                       class="form-control <?php cms_isset(form_error("start_date"), "is-invalid", ""); ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('start_date'); ?></div>
                                <?php } ?>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label" for="group">Meslek:</label>
                                <select id="select2-demo-profession" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("group"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="group">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("group"), null, "", set_value("group")) : $edit_personel->group; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("group"), null, "Seçiniz", set_value("group")) : group_name($edit_personel->group); ?>
                                    </option>
                                    <!-- Dynamic site options -->
                                    <?php if (!empty($workgroups)) { ?>}
                                        <?php foreach ($workgroups as $active_workgroup => $workgroups) {
                                            foreach ($workgroups as $workgroup) { ?>
                                                <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('group'); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="bank">Banka:</label>
                                <select id="select2-demo-bank" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("bank"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="bank">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("bank"), null, "", set_value("bank")) : $edit_personel->bank; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("bank"), null, "Seçiniz", set_value("bank")) : $edit_personel->bank; ?>
                                    </option>
                                    <!-- Dynamic site options -->
                                    <?php $banks = get_as_array($settings->bankalar);
                                    foreach ($banks as $bank) { ?>
                                        <option><?php echo $bank; ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('bank'); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="IBAN">IBAN:</label>
                                <input id="IBAN" type="text" name="IBAN"
                                       class="form-control <?php cms_isset(form_error("IBAN"), "is-invalid", ""); ?>"
                                       value="<?php echo isset($form_error) ? set_value("IBAN") : "$edit_personel->IBAN"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('IBAN'); ?></div>
                                <?php } ?>
                            </div>
                            <!-- Açıklama -->
                            <div class="mb-3">
                                <label class="col-form-label" for="payment_notes">Açıklama:</label>
                                <input id="personel_notes" type="text"
                                       class="form-control <?php cms_isset(form_error("personel_notes"), "is-invalid", ""); ?>"
                                       name="personel_notes" value="<?php echo isset($form_error) ? set_value("personel_notes") : "$edit_personel->notes"; ?>"
                                       placeholder="Açıklama">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('personel_notes'); ?></div>
                                <?php } ?>
                            </div>

                            <!-- Tarih -->
                            <div class="mb-3">
                                <label for="exit_date" class="form-label">Çıkış Tarihi</label>
                                <input type="date" name="exit_date" id="exit_date"
                                       value="<?php echo isset($form_error) ? date(set_value('exit_date')) : date($edit_personel->exit_date); ?>"
                                       class="form-control <?php cms_isset(form_error("exit_date"), "is-invalid", ""); ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('exit_date'); ?></div>
                                <?php } ?>
                            </div>
                            <!-- Dosya Yükle -->
                            <?php

                            $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Personel/$edit_personel->id";

                            if (!is_dir($file_path)) {
                                mkdir($file_path, 0777, true);
                            }

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

                            // $edit_expense->id ile eşleşen bir dosya olup olmadığını kontrol ediyoruz
                            if (in_array($edit_personel->id, $file_names_without_extension)) { ?>
                                <div id="file-upload-container">
                                    <a href="<?php echo base_url("$this->Module_Name/personel_file_download/$edit_personel->id"); ?>">
                                        <i class="fa fa-download f-14 ellips"></i> Dosyayı İndir
                                    </a>
                                    <span onclick="delete_file(this)"
                                          data-url="<?php echo base_url("$this->Module_Name/personel_file_delete/$edit_personel->id"); ?>">
                                    <i class="fa fa-times-circle"></i>SİL
                                </span>
                                </div>
                            <?php } else { ?>
                                <div id="file-upload-container" class="mb-3" >
                                    <label class="col-form-label" for="file-input">Dosya Yükle:</label>
                                    <input class="form-control" name="file" id="file-input" type="file">
                                </div>
                            <?php }
                            ?>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary"
                                onclick="submit_modal_form('editPersonelForm', 'EditPersonelModal', 'tab_personel', 'personelTable')">
                            Gönder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>