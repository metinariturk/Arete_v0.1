<div class="row">

    <div class="col-xl-4 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="file-sidebar">
                    <ul>
                        <li>
                            <a href="<?php echo base_url("project/file_form/$project_id"); ?>">
<div class="btn btn-light">
<i data-feather="home"></i>
<?php echo project_code_name($project_id); ?>
</div>
 </a>
                        </li>
                        <li>
                            <div class="btn btn-light ">
                                <a href="<?php echo base_url("auction/file_form/$item->auction_id/condition"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo auction_code_name($item->auction_id); ?>
                                    </span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        <?php echo module_name($this->Module_Name); ?>
                                    </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xl-8 col-sm-12">
        <div class="card">

            <form id="update_<?php echo $this->Module_Name; ?>"
                  action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post"
                  enctype="multipart/form-data" autocomplete="off">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
            </form>
        </div>
    </div>
</div>



