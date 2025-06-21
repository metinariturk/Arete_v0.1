<div class="card-body">
    <div class="repeater">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Çalışan Makineler</h5>
            <button data-repeater-create type="button"
                    class="btn btn-primary btn-sm d-flex align-items-center">
                <i class="fa fa-plus me-1"></i> Makine Ekle
            </button>
        </div>
        <div data-repeater-list="workmachines" class="mb-3 border rounded p-3">
            <?php if (!empty($workmachine_filter)) { ?>
                <?php foreach ($workmachine_filter as $workmachine_return) { ?>
                    <div data-repeater-item>
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-2 mb-2">
                                <select class="form-control" name="workmachine">
                                    <option value="">İş Makinesi Seçiniz</option>
                                    <?php foreach ($active_machines as $active_machine_group => $machines) {
                                        foreach ($machines as $machine) { ?>
                                            <option value="<?php echo $machine; ?>" <?php echo ($workmachine_return["workmachine"] == $machine) ? "selected" : ""; ?>>
                                                <?php echo machine_name($machine); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 col-md-1 mb-2">
                                <input type="number" min="1" step="any" class="form-control"
                                       name="machine_count"
                                       value="<?php echo $workmachine_return["machine_count"]; ?>"
                                       placeholder="Sayısı">
                            </div>
                            <div class="col-sm-3 col-md-2 mb-2">
                                <input type="text" class="form-control" name="machine_place"
                                       value="<?php echo $workmachine_return["machine_place"]; ?>"
                                       placeholder="Mahal">
                            </div>
                            <div class="col-sm-5 col-md-4 mb-2">
                                <input type="text" class="form-control" name="machine_notes"
                                       value="<?php echo $workmachine_return["machine_notes"]; ?>"
                                       placeholder="Açıklama">
                            </div>
                            <div class="col-sm-5 col-md-2 mb-2">
                                <input type="number" class="form-control" name="machine_production"
                                       value="<?php echo $workmachine_return["machine_production"]; ?>"
                                       placeholder="İmalat Miktar">
                            </div>
                            <div class="col-sm-1 col-md-1 text-end">
                                <button data-repeater-delete type="button"
                                        class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div data-repeater-item>
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-md-2 mb-2">
                            <select class="form-control" name="workmachine">
                                <option selected value="">İş Makinesi Seçiniz</option>
                                <?php foreach ($active_machines as $active_machine_group => $machines) {
                                    foreach ($machines as $machine) { ?>
                                        <option value="<?php echo $machine; ?>">
                                            <?php echo machine_name($machine); ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-1 mb-2">
                            <input type="number" min="1" step="any" class="form-control" name="machine_count"
                                   placeholder="Sayısı">
                        </div>
                        <div class="col-sm-3 col-md-2 mb-2">
                            <input type="text" class="form-control" name="machine_place" placeholder="Mahal">
                        </div>
                        <div class="col-sm-5 col-md-4 mb-2">
                            <input type="text" class="form-control" name="machine_notes" placeholder="Açıklama">
                        </div>
                        <div class="col-sm-5 col-md-2 mb-2">
                            <input type="number" class="form-control" name="machine_production"
                                   placeholder="İmalat Miktar">
                        </div>
                        <div class="col-sm-1 col-md-1 text-end">
                            <button data-repeater-delete type="button"
                                    class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
