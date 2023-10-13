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
                        <?php if (!empty($item->auction_id)) { ?>
                            <li>
                                <div class="btn btn-light ">
                                    <a href="<?php echo base_url("auction/file_form/$item->auction_id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo auction_code_name($item->auction_id); ?>
                                    </span>
                                    </a>
                                </div>
                            </li>
                        <?php } ?>
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