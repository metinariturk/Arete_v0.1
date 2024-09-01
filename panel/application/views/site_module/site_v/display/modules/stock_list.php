<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
    Stok Ekle
</button>

<!-- Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">Yeni Stok Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-stock-form" action="<?php echo base_url('Site/add_stock/'.$item->id); ?>" method="post">
                    <div class="row mb-2">
                        <!-- Stock Name -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text col-form-label">Stok Adı</span>
                                <input type="text"
                                       class="form-control <?php cms_isset(form_error('stock_name'), 'is-invalid', ''); ?>"
                                       placeholder="Stok Adı"
                                       value="<?php echo isset($form_error) ? set_value('stock_name') : ''; ?>"
                                       name="stock_name">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('stock_name'); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Unit -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text col-form-label">Birim</span>
                                <input type="text"
                                       class="form-control <?php cms_isset(form_error('unit'), 'is-invalid', ''); ?>"
                                       placeholder="Birim"
                                       value="<?php echo isset($form_error) ? set_value('unit') : ''; ?>"
                                       name="unit">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('unit'); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text col-form-label">Giriş Miktarı</span>
                                <input type="number"
                                       class="form-control <?php cms_isset(form_error('stock_in'), 'is-invalid', ''); ?>"
                                       placeholder="Giriş Miktarı"
                                       value="<?php echo isset($form_error) ? set_value('stock_in') : ''; ?>"
                                       name="stock_in">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('stock_in'); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Stock Out -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text col-form-label">Geliş Tarihi</span>
                                <input class="datepicker-here form-control digits <?php cms_isset(form_error('arrival_date'), 'is-invalid', ''); ?>"
                                       type="text"
                                       name="arrival_date"
                                       value="<?php echo isset($form_error) ? set_value('arrival_date') : ''; ?>"
                                       data-options="{ format: 'DD-MM-YYYY' }"
                                       data-language="tr">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('arrival_date'); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <!-- Stock Name -->
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text col-form-label">Açıklama</span>
                                <input type="text"
                                       class="form-control <?php cms_isset(form_error('notes'), 'is-invalid', ''); ?>"
                                       placeholder="Satın Alınan, Transfer Edilen vs."
                                       value="<?php echo isset($form_error) ? set_value('notes') : ''; ?>"
                                       name="notes">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error('notes'); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <!-- Buttons -->
                        <div class="col-md-6">
                            <a class="pager-btn btn btn-info btn-outline"
                               onclick="return add_stock(this);"
                               form_id="add-stock-form"
                               url="<?php echo base_url('Site/add_stock/'.$item->id); ?>"
                               href="#">
                                <i class="menu-icon fa fa-plus" aria-hidden="true"></i> Yeni Malzeme Girişi
                            </a>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Formu Temizle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container table-container">
    <h2>Stok Listesi</h2>
    <table class="table table-bordered table-striped" id="stock-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Stok Adı</th>
            <th>Birim</th>
            <th>Miktarı</th>
            <th>Tarihi</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($site_stocks as $site_stock) { ?>
            <tr data-id="<?php echo $site_stock->id; ?>">
                <td><?php echo $site_stock->id; ?></td>
                <td><?php echo $site_stock->stock_name; ?></td>
                <td><?php echo $site_stock->unit; ?></td>
                <td><?php echo $site_stock->stock_in; ?></td>
                <td><?php echo $site_stock->arrival_date; ?></td>
                <td>
                    <button class="btn btn-primary exit-btn" data-id="<?php echo $site_stock->id; ?>"
                            data-stock_name="<?php echo $site_stock->stock_name; ?>"
                            data-unit="<?php echo $site_stock->unit; ?>"
                            data-stock_in="<?php echo $site_stock->stock_in; ?>">Malzeme Çıkış Yap
                    </button>
                </td>
            </tr>
            <tr data-id="<?php echo $site_stock->id; ?>">
                <td colspan="3"><?php echo $site_stock->notes; ?></td>
            </tr>
            <?php $stock_movements = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => $site_stock->id)); ?>
            <?php foreach ($stock_movements as $stock_movement) { ?>
                <tr>
                    <td colspan="3"><?php echo $stock_movement->notes; ?></td>
                    <td> - <?php echo $stock_movement->stock_out; ?></td>
                    <td><?php echo dateFormat_dmy($stock_movement->exit_date); ?></td>
                    <td>
                        <button class="btn btn-primary">Sil
                        </button>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>
