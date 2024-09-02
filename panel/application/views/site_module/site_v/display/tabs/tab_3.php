<div class="fade tab-pane <?php if ($active_tab == "sitestock") {
    echo "active show";
} ?>"
     id="sitestock" role="tabpanel"
     aria-labelledby="sitestock-tab">
    <div class="card mb-0">
        <div class="card-body">
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#AddStockModal">Yeni Stok Ekle</button>

            <div class="modal fade" id="AddStockModal" tabindex="-1" aria-labelledby="AddStockModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Stok Girişi</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addStockForm" action="<?php echo base_url('Site/add_stock/' . $item->id); ?>" method="POST">
                                <div class="mb-3">
                                    <label for="stock_name" class="form-label">Stok Adı</label>
                                    <input type="text" class="form-control" id="stock_name" name="stock_name" placeholder="Stok Adı" required>
                                </div>
                                <div class="mb-3">
                                    <label for="stock_in" class="form-label">Giriş Miktarı</label>
                                    <input type="number" class="form-control" id="stock_in" name="stock_in" placeholder="Giriş Miktarı" required>
                                </div>
                                <div class="mb-3">
                                    <label for="unit" class="form-label">Birim</label>
                                    <input type="text" class="form-control" id="unit" name="unit" placeholder="Birim" required>
                                </div>
                                <div class="mb-3">
                                    <label for="arrival_date" class="form-label">Geliş Tarihi</label>
                                    <input type="text" class="form-control datepicker-here" id="arrival_date" name="arrival_date" data-options="{ format: 'DD-MM-YYYY' }" data-language="tr">
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Açıklama</label>
                                    <input type="text" class="form-control" id="notes" name="notes" placeholder="Açıklama">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                                    <button class="btn btn-primary" type="submit">Gönder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/sitestock"); ?>
        </div>
    </div>
</div>