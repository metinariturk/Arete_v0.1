<div class="row">
    <div class="col-xl-6 col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="file-sidebar">
                    <ul>
                        <li>
                            <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                <div class="btn btn-light">
                                    <i data-feather="home"></i>
                                    <?php echo project_code_name($item->proje_id); ?>
                                </div>
                            </a>
                        </li>

                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        <?php echo contract_code_name($item->id); ?>
                                    </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <form id="update_<?php echo $this->Module_Name; ?>"
                  action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post"
                  enctype="multipart/form-data" autocomplete="off">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
            </form>
        </div>
    </div>
    <div class="col-xl-6 col-md-4">
        <div class="card">
            <div class="file-content">
                <div class="card-header">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo validation_errors(); ?>
