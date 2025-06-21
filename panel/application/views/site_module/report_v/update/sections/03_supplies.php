<div class="card-body">
    <div class="repeater">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Gelen Malzemeler</h5>
            <button data-repeater-create type="button"
                    class="btn btn-primary btn-sm d-flex align-items-center">
                <i class="fa fa-plus me-1"></i> Malzeme Ekle
            </button>
        </div>
        <div data-repeater-list="supplies" class="mb-3 border rounded p-3">
            <?php if (!empty($supplies)) { ?>
                <?php foreach ($supplies as $supply_return) { ?>
                    <div data-repeater-item class="row align-items-center">
                        <div class="col-sm-4 col-md-3 mb-2">
                            <input type="text" class="form-control" name="supply" placeholder="Malzeme Adı"
                                   value="<?php echo htmlspecialchars($supply_return->supply ?? ''); ?>">
                        </div>

                        <div class="col-sm-4 col-md-2 mb-2">
                            <input type="number" min="1" step="any" class="form-control" name="qty"
                                   placeholder="Miktar"
                                   value="<?php echo htmlspecialchars($supply_return->qty ?? ''); ?>">
                        </div>

                        <div class="col-sm-2 col-md-2 mb-2">
                            <select style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("unit"), "is-invalid", ""); ?>"
                                    name="unit">
                                <option value="">Birimi Seçin</option>
                                <?php foreach ((get_as_array($this->settings->units)) as $unit) { ?>
                                    <option value="<?php echo htmlspecialchars($supply_return->unit ?? ''); ?>">
                                        <?php echo htmlspecialchars($supply_return->unit ?? ''); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-sm-10 col-md-4 mb-2">
                            <input type="text" class="form-control" name="supply_notes" placeholder="Açıklama"
                                   value="<?php echo htmlspecialchars($supply_return->notes ?? ''); ?>">
                        </div>

                        <div class="col-sm-1 col-md-1 text-end">
                            <button data-repeater-delete type="button" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div data-repeater-item class="row align-items-center">
                    <div class="col-sm-4 col-md-3 mb-2">
                        <input type="text" class="form-control" name="supply" placeholder="Malzeme Adı">
                    </div>

                    <div class="col-sm-4 col-md-2 mb-2">
                        <input type="number" min="1" step="any" class="form-control" name="qty"
                               placeholder="Miktar">
                    </div>

                    <div class="col-sm-2 col-md-2 mb-2">
                        <select style="width: 100%;"
                                class="form-control <?php cms_isset(form_error("unit"), "is-invalid", ""); ?>"
                             name="unit">
                            <option value="">Birimi Seçin</option>
                            <?php foreach ((get_as_array($this->settings->units)) as $unit) { ?>
                                <option value="<?php echo $unit; ?>">
                                    <?php echo $unit; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-10 col-md-4 mb-2">
                        <input type="text" class="form-control" name="supply_notes" placeholder="Açıklama">
                    </div>

                    <div class="col-sm-1 col-md-1 text-end">
                        <button data-repeater-delete type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>