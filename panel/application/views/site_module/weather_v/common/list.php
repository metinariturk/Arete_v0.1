<div class="container-fluid calendar-basic">
    <div class="card">
        <div class="card-body">
            <div class="row" id="wrap">
                <div class="md-sidebar mb-3">
                    <div id="external-events">
                        <h4>Hava Durumu</h4>
                    </div>
                </div>
                <div class="col-xxl-3 box-col-12">
                    <form id="category"
                        <?php if (!empty($report)) { ?>
                            action="<?php echo base_url("weather/save/$report->id"); ?>"
                        <?php } else { ?>
                            action="<?php echo base_url("weather/save"); ?>"
                        <?php } ?>

                          url="<?php echo base_url("weather/add"); ?>"
                          method="post" enctype="multipart">
                        <?php if (!empty($report)) { ?>
                            <input class="datepicker-here form-control digits"
                                   type="text" required
                                   name="report_date"
                                   value="<?php echo isset($form_error) ? set_value("report_date") : dateFormat('d-m-Y', $report->report_date); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                        <?php } else { ?>
                            <input class="datepicker-here form-control digits  <?php cms_isset(form_error("report_date"), "is-invalid", ""); ?>"
                                   type="text" required
                                   name="report_date"
                                   value="<?php echo isset($form_error) ? set_value("report_date") : date('d-m-Y'); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                        <?php } ?>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-report_date"><?php echo form_error("report_date"); ?></div>
                        <?php } ?>
                        <input type="number" name="min" placeholder="En Düşük"
                               value="<?php echo isset($form_error) ? set_value("min") : ""; ?>"
                               class="form-control <?php cms_isset(form_error("min"), "is-invalid", ""); ?>"/>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-report_date"><?php echo form_error("min"); ?></div>
                        <?php } ?>
                        <input type="number" name="max" placeholder="En Yüksek"
                               value="<?php echo isset($form_error) ? set_value("max") : ""; ?>"
                               class="form-control <?php cms_isset(form_error("max"), "is-invalid", ""); ?>"/>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-report_date"><?php echo form_error("max"); ?></div>
                        <?php } ?>
                        <select name="event"
                                class="form-control <?php cms_isset(form_error("event"), "is-invalid", ""); ?>">
                            <option>Açık</option>
                            <option>Bulutlu</option>
                            <option>Sisli</option>
                            <option>Yağmurlu</option>
                            <option>Rüzgarlı</option>
                            <option>Kar Yağışlı</option>
                            <option>Şiddetli Yağmur</option>
                            <option>Şiddetli Rüzgar</option>
                            <option>Şiddetli Kar</option>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-report_date"><?php echo form_error("event"); ?></div>
                        <?php } ?>
                        <input name="update" type="checkbox" id="cb-10"> Bu Tarihi Güncelle
                        <br>

                        <button class="btn btn-outline-success" name="save" onclick="saveweather(0)"
                                type="submit" data-bs-original-title="" title="">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Kaydet
                        </button>
                    </form>
                </div>
                <div class="col-xxl-9 box-col-12">
                    <div class="calendar-default" id="calendar-container">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

