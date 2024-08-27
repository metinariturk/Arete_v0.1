<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 box-col-2">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/navtab"); ?>
            </div>
            <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-8 box-col-10">
                <div class="email-right-aside bookmark-tabcontent">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            <div class="tab-content">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_1"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_report"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_3"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_6"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_6_c"); ?>

                                <?php if (empty($item->parent)) { ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_2"); ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_4"); ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_5"); ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_7"); ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_8"); ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_9"); ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_10"); ?>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_11"); ?>
                                <?php } ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_6_a"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_6_b"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_12"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_13"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_14"); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-title">
                    <div class="row">
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li>
                                    <a class="btn btn-success" type="button"
                                       href="<?php echo base_url("$this->Module_Name/update_form/$item->id"); ?>">
                                        <i class="menu-icon fa fa-edit fa-lg"></i> Düzenle
                                    </a>
                                    <button class="btn btn-danger" type="button"
                                            onclick="deleteConfirmationModule(this)"
                                            data-text="<?php echo $this->Module_Title; ?>"
                                            data-url="<?php echo base_url("$this->Module_Name/delete_form/$item->id"); ?>"
                                            url="<?php echo base_url("$this->Module_Name/delete_form/$item->id"); ?>">
                                        <i class="menu-icon fa fa-trash fa-xl" aria-hidden="true"></i> Sil
                                    </button>

                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


