

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
                <form id="exitStockForm" action="<?php echo base_url('Site/exit_stock/' . $item->id); ?>" method="POST">
                    <input type="hidden" name="stock_id" id="stock_id">
                    <div class="mb-3">
                        <label for="stock_out" class="form-label">Çıkış Miktarı</label>
                        <input type="number" class="form-control" id="stock_out" name="stock_out" placeholder="Çıkış Miktarı" required>
                    </div>
                    <div class="mb-3">
                        <label for="exit_date" class="form-label">Çıkış Tarihi</label>
                        <input type="text" class="form-control datepicker-here" id="exit_date" name="exit_date" data-options="{ format: 'DD-MM-YYYY' }" data-language="tr">
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

<div id="responseMessage" class="mt-3">
    <h2>Stok Listesi</h2>
    <table class="table table-bordered table-striped" id="stock-table">
        <thead>
        <tr>
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
        <?php foreach ($site_stocks as $site_stock) { ?>
            <tr>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ExitModal" data-id="<?php echo $site_stock->id; ?>">
                        <i class="fa fa-sign-out"></i>
                    </button>
                </td>
                <td><?php echo $site_stock->stock_name; ?></td>
                <td><?php echo $site_stock->unit; ?></td>
                <td><?php echo $site_stock->stock_in; ?></td>
                <td><?php echo number_format($site_stock->stock_in-sum_anything("sitestock","stock_out","parent_id","$site_stock->id")); ?></td>
                <td><?php echo $site_stock->arrival_date; ?></td>
                <td><?php echo $site_stock->notes; ?></td>
            </tr>
            <?php $stock_movements = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => $site_stock->id)); ?>
            <?php foreach ($stock_movements as $stock_movement) { ?>
                <tr>
                    <td colspan="3"><?php echo $stock_movement->notes; ?></td>
                    <td> - <?php echo $stock_movement->stock_out; ?></td>
                    <td></td>
                    <td><?php echo dateFormat_dmy($stock_movement->exit_date); ?></td>
                    <td>
                        <button class="btn btn-primary">Sil</button>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>