
        <div class="card mb-0">
            <div class="card-header d-flex">
                <h6 class="mb-0">Kesin Kabul Evrakları</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <form id="final_date"
                              action="<?php echo base_url("$this->Module_Name/final_date/$item->id"); ?>"
                              method="post"
                              enctype="multipart/form-data" autocomplete="off">
                            <div class="row">
                                <div class="col-10">
                                    <div class="col-form-label">Kesin Kabul Tarihi
                                        <?php if (date_control($item->final_date)) { ?>
                                            <a class="unstyled-button"
                                               style="border: none; padding: 0; background: none;"
                                               onclick="enable_final()">
                                                <i class="fa fa-edit fa-2x"></i>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <input class="datepicker-here form-control digits"
                                           type="text" autocomplete="off"
                                           name="final_date"
                                           id="finalchange"
                                        <?php if (date_control($item->final_date)) { ?>
                                            value=" <?php echo dateFormat_dmy($item->final_date); ?>"
                                            disabled
                                        <?php } ?>
                                           data-options="{ format: 'DD-MM-YYYY' }"
                                           data-language="tr">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <button type="submit" form="final_date" id="save_finalbutton"
                                            class="btn btn-success" <?php if (date_control($item->final_date)) { ?>
                                            style="display: none;"> <?php } ?>
                                        <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <p style="color: red;">
                                <?php if (isset($error)) { ?>
                                    <?php echo "*" . $error; ?>
                                <?php } ?>
                            </p>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div data-url="<?php echo base_url("$this->Module_Name/refresh_final_list/$item->id"); ?>"
                             action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Final"); ?>"
                             id="dropzone_final" class="dropzone"
                             data-plugin="dropzone"
                             data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Final"); ?>'}">
                            <div class="dz-message">
                                <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
                                <h3>Kesin Kabul ile İlgili Evrakları Buraya Ekleyiniz</h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
