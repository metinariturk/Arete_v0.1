<div class="row">
    <div class="col-xl-12 col-xxl-3">
        <div class="card">
            <div class="card-header">
                <div class="file-sidebar">
                    <ul>
                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("project/file_form/$project->id"); ?>">
                                    <i data-feather="home"></i>
                                    <?php echo project_code_name($project->id); ?>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i data-feather="home"></i>
                                    <?php echo site_code_name($site->id); ?>
                                </a>
                            </div>
                        </li>
                        <?php if (isset($contract_id)) { ?>
                            <li>
                                <div class="btn btn-light ">
                                    <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                                    <span style="padding-left: 40px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo contract_code_name($contract->id); ?>
                                    </span>
                                    </a>
                                </div>
                            </li>
                        <?php } ?>
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
            <div class="card-body">
                <div class="file-content">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                    <div class="image_list_container">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-xxl-9">
        <div class="card">
            <div class="card-header">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/main"); ?>
            </div>
            <div class="card-body">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/supplies"); ?>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/foot"); ?>
            </div>
        </div>
    </div>
</div>


