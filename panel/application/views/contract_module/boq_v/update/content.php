<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="file-sidebar">
                    <ul>
                        <li>
                            <div class="btn btn-light ">
                                <a href="<?php echo base_url("contract/file_form/$item->contract_id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo contract_code_name($item->contract_id); ?>
                                    </span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        <?php echo $item->dosya_no; ?> / <?php echo module_name($this->Module_Name); ?>
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
    <div class="col-xl-8 col-md-6 box-col-6">
        <div class="file-content">
            <div class="card">
                <div class="card-header">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                </div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
            </div>
        </div>
    </div>
</div>


