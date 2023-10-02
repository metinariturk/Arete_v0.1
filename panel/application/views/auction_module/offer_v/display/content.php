<?php $proje_id = get_from_id("auction", "proje_id", $item->auction_id); ?>

<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-9 col-md-9 box-col-12">
                <div class="card mb-0">
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
                                        <a href="<?php echo base_url("auction/file_form/$item->auction_id"); ?>">
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
                                        <?php echo $item->dosya_no; ?> / <?php echo module_name($this->Module_Name); ?>
                                    </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/display_table"); ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 box-col-12">
                <div class="tab-content">
                    <div class="image_list_container">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                    </div><!-- .widget-body -->
                </div>
            </div>
        </div>
    </div>
</div>


