<?php if (isset($form_error) && $form_error): ?>
    <script>
        $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
        $('body').removeClass('modal-open');
        $('body').css('overflow', 'auto');
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
                        <input type="date" name="arrival_date" id="arrival_date" value="<?php echo set_value('arrival_date'); ?>" class="form-control">

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

<div id="site_stock_modal_form">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/exit_modal_form"); ?>
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
                           onclick="open_exit_stock_form('<?php echo base_url("Site/exit_stock_form/$site_stock->id"); ?>')">
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
                           onclick="confirmDelete(<?php echo $site_stock->id; ?>, '<?php echo base_url('Site/delete_stock'); ?>', '#tab_sitestock','stock-table')"
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
                    <td>Transfer : <?php echo site_name($stock_movement->transfer); ?>
                        <br><?php echo $stock_movement->notes; ?></td> <!-- Notlar -->
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
