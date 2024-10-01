<?php if (isset($form_error) && $form_error): ?>
    <script>
        $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
        $('#<?php echo $error_modal; ?>').modal('show');

        // DataTable kontrolü ve yeniden başlatılması
        if ($.fn.DataTable.isDataTable('#stock-table')) {
            $('#stock-table').DataTable().destroy(); // Mevcut tabloyu yok et
        }

        // DataTable'ı yeniden başlat
        if (!$.fn.DataTable.isDataTable('#stock-table')) {
            $('#stock-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                // Diğer DataTable ayarları
            });
        }

        $('.datepicker-here').datepicker({
            format: 'DD-MM-YYYY',
            language: 'tr'
        });
    </script>
<?php endif; ?>
<div class="modal fade" id="AddStockModal" tabindex="-1" aria-labelledby="AddStockModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Stok Girişi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStockForm" data-form-url="<?php echo base_url('Site/add_stock/' . $item->id); ?>"
                      method="post">
                    <div class="mb-3">
                        <label for="stock_name" class="form-label">Stok Adı</label>
                        <input type="text"
                               class="form-control <?php cms_isset(form_error("stock_name"), "is-invalid", ""); ?>"
                               id="stock_name" name="stock_name"
                               placeholder="Stok Adı" required
                               value="<?php echo isset($form_error) ? set_value("stock_name") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("stock_name"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="stock_in" class="form-label">Giriş Miktarı</label>
                        <input type="number"
                               class="form-control <?php cms_isset(form_error("stock_in"), "is-invalid", ""); ?>"
                               id="stock_in" name="stock_in"
                               placeholder="Giriş Miktarı" required
                               value="<?php echo isset($form_error) ? set_value("stock_in") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("stock_in"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Birim</label>
                        <select id="select2-demo-1" style="width: 100%;"
                                class="form-control <?php cms_isset(form_error("unit"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="unit">
                            <?php if (isset($form_error)) { ?>
                                <option selected
                                        value="<?php echo set_value("unit"); ?>"><?php echo set_value("unit"); ?></option>
                            <?php } else { ?>
                                <option value="" disabled selected>Birimi Seçiniz</option> <!-- Placeholder ekledik -->
                            <?php } ?>
                            <?php foreach ((get_as_array($settings->units)) as $unit) { ?>
                                <option value="<?php echo $unit; ?>">
                                    <?php echo $unit; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("unit"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="arrival_date" class="form-label">Geliş Tarihi</label>
                        <input type="text"
                               class="form-control datepicker-here <?php cms_isset(form_error("arrival_date"), "is-invalid", ""); ?>"
                               id="arrival_date"
                               value="<?php echo isset($form_error) ? set_value("arrival_date") : ""; ?>"
                               name="arrival_date" data-options="{ format: 'DD-MM-YYYY' }" data-language="tr">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("arrival_date"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Açıklama</label>
                        <input type="text" value="<?php echo isset($form_error) ? set_value("notes") : ""; ?>"
                               class="form-control <?php cms_isset(form_error("notes"), "is-invalid", ""); ?>"
                               id="notes" name="notes" placeholder="Açıklama">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("notes"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary"
                                onclick="submit_modal_form('addStockForm', 'AddStockModal', 'tab_sitestock', 'stock-table')">
                            Gönder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ExitModal" tabindex="-1" aria-labelledby="ExitModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Stok Çıkışı</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exitStockForm" data-form-url="<?php echo base_url('Site/exit_stock/' . $item->id); ?>" method="post">
                    <input name="stock_id" id="stock_id"  value="<?php echo isset($form_error) ? $stock_id : ""; ?>">

                    <div class="mb-3">
                        <label for="transfer" class="form-label">Transfer Bölgesi</label>
                        <select id="select2-demo-1" style="width: 100%;"
                                class="form-control <?php cms_isset(form_error("transfer"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="transfer">
                            <?php if (isset($form_error)) { ?>
                                <option selected
                                        value="<?php echo set_value("transfer"); ?>"><?php echo site_name(set_value("transfer")); ?></option>
                            <?php } else { ?>
                                <option value="" disabled selected>Transfer Birimi Seçiniz</option> <!-- Placeholder ekledik -->
                            <?php } ?>
                            <?php if (!empty($sites)) { // $sites dizisi boş değilse ?>
                                <?php foreach ($sites as $site) {
                                    if ($site->id != $item->id) { ?>
                                        <option value="<?php echo $site->id; ?>"><?php echo $site->santiye_ad; ?></option>
                                    <?php }
                                } ?>
                            <?php } ?>
                            <option value="99999">Depo</option>
                            <option value="0">Fire</option>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("transfer"); ?></div>

                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <label for="stock_out" class="form-label">Çıkış Miktarı</label>
                        <input type="number" class="form-control <?php cms_isset(form_error('stock_out'), 'is-invalid', ''); ?>"
                               value="<?php echo isset($form_error) ? set_value("stock_out") : ""; ?>"
                               id="stock_out" name="stock_out" placeholder="Çıkış Miktarı" required>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('stock_out'); ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <label for="exit_date" class="form-label">Çıkış Tarihi</label>
                        <input type="text" class="form-control <?php cms_isset(form_error('exit_date'), 'is-invalid', ''); ?> datepicker-here"
                               value="<?php echo isset($form_error) ? set_value("exit_date") : ""; ?>"
                               id="exit_date" name="exit_date" data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('exit_date'); ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <label for="exit_notes" class="form-label">Açıklama</label>
                        <input type="text" class="form-control <?php cms_isset(form_error('exit_notes'), 'is-invalid', ''); ?>"
                               value="<?php echo isset($form_error) ? set_value("exit_notes") : ""; ?>"
                               id="exit_notes" name="exit_notes" placeholder="Açıklama">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('exit_notes'); ?></div>
                        <?php } ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="$('#exitStockForm')[0].reset()">Kapat</button>
                        <button type="button" class="btn btn-primary"
                                onclick="submit_modal_form('exitStockForm', 'ExitModal', 'tab_sitestock', 'stock-table')">
                            Gönder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="tabs">
    <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
        <h5>Depo/Stok Listesi</h5>
    </div>
</div>
<hr>
<div id="table-responsive">
    <table id="stock-table">
        <thead>
        <tr>
            <th>#</th>
            <th>İşlem</th>
            <th>Stok Adı</th>
            <th>Birim</th>
            <th>Miktarı</th>
            <th>Kalan</th>
            <th>Tarihi</th>
            <th>Açıklama</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($site_stocks as $site_stock): ?>
            <?php
            $kalan = $site_stock->stock_in - sum_anything("sitestock", "stock_out", "parent_id", "$site_stock->id");
            ?>
            <tr>
                <td>
                    <?php if ($kalan > 0): ?>
                        <a data-bs-toggle="modal" class="text-primary"
                           onclick="open_exit_stock_form('<?php echo $site_stock->id; ?>', 'ExitModal')">
                            <i class="fa fa-sign-out fa-2x"></i>
                        </a>
                    <?php else: ?>
                        <i class="fa fa-sign-out fa-2x" onclick="empty_stock()"></i>
                    <?php endif; ?>
                </td>
                <td>
                    <?php $is_parent = $this->Sitestock_model->get(array("parent_id" => $site_stock->id)); ?>
                    <?php if (empty($is_parent)): ?>
                        <a href="javascript:void(0);"
                           onclick="confirmDelete(<?php echo $site_stock->id; ?>, '<?php echo base_url('Site/delete_stock'); ?>', '#site_stock_table')"
                           title="Sil">
                            <i class="fa fa-trash-o fa-2x"></i>
                        </a>
                    <?php else: ?>
                        <i class="fa fa-trash-o fa-2x" onclick="delete_stock_enter()"></i>
                    <?php endif; ?>
                </td>
                <td><?php echo $site_stock->stock_name; ?></td>
                <td><?php echo $site_stock->unit; ?></td>
                <td><?php echo $site_stock->stock_in; ?></td>
                <td><?php echo number_format($kalan); ?></td>
                <td><?php echo $site_stock->arrival_date; ?></td>
                <td>
                    <?php if (!empty($site_stock->site_from)): ?>
                        <?php echo site_name($site_stock->site_from); ?> Şantiyesinden Transfer
                    <?php endif; ?>
                    <?php echo $site_stock->notes; ?>
                </td>
            </tr>

            <!-- Child Row'ları Burada Oluştur -->
            <?php
            $stock_movements = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => $site_stock->id));
            foreach ($stock_movements as $stock_movement): ?>
                <tr>
                    <td></td> <!-- Boş sütun -->
                    <td>
                        <a href="javascript:void(0);"
                           onclick="confirmDelete(<?php echo $stock_movement->id; ?>, '<?php echo base_url('Site/delete_stock'); ?>', '#site_stock_table')"
                           title="Sil">
                            <i class="fa fa-trash-o fa-2x"></i>
                        </a>
                    </td>
                    <td></td> <!-- Boş sütun -->
                    <td></td> <!-- Boş sütun -->
                    <td style="color: #f16352">- <?php echo $stock_movement->stock_out; ?></td>
                    <td></td> <!-- Boş sütun -->
                    <td><?php echo dateFormat_dmy($stock_movement->exit_date); ?></td>
                    <td>Transfer : <?php echo site_name($stock_movement->transfer); ?>  <br><?php echo $stock_movement->notes; ?></td> <!-- Notlar -->
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
