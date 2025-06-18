<form id="reportForm" method="post"
      autocomplete="off">

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <!-- Çalışma Var / Çalışma Yok Switch -->
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="d-flex align-items-center">
                            <span class="mb-0 me-2">Çalışma Yok</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="off_days" id="off_days" value="1"
                                       checked>
                            </div>
                            <span class="mb-0 ms-2">Çalışma Var</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <!-- Rapor Tarihi -->
                <div class="row justify-content-center">
                    <div class="col-5">
                        <div class="mb-2">
                            <div class="col-form-label">Rapor Tarihi</div>
                            <input class="flatpickr form-control <?php cms_isset(form_error("report_date"), "is-invalid", ""); ?>"
                                   type="text" id="flatpickr"
                                   name="report_date"
                                   value="<?php echo isset($form_error) ? set_value("report_date") : ""; ?>"
                            >
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("report_date"); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="work_sections">
            <div class="card-body">
                <div class="repeater">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Çalışan Ekipler</h5>
                        <button data-repeater-create type="button"
                                class="btn btn-primary btn-sm d-flex align-items-center">
                            <i class="fa fa-plus me-1"></i> Ekip Ekle
                        </button>
                    </div>
                    <div data-repeater-list="workgroups">
                        <?php if (!empty($workgroups_filter)) { ?>
                            <?php foreach ($workgroups_filter as $workgroup_return) { ?>
                                <div data-repeater-item class="mb-3 border rounded p-3">
                                    <div class="row align-items-center">
                                        <div class="col-sm-4 col-md-2 mb-2">
                                            <select class="form-control" data-plugin="select2" name="workgroup">
                                                <option value="">İş Grubu Seçiniz</option>
                                                <?php foreach ($active_workgroups as $active_workgroup => $workgroups) {
                                                    foreach ($workgroups as $workgroup) { ?>
                                                        <option value="<?php echo $workgroup; ?>" <?php echo ($workgroup_return["workgroup"] == $workgroup) ? "selected" : ""; ?>>
                                                            <?php echo group_name($workgroup); ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 col-md-1 mb-2">
                                            <input type="number" min="1" step="any" class="form-control"
                                                   name="worker_count"
                                                   value="<?php echo $workgroup_return["worker_count"]; ?>"
                                                   placeholder="Sayısı">
                                        </div>
                                        <div class="col-sm-3 col-md-2 mb-2">
                                            <input type="text" class="form-control" name="place"
                                                   value="<?php echo $workgroup_return["place"]; ?>"
                                                   placeholder="Mahal">
                                        </div>
                                        <div class="col-sm-5 col-md-4 mb-2">
                                            <input type="text" class="form-control" name="notes"
                                                   value="<?php echo $workgroup_return["notes"]; ?>"
                                                   placeholder="Açıklama">
                                        </div>
                                        <div class="col-sm-5 col-md-2 mb-2">
                                            <input type="text" class="form-control" name="production"
                                                   value="<?php echo $workgroup_return["production"]; ?>"
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
                            <!-- Hiç veri yoksa boş bir item göster -->
                            <div data-repeater-item class="mb-3 border rounded p-3">
                                <div class="row align-items-center">
                                    <div class="col-sm-4 col-md-2 mb-2">
                                        <select class="form-control" data-plugin="select2" name="workgroup">
                                            <option selected value="">İş Grubu Seçiniz</option>
                                            <?php foreach ($active_workgroups as $active_workgroup => $workgroups) {
                                                foreach ($workgroups as $workgroup) { ?>
                                                    <option value="<?php echo $workgroup; ?>">
                                                        <?php echo group_name($workgroup); ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-1 mb-2">
                                        <input type="number" min="1" step="any" class="form-control" name="worker_count"
                                               placeholder="Sayısı">
                                    </div>
                                    <div class="col-sm-3 col-md-2 mb-2">
                                        <input type="text" class="form-control" name="place" placeholder="Mahal">
                                    </div>
                                    <div class="col-sm-5 col-md-4 mb-2">
                                        <input type="text" class="form-control" name="notes" placeholder="Açıklama">
                                    </div>
                                    <div class="col-sm-5 col-md-2 mb-2">
                                        <input type="text" class="form-control" name="production"
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
            <div class="card-body">
                <div class="repeater">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Çalışan Makineler</h5>
                        <button data-repeater-create type="button"
                                class="btn btn-primary btn-sm d-flex align-items-center">
                            <i class="fa fa-plus me-1"></i> Makine Ekle
                        </button>
                    </div>
                    <div data-repeater-list="workmachines">
                        <?php if (!empty($workmachine_filter)) { ?>
                            <?php print_r($workmachine_filter); ?>
                            <?php foreach ($workmachine_filter as $workmachine_return) { ?>
                                <div data-repeater-item class="mb-3 border rounded p-3">
                                    <div class="row align-items-center">
                                        <div class="col-sm-4 col-md-2 mb-2">
                                            <select class="form-control" data-plugin="select2" name="workmachine">
                                                <option value="">İş Makinesi Seçiniz</option>
                                                <?php foreach ($active_machines as $active_machine => $workmachines) {
                                                    foreach ($workmachines as $workmachine) { ?>
                                                        <option value="<?php echo $workmachine; ?>"
                                                            <?php echo ($workmachine == $workmachine_return["workmachine"]) ? 'selected' : ''; ?>>
                                                            <?php echo machine_name($workmachine); ?>
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
                            <!-- Hiç veri yoksa boş bir item göster -->
                            <div data-repeater-item class="mb-3 border rounded p-3">
                                <div class="row align-items-center">
                                    <div class="col-sm-4 col-md-3 mb-2">
                                        <select class="form-control" data-plugin="select2" name="workmachine">
                                            <option selected value="">İş Makinesi Seçiniz</option>
                                            <?php foreach ($active_machines as $active_machine => $workmachines) {
                                                foreach ($workmachines as $workmachine) { ?>
                                                    <option value="<?php echo $workmachine; ?>">
                                                        <?php echo machine_name($workmachine); ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-2 mb-2">
                                        <input type="number" min="1" step="any" class="form-control"
                                               name="machine_count"
                                               placeholder="Sayısı">
                                    </div>
                                    <div class="col-sm-4 col-md-3 mb-2">
                                        <input type="text" class="form-control" name="machine_place"
                                               placeholder="Mahal">
                                    </div>
                                    <div class="col-sm-10 col-md-3 mb-2">
                                        <input type="text" class="form-control" name="machine_notes"
                                               placeholder="Açıklama">
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
            <div class="card-body">
                <div class="repeater">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Gelen Malzemeler</h5>
                        <button data-repeater-create type="button"
                                class="btn btn-primary btn-sm d-flex align-items-center">
                            <i class="fa fa-plus me-1"></i> Malzeme Ekle
                        </button>
                    </div>
                    <div data-repeater-list="supplies">
                        <div data-repeater-item class="mb-3 border rounded p-3">
                            <div class="row align-items-center">
                                <div class="col-sm-4 col-md-3 mb-2">
                                    <input type="text" class="form-control" name="supply" placeholder="Malzeme Adı">
                                </div>

                                <div class="col-sm-4 col-md-2 mb-2">
                                    <input type="number" min="1" step="any" class="form-control" name="qty"
                                           placeholder="Miktar">
                                </div>

                                <div class="col-sm-2 col-md-2 mb-2">
                                    <input type="text" class="form-control" name="unit" placeholder="Birim">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <label>Genel Notlar</label>
                <textarea class="form-control" name="note" rows="3"><?php echo isset($form_error) ? set_value("note") : ""; ?></textarea>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" id="submitBtn">Formu Kaydet</button>
    </div>
</form>