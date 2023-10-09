<div class="fade tab-pane <?php if ($active_tab == "workplan") {
    echo "active show";
} ?>"
     id="workplan" role="tabpanel"
     aria-labelledby="workplan-tab">
    <div class="row">
        <?php if ($item->subcont != 1) { ?>
            <div class="col-xxl-6 col-xl-6 box-col-10">
                <div class="card-body">
                    <div class="row">
                        <form id="workplan_date"
                              action="<?php echo base_url("$this->Module_Name/workplan_date/$item->id"); ?>"
                              method="post"
                              enctype="multipart/form-data" autocomplete="off">
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="col-form-label">İş Programı Teslim Tarihi</div>
                                </div>
                                <div class="col-sm-10">
                                    <input class="datepicker-here form-control digits"
                                           type="text" autocomplete="off"
                                           name="workplan_date"
                                           id="wpchange"
                                        <?php if (date_control($item->workplan_date)) { ?>
                                            value=" <?php echo dateFormat_dmy($item->workplan_date); ?>"
                                            disabled
                                        <?php } ?>
                                           data-options="{ format: 'DD-MM-YYYY' }"
                                           data-language="tr">
                                </div>
                                <div class="col-sm-2">
                                    <?php if (date_control($item->workplan_date)) { ?>
                                        <a class="unstyled-button"
                                           style="border: none; padding: 0; background: none;"
                                           onclick="enable_workplan()">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" form="workplan_date" id="save_wpbutton"
                                            class="btn btn-success" <?php if (date_control($item->workplan_date)) { ?>
                                            style="display: none;"> <?php } ?>
                                        <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="row">
                        <div data-url="<?php echo base_url("$this->Module_Name/refresh_workplan_list/$item->id"); ?>"
                             action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Workplan"); ?>"
                             id="dropzone_workplan" class="dropzone"
                             data-plugin="dropzone"
                             data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Workplan"); ?>'}">
                            <div class="dz-message">
                                <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
                                <h3>İş Programı ile İlgili Evrakları Buraya Ekleyiniz</h3>
                            </div>
                        </div>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/common/workplan_list_v"); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-xxl-6 col-xl-6 box-col-10">
            <div class="card-body">
                <div class="row">
                    <form id="workplan_payment"
                          action="<?php echo base_url("$this->Module_Name/workplan_payment/$item->id"); ?>"
                          method="post"
                          enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h4>İş Programına Göre Ödenek Dilimleri</h4>
                            </div>
                            <?php if (!empty($item->workplan_payment)) { ?>
                                <?php $workplan_payments = (json_decode($item->workplan_payment)); ?>
                                <?php
                                $i = 1;
                                foreach ($workplan_payments as $workplan_payment) { ?>
                                    <div class="col-1"><?php echo $i++; ?> </div>
                                    <div class="col-11">
                                        <input class="form-control" type="number" step="any"
                                               value="<?php echo $workplan_payment; ?>"
                                               name="old_payment[]">
                                    </div>
                                    <div class="col-2">

                                    </div>
                                <?php } ?>
                            <?php } ?>

                            <div class="repeater">
                                <div data-repeater-list="workplan_payment">
                                    <hr>
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" step="any"
                                                       name="payment">
                                            </div>
                                            <div class="col-sm-2">
                                                <input data-repeater-delete type="button" class="btn btn-danger"
                                                       value="Satır Sil"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <input data-repeater-create type="button" class="btn btn-success"
                                       value="Satır Ekle"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <button type="submit" form="workplan_payment" id="save_wpbutton"
                                        class="btn btn-success"
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <p style="color: red;">
                            <?php if (isset($error_workplan)) { ?>
                                <?php echo "*" . $error_workplan; ?>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





