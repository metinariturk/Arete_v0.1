<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">Dosya No</div>
                    <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">GR</span>
                        <?php if (!empty(get_last_fn("report"))) { ?>
                            <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                   type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                   data-bs-original-title="" title="" name="dosya_no" required readonly
                                   value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("report"); ?>">
                            <?php
                        } else { ?>
                            <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                   type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                                   required="" data-bs-original-title="" title="" name="dosya_no" readonly
                                   value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">Rapor Tarihi</div>
                    <input class="datepicker-here form-control digits"
                           type="text" required
                           name="report_date"
                           value="<?php echo date('d-m-Y'); ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">

                </div>
            </div>
            <div class="col-sm-4 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">En Düşük °C</div>
                    <input type="number" min="-40" max="50" step="1" onblur=""
                           class="form-control"
                           name="min_temp">
                </div>
            </div>
            <div class="col-sm-4 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">En Yüksek °C</div>
                    <input type="number" min="-40" max="50" step="1" onblur=""
                           class="form-control"
                           name="max_temp">
                </div>
            </div>
            <div class="col-sm-4 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">Olay</div>
                    <select id="select2-demo-1" class="form-control"  data-plugin="select2"
                            name="event">
                        <option selected="selected">Seçiniz</option>
                        <option>Açık</option>
                        <option>Kapalı</option>
                        <option>Sağanak Yağışlı</option>
                        <option>Yağmurlu</option>
                        <option>Kar Yağışlı</option>
                        <option>Sisli</option>
                        <option>Rüzgarlı</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">Çalışamayan Gün</div>
                    <input name="off_days" type="checkbox" value="0" >
                </div>
            </div>
        </div>
        <hr>
        <div class="row box-col-3">
            <div class="repeater">
                <div class="container">
                    <div class="row">
                        <div class="col-11">
                            <h5>Çalışan Ekipler
                                <button data-repeater-create type="button" class="btn btn-success add_btn">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </h5>
                        </div>
                        <div class="col-1">

                        </div>
                    </div>
                </div>
                <div data-repeater-list="workgroups">
                    <div data-repeater-item>
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="mb-2">
                                    <select id="select2-demo-1" class="form-control"
                                            data-plugin="select2" name="workgroup">
                                        <option selected="selected[]" value="">İş Grubu Seçiniz
                                        </option>
                                        <?php foreach ($active_workgroups as $active_workgroup => $workgroups) {
                                            foreach ($workgroups as $workgroup) { ?>
                                                <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-2">
                                <div class="mb-2">
                                    <input type="number" min="1" step="any" class="form-control"
                                           name="worker_count" placeholder="Sayısı">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="place" placeholder="Mahal">
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="notes" placeholder="Açıklama">
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="mb-2">
                                    <button data-repeater-delete type="button" class="btn btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row box-col-3">
            <div class="repeater">
                <div class="container">
                    <div class="row">
                        <div class="col-11">
                            <h5>Çalışan Makineler
                                <button data-repeater-create type="button" class="btn btn-success add_btn">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </h5>
                        </div>
                        <div class="col-1">

                        </div>
                    </div>
                </div>
                <div data-repeater-list="workmachine">
                    <div data-repeater-item>
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="mb-2">
                                    <select id="select2-demo-1" class="form-control"
                                            data-plugin="select2" name="workmachine">
                                        <option selected="selected[]" value="">İş Makinesi Seçiniz</option>
                                        <?php foreach ($active_machines as $active_machine => $workmachines) {
                                            foreach ($workmachines as $workmachine) { ?>
                                                <option value="<?php echo $workmachine; ?>"> <?php echo machine_name($workmachine); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-2">
                                <div class="mb-2">
                                    <input type="number" min="1" step="any" class="form-control"
                                           name="machine_count" placeholder="Sayısı">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="machine_place" placeholder="Mahal">
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="machine_notes" placeholder="Açıklama"">
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="mb-2">
                                    <button data-repeater-delete type="button" class="btn btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row box-col-3">
            <div class="repeater">
                <div class="container">
                    <div class="row">
                        <div class="col-11">
                            <h5>Gelen Malzemeler
                                <button data-repeater-create type="button" class="btn btn-success add_btn">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </h5>
                        </div>
                        <div class="col-1">

                        </div>
                    </div>
                </div>
                <div data-repeater-list="supplies">
                    <div data-repeater-item>
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="supply" placeholder="Malzeme Adı">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-2">
                                <div class="mb-2">
                                    <input type="number" min="1" step="any" class="form-control"
                                           name="qty" placeholder="Miktar">
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="mb-2">
                                    <select name="unit" class="form-control">
                                        <option>Birim</option>
                                        <option>m²</option>
                                        <option>m³</option>
                                        <option>kg</option>
                                        <option>ton</option>
                                        <option>m</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-4">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="supply_notes" placeholder="Açıklama"">
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="mb-2">
                                    <button data-repeater-delete type="button" class="btn btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row box-col-3">
            <label>Genel Notlar</label>
            <input type="text" class="form-control"
                   name="note">
        </div>
    </div>
</div>


