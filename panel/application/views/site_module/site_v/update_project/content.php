<div class="row">
    <div class="col-sm-12 col-md-4">
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
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        <?php echo site_name($item->id); ?> / <?php echo module_name("site"); ?>
                                    </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="card">
            <form id="update_site"
                  action="<?php echo base_url("$this->Module_Name/update_project/$item->id"); ?>" method="post"
                  enctype="multipart/form-data" autocomplete="off">
                <div class="card">
                    <div class="card-body">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>







