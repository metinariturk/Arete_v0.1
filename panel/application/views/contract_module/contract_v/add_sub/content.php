<?php
if (empty($project_id)) { ?>
    <div class="alert alert-info text-center">
        <p>Lütfen Yeni <?php echo $this->Module_Title; ?> İlgili Proje Seçiniz <a
                    href="<?php echo base_url("Project"); ?>">tıklayınız</a></p>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="card">
                <div class="card-body">
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
                                <div class="btn btn-light">
                                    <a href="">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        Yeni / Sözleşme
                                    </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <form id="save_sub"
                  action="<?php echo base_url("$this->Module_Name/save_sub/$main_contract->id"); ?>"
                  method="post"
                  enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form_2"); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } ?>



