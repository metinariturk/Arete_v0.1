<div class="email-wrap bookmark-wrap">
    <div class="row">
        <div class="col-xl-3 box-col-6">
            <div class="md-sidebar">
                <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                    <div class="email-left-aside">
                        <div class="card">
                            <div class="card-body">
                                <div class="email-app-sidebar left-bookmark task-sidebar">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="f-w-600"><a onclick="changeIcon(this)" on
                                                                   style="cursor: pointer;"
                                                                   url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
                                                                   id="myBtn">
                                                    <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?>"> </i><?php echo $item->contract_name; ?>
                                                </a>
                                            </h6>
                                            <span style="font-size: 15px; ">
                                                        <?php if ($item->parent > 0) { ?>
                                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/update/update_sub"); ?>
                                                        <?php } elseif ($item->parent == 0 || !null) { ?>
                                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/update/update"); ?>
                                                        <?php } ?>
                                                    </span>
                                        </div>
                                    </div>
                                    <ul class="nav main-menu" role="tablist">
                                        <li>
                                            <hr>
                                        </li>
                                        <li class="nav-item"><span class="main-title"> Sözleşme Süreç</span>
                                        </li>
                                        <li><a id="pills-info-tab" data-bs-toggle="pill"
                                               href="#pills-info" role="tab" aria-controls="pills-info"
                                               aria-selected="true"><span
                                                        class="title"> Genel Bilgiler</span></a></li>
                                        <li><a class="show" id="pills-uploads-tab" data-bs-toggle="pill"
                                               href="#pills-uploads" role="tab" aria-controls="pills-uploads"
                                               aria-selected="false"><span
                                                        class="title">Yüklemeler</span></a></li>
                                        <li><a class="show" id="pills-report-tab" data-bs-toggle="pill"
                                               href="#pills-report" role="tab"
                                               aria-controls="pills-report" aria-selected="false"><span
                                                        class="title"> Durum Raporu</span></a></li>
                                        <li><a class="show" id="pills-payments-tab" data-bs-toggle="pill"
                                               href="#pills-payments" role="tab" aria-controls="pills-payments"
                                               aria-selected="false"><span
                                                        class="title"> Hakedişler</span></a></li>

                                        <li><a class="show" id="pills-collection-tab" data-bs-toggle="pill"
                                               href="#pills-collection" role="tab" aria-controls="pills-collection"
                                               aria-selected="false"><span class="title">Tahsilatlar</span></a>
                                        </li>





                                        <li><a class="show" id="pills-advance-tab" data-bs-toggle="pill"
                                               href="#pills-advance" role="tab" aria-controls="pills-advance"
                                               aria-selected="false"><span class="title">Avans</span></a>
                                        </li>
                                        <li><a class="show" id="pills-assigned-tab" data-bs-toggle="pill"
                                               href="#pills-assigned" role="tab" aria-controls="pills-assigned"
                                               aria-selected="false"><span
                                                        class="title">Assigned to me</span></a></li>
                                        <li><a class="show" id="pills-tasks-tab" data-bs-toggle="pill"
                                               href="#pills-tasks" role="tab" aria-controls="pills-tasks"
                                               aria-selected="false"><span class="title">My tasks</span></a>
                                        </li>
                                        <li>
                                            <hr>
                                        </li>
                                        <li>
                                            <span class="main-title"> Tags<span class="pull-right"></span></span>
                                        </li>
                                        <li><a class="show" id="pills-notification-tab" data-bs-toggle="pill"
                                               href="#pills-notification" role="tab"
                                               aria-controls="pills-notification" aria-selected="false"><span
                                                        class="title"> notification</span></a></li>
                                        <li><a class="show" id="pills-newsletter-tab" data-bs-toggle="pill"
                                               href="#pills-newsletter" role="tab"
                                               aria-controls="pills-newsletter" aria-selected="false"><span
                                                        class="title"> Newsletter</span></a></li>
                                        <li><a class="show" id="pills-business-tab" data-bs-toggle="pill"
                                               href="#" role="tab" aria-selected="false"><span
                                                        class="title"> Business</span></a>
                                        </li>
                                        <li><a class="show" id="pills-holidays-tab" data-bs-toggle="pill"
                                               href="#" role="tab" aria-selected="false"><span
                                                        class="title"> Holidays</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-12 box-col-12">
            <div class="email-right-aside bookmark-tabcontent">
                <div class="card email-body radius-left">
                    <div class="ps-0">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="pills-info" role="tabpanel"
                                 aria-labelledby="pills-info-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Genel Bilgiler</h6>
                                        <div>
                                            <a href="#" target="_blank"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="#" target="_blank"> <i
                                                        class="fa fa-file-pdf-o fa-2x"></i></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_1_info"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-uploads" role="tabpanel"
                                 aria-labelledby="pills-uploads-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Yüklemeler</h6><a href="#">
                                            <i class="fa fa-download fa-2x"></i></a>
                                    </div>
                                    <div class="card-body">
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/common/add_document"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-report" role="tabpanel"
                                 aria-labelledby="pills-report-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Durum Raporu</h6>
                                        <div>
                                            <a href="#" target="_blank"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a target="_blank" href="<?php echo base_url("contract/print_report/$item->id/0"); ?>">
                                                <i class="fa fa-file-pdf-o fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_2_report"); ?>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-payments" role="tabpanel"
                                 aria-labelledby="pills-payments-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Hakedişler</h6>
                                        <div>
                                            <i class="fa fa-plus fa-2x text-primary"
                                               style="cursor: pointer;"
                                               data-bs-toggle="modal"
                                               data-bs-target="#modalPayment"
                                               title="Yeni Hakediş Oluştur"></i>
                                            <a href="#" target="_blank"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="#" target="_blank"><i
                                                        class="fa fa-file-pdf-o fa-2x"></i></a>
                                        </div>
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/payment_modal"); ?>
                                    </div>
                                    <div class="card-body">
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_3_payments"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-collection" role="tabpanel"
                                 aria-labelledby="pills-collection-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Tahsilatlar</h6>
                                        <div>
                                            <i class="fa fa-plus fa-2x text-primary"
                                               style="cursor: pointer;"
                                               data-bs-toggle="modal"
                                               data-bs-target="#modalCollection"
                                               title="Yeni Hakediş Oluştur"></i>
                                            <a href="#" target="_blank"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="#" target="_blank"><i
                                                        class="fa fa-file-pdf-o fa-2x"></i></a>
                                        </div>
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/collection_modal"); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark text-center">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_4_collection"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-advance" role="tabpanel"
                                 aria-labelledby="pills-advance-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">This Month Tasks</h6>
                                        <div>
                                            <i class="fa fa-plus fa-2x text-primary"
                                               style="cursor: pointer;"
                                               data-bs-toggle="modal"
                                               data-bs-target="#modalAdvance"
                                               title="Yeni Hakediş Oluştur"></i>
                                            <a href="#" target="_blank"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="#" target="_blank"><i
                                                        class="fa fa-file-pdf-o fa-2x"></i></a>
                                        </div>
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/advance_modal"); ?>

                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark text-center">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_5_advance"); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-assigned" role="tabpanel"
                                 aria-labelledby="pills-assigned-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Assigned to me</h6><a href="#"><i class="me-2"
                                                                                           data-feather="printer"></i>Print</a>
                                    </div>
                                    <div class="card-body p-0">
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-tasks" role="tabpanel"
                                 aria-labelledby="pills-tasks-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">My tasks</h6><a href="#"><i class="me-2"
                                                                                     data-feather="printer"></i>Print</a>
                                    </div>
                                    <div class="card-body p-0">
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-notification" role="tabpanel"
                                 aria-labelledby="pills-notification-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Notification</h6><a href="#"><i class="me-2"
                                                                                         data-feather="printer"></i>Print</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark text-center"><span>No tasks found.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-newsletter" role="tabpanel"
                                 aria-labelledby="pills-newsletter-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Newsletter</h6><a href="#"><i class="me-2"
                                                                                       data-feather="printer"></i>Print</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark text-center"><span>No tasks found.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade modal-bookmark" id="createtag" tabindex="-1" role="dialog"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create Tag</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-bookmark needs-validation" novalidate="">
                                                <div class="row">
                                                    <div class="mb-3 mt-0 col-md-12">
                                                        <label>Tag Name</label>
                                                        <input class="form-control" type="text" required=""
                                                               autocomplete="off">
                                                    </div>
                                                    <div class="mt-0 col-md-12">
                                                        <label>Tag color</label>
                                                        <input class="form-color d-block" type="color"
                                                               value="#563d7c">
                                                    </div>
                                                </div>
                                                <button class="btn btn-secondary" type="button">Save</button>
                                                <button class="btn btn-primary" type="button"
                                                        data-bs-dismiss="modal">Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
