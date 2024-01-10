
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-md-2">
                <div class="mb-2">
                    <div class="col-form-label">Rapor Tarihi</div>
                    <input class="datepicker-here form-control digits"
                           type="text" required
                           name="report_date"
                           value="<?php echo isset($form_error) ? set_value("report_date") : dateFormat('d-m-Y',$item->report_date); ?>"
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


