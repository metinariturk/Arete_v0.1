<div class="fade tab-pane <?php if ($active_tab == "sitedel") {
    echo "active show";
} ?>"
     id="sitedel" role="tabpanel"
     aria-labelledby="sitedel-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Yer Teslimi Evrakları</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <form id="sitedel_date"
                          action="<?php echo base_url("$this->Module_Name/sitedel_date/$item->id"); ?>"
                          method="post"
                          enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-10">
                                <div class="col-form-label">Yer Teslimi Tarihi
                                    <?php if (date_control($item->sitedel_date)) { ?>
                                    <a class="unstyled-button"
                                       style="border: none; padding: 0; background: none;"
                                       onclick="enable()">
                                        <i class="fa fa-edit fa-2x"></i>
                                    </a>
                                    <?php } ?>
                                </div>
                                <input class="datepicker-here form-control digits"
                                       type="text" autocomplete="off"
                                       name="teslim_tarihi"
                                       id="change"
                                       <?php if (date_control($item->sitedel_date)) { ?>
                                       value=" <?php echo dateFormat_dmy($item->sitedel_date); ?>"
                                           disabled
                                        <?php } ?>
                                       data-options="{ format: 'DD-MM-YYYY' }"
                                       data-language="tr">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <button type="submit" form="sitedel_date" id="save_button"
                                        class="btn btn-success" <?php if (date_control($item->sitedel_date)) { ?> style="display: none;"> <?php } ?>
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
                    <div data-url="<?php echo base_url("$this->Module_Name/refresh_site_list/$item->id"); ?>"
                         action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Sitedel"); ?>"
                         id="dropzone_sitedel" class="dropzone"
                         data-plugin="dropzone"
                         data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Sitedel"); ?>'}">
                        <div class="dz-message">
                            <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
                            <h3>Yer Teslimi ile İlgili Evrakları Buraya Ekleyiniz</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



