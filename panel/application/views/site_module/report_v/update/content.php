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
                      action="<?php echo base_url("site_module/new_form/"); ?>"
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
        <div class="col-md-12 col-xl-12 col-xxl-4">
            <div class="card">
                <div class="card-body">
                    <div class="file-sidebar">
                        <ul>
                            <li>
                                <div class="btn btn-light">
                                    <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                        <i data-feather="home"></i>
                                        <?php echo project_code_name($project_id); ?>
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
                                        Yeni / <?php echo module_name(site_module); ?>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-12 col-xxl-8">
            <div class="card">
                <form id="update_<?php echo site_module; ?>"
                      action="<?php echo base_url("site_module/update/$item->id"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <?php $this->load->view("site_module/report_v/update/input_form"); ?>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

