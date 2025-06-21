<div class="card-body">
    <div class="repeater">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Çalışan Ekipler</h5>
            <button data-repeater-create type="button"
                    class="btn btn-primary btn-sm d-flex align-items-center">
                <i class="fa fa-plus me-1"></i> Ekip Ekle
            </button>
        </div>
        <div data-repeater-list="workgroups" class="mb-3 border rounded p-3">
            <?php if (!empty($workgroups)) { ?>
                <?php foreach ($workgroups as $workgroup_return) { ?>
                    <div data-repeater-item>
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-2 mb-2">
                                <select class="form-control" name="workgroup">
                                    <option value="">İş Grubu Seçiniz</option>
                                    <?php foreach ($active_workgroups as $active_workgroup => $workgroups_inner) { // Değişken adı çakışmasın diye $workgroups_inner yaptım
                                        foreach ($workgroups_inner as $workgroup) { ?>
                                            <option value="<?php echo $workgroup; ?>" <?php echo ($workgroup_return->workgroup == $workgroup) ? "selected" : ""; ?>>
                                                <?php echo group_name($workgroup); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 col-md-1 mb-2">
                                <input type="number" min="1" step="any" class="form-control"
                                       name="worker_count"
                                       value="<?php echo $workgroup_return->number; ?>"
                                       placeholder="Sayısı">
                            </div>
                            <div class="col-sm-3 col-md-2 mb-2">
                                <input type="text" class="form-control" name="place"
                                       value="<?php echo $workgroup_return->place; ?>"
                                       placeholder="Mahal">
                            </div>
                            <div class="col-sm-5 col-md-4 mb-2">
                                <input type="text" class="form-control" name="notes"
                                       value="<?php echo $workgroup_return->notes; ?>"
                                       placeholder="Açıklama">
                            </div>
                            <div class="col-sm-5 col-md-2 mb-2">
                                <input type="number" class="form-control" name="production"
                                       value="<?php echo $workgroup_return->production; ?>"
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
                <div data-repeater-item>
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-md-2 mb-2">
                            <select class="form-control" name="workgroup">
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
                            <input type="number" class="form-control" name="production"
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
