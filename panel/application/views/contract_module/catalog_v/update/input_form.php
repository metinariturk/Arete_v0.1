<div class="col-xl-4 col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="file-sidebar">
                <ul>
                    <li>
                        <div class="btn btn-light">
                            <a href="<?php echo base_url("project/file_form/$project_id"); ?>">
                                <i data-feather="home"></i>
                                <?php echo project_code_name($project_id); ?>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="btn btn-light ">
                            <a href="<?php echo base_url("contract/file_form/$contract_id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo contract_code_name($item->contract_id); ?>
                                    </span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="btn btn-light">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        <?php echo $item->dosya_no; ?> / <?php echo module_name($this->Module_Name); ?>
                                    </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-footer">
            <div class="mb-2">
                <div class="col-form-label">Katalog Adı</div>
                <input type="text" name="catalog_ad"
                       class="form-control <?php cms_isset(form_error("catalog_ad"), "is-invalid", $item->catalog_ad); ?>"
                       placeholder="Örn. Kaba İnşaat-Hafriyat Vs."
                       value="<?php echo isset($form_error) ? set_value("catalog_ad") : $item->catalog_ad; ?>">
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("catalog_ad"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">
                <div class="checkbox checkbox-primary checkbox-inline">
                    <input type="checkbox" name="master"
                           id="cb-10" <?php cms_if_echo($item->master, "1", "checked", ""); ?>>
                    <label for="cb-10">Ana Sayfada Kullan</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-8 col-md-6">
    <div class="card">
        <div class="card-header">
            <div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list_update/$item->id"); ?>"
                 action="<?php echo base_url("$this->Module_Name/file_upload_update/$item->id"); ?>"
                 id="dropzone" class="dropzone"
                 data-plugin="dropzone"
                 data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload_update/$item->id"); ?>'}">
                <div class="dz-message">
                    <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
                    <h3>Görselleri Eklemek İçin Tıklayınız veya Sürükleyip Bırakınız</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/update_gallery"); ?>
        </div>
    </div>
</div>

