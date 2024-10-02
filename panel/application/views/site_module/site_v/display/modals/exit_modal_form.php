<div class="modal fade" id="ExitModal" tabindex="-1" aria-labelledby="ExitModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Stok Çıkışı - <?php echo htmlspecialchars($site_stock->stock_name, ENT_QUOTES, 'UTF-8'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exitStockForm" data-form-url="<?php echo base_url('Site/exit_stock/' . $item->id); ?>" method="post">
                    <!-- Stock ID (Only shown if stock ID is set) -->
                    <?php if (isset($site_stock->id)){ ?>
                        <input type="hidden" name="stock_id" value="<?php echo htmlspecialchars($site_stock->id, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php } ?>

                    <!-- Remaining Quantity -->
                    <div class="mb-3">
                        <label for="remaining_quantity" class="form-label">Kalan Miktar</label>
                        <p class="form-control-plaintext">
                            <?php echo $kalan = $site_stock->stock_in - sum_anything("sitestock", "stock_out", "parent_id", $site_stock->id); ?>
                        </p>
                    </div>

                    <!-- Transfer Region -->
                    <div class="mb-3">
                        <label for="transfer" class="form-label">Transfer Bölgesi</label>
                        <select id="select2-demo-1" style="width: 100%;" class="form-control <?php echo isset($form_error) ? 'is-invalid' : ''; ?>" data-plugin="select2" name="transfer">
                            <?php if (isset($form_error)) { ?>
                                <option selected value="<?php echo set_value('transfer'); ?>"><?php echo site_name(set_value('transfer')); ?></option>
                            <?php } else { ?>
                                <option value="" disabled selected>Transfer Birimi Seçiniz</option>
                            <?php } ?>
                            <!-- Dynamic site options -->
                            <?php if (!empty($sites)) { ?>
                                <?php foreach ($sites as $site) {
                                    if ($site->id != $item->id) { ?>
                                        <option value="<?php echo htmlspecialchars($site->id, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($site->santiye_ad, ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php }
                                } ?>
                            <?php } ?>
                            <option value="99999">Depo</option>
                            <option value="0">Fire</option>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('transfer'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Stock Out Quantity -->
                    <div class="mb-3">
                        <label for="stock_out" class="form-label">Çıkış Miktarı</label>
                        <input type="number" class="form-control <?php echo isset($form_error) ? 'is-invalid' : ''; ?>" value="<?php echo isset($form_error) ? set_value('stock_out') : ''; ?>" id="stock_out" name="stock_out" placeholder="Çıkış Miktarı" required>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('stock_out'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Exit Date -->
                    <div class="mb-3">
                        <label for="exit_date" class="form-label">Çıkış Tarihi</label>
                        <input type="date" name="exit_date" id="exit_date" value="<?php echo set_value('exit_date'); ?>" class="form-control">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('exit_date'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Exit Notes -->
                    <div class="mb-3">
                        <label for="exit_notes" class="form-label">Açıklama</label>
                        <input type="text" class="form-control <?php echo isset($form_error) ? 'is-invalid' : ''; ?>" value="<?php echo isset($form_error) ? set_value('exit_notes') : ''; ?>" id="exit_notes" name="exit_notes" placeholder="Açıklama">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('exit_notes'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="$('#exitStockForm')[0].reset()">Kapat</button>
                        <button type="button" class="btn btn-primary" onclick="submit_modal_form('exitStockForm', 'ExitModal', 'tab_sitestock', 'stock-table')">Gönder</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
