<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="page-title">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb">
                        <?php if (!empty($prev_payment)) { ?>
                            <li>
                                <a class="btn btn-success"
                                   href="<?php echo base_url("payment/file_form/$prev_payment->id"); ?>">
                                    <i class="fa fa-arrow-left"></i> Önceki Hakediş (<?php echo $prev_payment->hakedis_no; ?> Nolu)
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                           &nbsp;
                        </li>
                        <?php if (!empty($next_payment)) { ?>
                            <li>
                                <a class="btn btn-success"
                                   href="<?php echo base_url("payment/file_form/$next_payment->id"); ?>">
                                    Sonraki Hakediş (<?php echo $next_payment->hakedis_no; ?> Nolu)  <i class="fa fa-arrow-right"></i>
                                </a>
                            </li>
                        <?php } ?>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-4 box-col-2">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/navtab"); ?>
            </div>
            <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-8 box-col-10">
                <div class="email-right-aside bookmark-tabcontent">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            <div class="tab-content">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/01_tab_calculate"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/02_tab_green"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/03_tab_works_done"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/03A_leaders"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/04_tab_group_total"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/05_tab_main_total"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/06_tab_report"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/07_tab_info"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_sign"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_settings"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_download"); ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_uploads"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-title">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb">
                        <li>
                            <a class="btn btn-success"
                               href="<?php echo base_url("contract/file_form/$item->contract_id/payment"); ?>">
                                <i class="fa fa-arrow-left"></i> Sözleşmeye Dön
                            </a>
                        </li>
                        <li>
                            <button class="btn btn-primary"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalgetbootstrap"
                                    data-whatever="@getbootstrap">
                                <i class="menu-icon fa fa-trash-o fa-lg"></i> Hakedişi Sil
                            </button>
                            <div class="modal fade" id="exampleModalgetbootstrap" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Dikkat!</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Hakedişi silmek üzeresiniz. Metraj verilerinizin korunmasını istiyosanız
                                            sadece hakedişi silebilirsiniz.
                                        </div>
                                        <div class="modal-footer">
                                            <?php if (isset($active_boqs)) { ?>
                                                <button class="btn btn-danger" type="button"
                                                        onclick="deleteConfirmationModule(this)"
                                                        data-text="<?php echo $this->Module_Title; ?> ve Hesapları"
                                                        data-url="<?php echo base_url("payment/delete_calc/$item->id"); ?>">
                                                    <i class="menu-icon fa fa-trash fa-xl" aria-hidden="true"></i>
                                                    Hesaplar ile Birlikte Sil
                                                </button> <?php } ?>
                                            <button class="btn btn-danger" type="button"
                                                    onclick="deleteConfirmationModule(this)"
                                                    data-text="<?php echo $this->Module_Title; ?>"
                                                    data-url="<?php echo base_url("$this->Module_Name/delete/$item->id"); ?>">
                                                <i class="menu-icon fa fa-trash fa-xl" aria-hidden="true"></i>
                                                Sadece Hakedişi Sil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

    </div>
</div>


