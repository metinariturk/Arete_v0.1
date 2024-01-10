
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
                    <div class="col-form-label">Çalışamayan Gün</div>
                    <input name="off_days" type="checkbox" <?php if  ($item->off_days == 0){echo "checked";} ?> value="0" >
                </div>
            </div>
        </div>
        <hr>
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/workgroups"); ?>
        <hr>
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/workmachines"); ?>
        <hr>
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/supplies"); ?>
        <hr>
        <div class="row box-col-3">
            <label>Genel Notlar</label>
            <input type="text" class="form-control" value="<?php echo $item->aciklama; ?>"
                   name="note">
        </div>
    </div>
</div>


