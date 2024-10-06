<?php if (!empty($edit_expense)) { ?>
    <div class="card-body">
        <div class="modal fade" id="EditExpenseModal" tabindex="-1" role="dialog"
             aria-labelledby="EditExpenseModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Harcama Düzenle</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editExpenseForm"
                              data-form-url="<?php echo base_url("$this->Module_Name/edit_expense/$edit_expense->id"); ?>"
                              method="post" enctype="multipart/form-data" autocomplete="off">
                            <!-- Tarih -->
                            <div class="mb-3">
                                <label for="edit_expense_date" class="form-label">Çıkış Tarihi</label>
                                <input type="date" name="edit_expense_date" id="edit_expense_date"
                                       value="<?php echo isset($form_error) ? date(set_value('edit_expense_date')) : date($edit_expense->date); ?>"
                                       class="form-control <?php cms_isset(form_error("edit_expense_date"), "is-invalid", ""); ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('edit_expense_date'); ?></div>
                                <?php } ?>
                            </div>

                            <!-- Belge No -->
                            <div class="mb-3">
                                <label class="col-form-label" for="edit_bill_code">Belge No:</label>
                                <input id="edit_bill_code" type="text"
                                       class="form-control <?php cms_isset(form_error("edit_bill_code"), "is-invalid", ""); ?>"
                                       name="edit_bill_code"
                                       value="<?php echo isset($form_error) ? set_value("edit_bill_code") : "$edit_expense->bill_code"; ?>"
                                       placeholder="Belge No">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('edit_bill_code'); ?></div>
                                <?php } ?>
                            </div>

                            <!-- Tutar -->
                            <div class="mb-3">
                                <label class="col-form-label" for="edit_price">Tutar:</label>
                                <input id="edit_price" type="number" min="0" step="any"
                                       class="form-control <?php cms_isset(form_error("edit_price"), "is-invalid", ""); ?>"
                                       name="edit_price"
                                       value="<?php cms_isset(form_error("edit_price"), set_value("edit_price"), $edit_expense->price); ?>"
                                       placeholder="Tutar">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('edit_price'); ?></div>
                                <?php } ?>
                            </div>

                            <!-- Ödeme Türü -->
                            <div class="mb-3">
                                <label class="col-form-label" for="edit_payment_type">Ödeme Türü:</label>
                                <select id="edit_select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("edit_payment_type"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="edit_payment_type">

                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? cms_if_echo(set_value("edit_payment_type"), null, "", set_value("edit_payment_type")) : $edit_expense->payment_type; ?>">
                                        <?php echo isset($form_error) ? cms_if_echo(set_value("edit_payment_type"), null, "Seçiniz", set_value("edit_payment_type")) : $edit_expense->payment_type; ?>
                                    </option>

                                    <!-- Dynamic site options -->
                                    <option>Nakit</option>
                                    <option>Havale</option>
                                    <option>Kredi Kartı</option>
                                    <option>Diğer</option>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('edit_payment_type'); ?></div>
                                <?php } ?>
                            </div>

                            <!-- Açıklama -->
                            <div class="mb-3">
                                <label class="col-form-label" for="edit_expense_notes">Açıklama:</label>
                                <input id="edit_expense_notes" type="text"
                                       class="form-control <?php cms_isset(form_error("edit_expense_notes"), "is-invalid", ""); ?>"
                                       name="edit_expense_notes"
                                       value="<?php echo isset($form_error) ? set_value("edit_expense_notes") : "$edit_expense->note"; ?>"
                                       placeholder="Açıklama">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('edit_expense_notes'); ?></div>
                                <?php } ?>
                            </div>


                            <?php

                            $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet";

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
                            if (in_array($edit_expense->id, $file_names_without_extension)) { ?>
                                <div id="file-upload-container">
                                    <a href="<?php echo base_url("$this->Module_Name/sitewallet_file_download/$edit_expense->id"); ?>">
                                        <i class="fa fa-download f-14 ellips"></i> Dosyayı İndir
                                    </a>
                                    <span onclick="delete_file(this)"
                                          data-url="<?php echo base_url("$this->Module_Name/sitewallet_file_delete/$edit_expense->id"); ?>">
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
                                onclick="submit_modal_form('editExpenseForm', 'EditExpenseModal', 'tab_expenses', 'expensesTable')">
                            Gönder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>