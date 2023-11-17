<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
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
    </div>
    <div class="col-sm-8">
        <form id="update_payment"
              action="<?php echo base_url("$this->Module_Name/update_payment/$item->id"); ?>" method="post"
              enctype="multipart/form-data" autocomplete="off">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
        </form>
    </div>
</div>