<div class="modal fade" id="AddStockModal" tabindex="-1" aria-labelledby="AddStockModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Stok Girişi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStockForm" data-form-url="<?php echo base_url('Site/add_stock/' . $item->id); ?>" method="post">
                    <div class="mb-3">
                        <label for="stock_name" class="form-label">Stok Adı</label>
                        <input type="text" class="form-control" id="stock_name" name="stock_name"
                               placeholder="Stok Adı" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock_in" class="form-label">Giriş Miktarı</label>
                        <input type="number" class="form-control" id="stock_in" name="stock_in"
                               placeholder="Giriş Miktarı" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Birim</label>
                        <input type="text" class="form-control" id="unit" name="unit" placeholder="Birim"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="arrival_date" class="form-label">Geliş Tarihi</label>
                        <input type="text" class="form-control datepicker-here" id="arrival_date"
                               name="arrival_date" data-options="{ format: 'DD-MM-YYYY' }" data-language="tr">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Açıklama</label>
                        <input type="text" class="form-control" id="notes" name="notes" placeholder="Açıklama">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary"
                                onclick="submit_modal_form('addStockForm', 'tab_3_sitestock', 'AddStockModal', 'stock-table')">Gönder
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
                <div class="mb-3">
                    <strong>Stok ID:</strong> <span id="stock-id-display"></span>
                </div>
                <form id="exitStockForm" data-form-url="<?php echo base_url('Site/exit_stock/' . $item->id); ?>" method="post">
                    <input hidden="" name="stock_id" id="stock_id">
                    <div class="mb-3">
                        <label for="exit_date" class="form-label">Transfer Bölgesi</label>
                        <select class="form-control" name="transfer">
                            <?php foreach ($sites as $site) {
                                if ($site->id != $item->id) { ?>
                                    <option value="<?php echo $site->id; ?>"><?php echo $site->santiye_ad; ?></option>
                                <?php }
                            } ?>
                            <option>Depo</option>
                            <option value="0">Fire</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stock_out" class="form-label">Çıkış Miktarı</label>
                        <input type="number" class="form-control" id="stock_out" name="stock_out"
                               placeholder="Çıkış Miktarı" required>
                    </div>
                    <div class="mb-3">
                        <label for="exit_date" class="form-label">Çıkış Tarihi</label>
                        <input type="text" class="form-control datepicker-here" id="exit_date" name="exit_date"
                               data-options="{ format: 'DD-MM-YYYY' }" data-language="tr">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Açıklama</label>
                        <input type="text" class="form-control" id="notes" name="notes" placeholder="Açıklama">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary"
                                onclick="submit_modal_form('exitStockForm', 'tab_3_sitestock', 'ExitModal', 'stock-table')">Gönder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="tab_3_sitestock">
    <div class="tabs">
        <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
            <h5>Depo/Stok Listesi</h5>
        </div>
    </div>
    <hr>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tables/table_3_sitestock"); ?>
</div>
