<?php
if (empty($site->id)) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Şantiye Seçimi Yapmadan Bu İşleme Devam Edemezsiniz</h4>
                </div>
            </div>
            <div class="card">
                <form id="site_id"
                      action="<?php echo base_url("$this->Module_Name/new_form/"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="card-body">
                        <div class="mb-2 col-sm-6">
                            <label class="col-form-label" for="recipient-name">Şantiye Seçiniz</label>
                            <select class="form-control" name="site_id">
                                <?php foreach ($active_sites as $active_site) { ?>
                                    <option value="<?php echo "$active_site->id"; ?>">
                                        <?php echo "$active_site->santiye_ad"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="file-sidebar">
                        <ul>
                            <li>
                                <div class="btn btn-light">
                                    <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                        <i data-feather="home"></i>
                                        <?php echo project_code_name($site->project_id); ?>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="btn btn-light ">
                                    <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo $site->dosya_no." ".$site->santiye_ad; ?>
                                    </span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="btn btn-light">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        Yeni / <?php echo module_name($this->Module_Name); ?>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-12 col-xxl-9">
            <div class="card">
                <form id="save_<?php echo $this->Module_Name; ?>"
                      action="<?php echo base_url("$this->Module_Name/save/$site->id"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                </form>
            </div>
        </div>
    </div>
<?php } ?>