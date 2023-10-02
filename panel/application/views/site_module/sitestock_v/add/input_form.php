<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">Dosya No</div>
                    <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">SD</span>
                        <?php if (!empty(get_last_fn("sitestock"))) { ?>
                            <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                   type="number" placeholder="Stok Kodu" aria-describedby="inputGroupPrepend"
                                   data-bs-original-title="" title="" name="dosya_no" required readonly
                                   value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("sitestock"); ?>">
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
                    <div class="col-form-label">Sevkiyat Tarihi</div>
                    <input class="datepicker-here form-control digits"
                           type="text" required
                           name="arrival_date"
                           value="<?php echo date('d-m-Y'); ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">

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
                    </div>
                </div>
                <div data-repeater-list="supplies">
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
                            <div class="col-sm-4 col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="product_name" placeholder="Gelen Malzeme">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-2">
                                <div class="mb-2">
                                    <input type="number" min="0" step="any" class="form-control"
                                           name="product_qty" placeholder="Miktar">
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="mb-2">
                                    <select name="unit" class="form-control">
                                        <option>Birim</option>
                                        <option>m²</option>
                                        <option>adet</option>
                                        <option>paket</option>
                                        <option>m³</option>
                                        <option>kg</option>
                                        <option>ton</option>
                                        <option>m</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-2">
                                <div class="mb-2">
                                    <input type="number" min="0" step="any" class="form-control"
                                           name="price" placeholder="Tutar">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control"
                                           name="bill_code" placeholder="Fatura/İrsaliye No">
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="mb-2">
                                    <select name="supplier" class="form-control">
                                        <option>Seçiniz</option>
                                        <?php foreach ($suppliers as $supplier) { ?>
                                            <option value="<?php echo $supplier->id; ?>"><?php echo $supplier->company_name; ?></option>
                                        <?php } ?>
                                    </select>
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
                                           name="supply_notes" placeholder="Açıklama">
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="mb-2">
                                    <button data-repeater-delete type="button" class="btn btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="row box-col-3">
            <label>Genel Notlar</label>
            <input type="text" class="form-control"
                   name="note">
        </div>
    </div>
</div>







