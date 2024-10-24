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
                                        <li class="nav-item"><span class="main-title"> Sözleşme Süreçleri</span>
                                        </li>
                                        <li><a id="pills-info-tab" data-bs-toggle="pill"
                                               href="#pills-info" role="tab" aria-controls="pills-info"
                                               aria-selected="true"><span
                                                        class="title"> Genel Bilgiler</span></a></li>

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
                                        <li><a class="show" id="pills-bond-tab" data-bs-toggle="pill"
                                               href="#pills-bond" role="tab" aria-controls="pills-bond"
                                               aria-selected="false"><span class="title">Teminatlar</span></a>
                                        </li>
                                        <li>
                                            <hr>
                                        </li>
                                        <li>
                                            <span class="main-title">İş Kalemleri ve Birim Fiyatlar<span
                                                        class="pull-right"></span></span>
                                        </li>
                                        <li><a class="show" id="pills-price_group-tab" data-bs-toggle="pill"
                                               href="#pills-price_group" role="tab"
                                               aria-controls="pills-price_group" aria-selected="false"><span
                                                        class="title"> Sözleşme İş Grupları</span></a></li>

                                        <li><a class="show" id="pills-price-tab" data-bs-toggle="pill"
                                               href="#pills-price" role="tab"
                                               aria-controls="pills-price" aria-selected="false"><span
                                                        class="title"> Sözleşme Poz Kitabı</span></a></li>

                                        <li><a class="show" id="pills-contract_price-tab" data-bs-toggle="pill"
                                               href="#pills-contract_price" role="tab"
                                               aria-controls="pills-contract_price" aria-selected="false"><span
                                                        class="title"> İmalat Listesi (Grup)</span></a></li>

                                        <li><a class="show" id="pills-contract_price_table-tab" data-bs-toggle="pill"
                                               href="#pills-contract_price_table" role="tab"
                                               aria-controls="pills-contract_price_table" aria-selected="false"><span
                                                        class="title">Birim Fiyat Tablo</span></a></li>

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
                                        <?php if ($item->parent == 0 || $item->parent == null) { ?>
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_1_info"); ?>
                                        <?php } else { ?>
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_1_info_sub"); ?>
                                       <?php } ?>
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
                                            <a target="_blank"
                                               href="<?php echo base_url("Export/print_report/$item->id/0"); ?>">
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
                                        <h6 class="mb-0">Avans Yönetimi</h6>
                                        <div>
                                            <i class="fa fa-plus fa-2x text-primary"
                                               style="cursor: pointer;"
                                               data-bs-toggle="modal"
                                               data-bs-target="#modalAdvance"
                                               title="Yeni Hakediş Oluştur"></i>
                                            <a href="#" target="_blank"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="#" target="_blank"><i class="fa fa-file-pdf-o fa-2x"></i></a>
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
                            <div class="fade tab-pane" id="pills-bond" role="tabpanel"
                                 aria-labelledby="pills-bond-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Teminatlar</h6>
                                        <div>
                                            <i class="fa fa-plus fa-2x text-primary"
                                               style="cursor: pointer;"
                                               data-bs-toggle="modal"
                                               data-bs-target="#modalBond"
                                               title="Yeni Hakediş Oluştur"></i>
                                            <a href="#" target="_blank"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="#" target="_blank"><i
                                                        class="fa fa-file-pdf-o fa-2x"></i></a>
                                        </div>
                                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/bond_modal"); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark text-center">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_6_bond"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fade tab-pane" id="pills-price_group" role="tabpanel"
                                 aria-labelledby="pills-price_group-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">İş Grupları</h6>
                                        <div>
                                            <a href="<?php echo base_url("Export/group_download_excel/$item->id"); ?>">
                                                <i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="<?php echo base_url("Export/group_download_pdf/$item->id"); ?>"
                                               target="_blank"><i class="fa fa-file-pdf-o fa-2x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark text-center">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_7_price_group"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-price" role="tabpanel"
                                 aria-labelledby="pills-price-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Poz Kitabı</h6>
                                        <div>
                                            <a href="<?php echo base_url("Export/book_download_excel/$item->id"); ?>">
                                                <i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="<?php echo base_url("Export/book_download_pdf/$item->id"); ?>"
                                               target="_blank"><i class="fa fa-file-pdf-o fa-2x"></i></a>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark text-center">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_8_price_book"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fade tab-pane" id="pills-contract_price" role="tabpanel"
                                 aria-labelledby="pills-contract_price-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">İmalat Listesi (Gruplara Göre)</h6>
                                        <div>
                                            <div>
                                                <a href="<?php echo base_url("Export/group_boq_download_excel/$item->id"); ?>">
                                                    <i class="fa fa-file-excel-o fa-2x"></i></a>
                                                <a href="<?php echo base_url("Export/group_boq_download_pdf/$item->id"); ?>">
                                                    <i class="fa fa-file-pdf-o fa-2x"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_9_contract_price"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-contract_price_table" role="tabpanel"
                                 aria-labelledby="pills-contract_price_table-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h6 class="mb-0">Birim Fiyat Tablosu</h6>
                                        <div>
                                            <a href="<?php echo base_url("Export/contract_price_download_excel/$item->id"); ?>">
                                                <i class="fa fa-file-excel-o fa-2x"></i></a>
                                            <a href="<?php echo base_url("Export/contract_price_download_pdf/$item->id"); ?>">
                                                <i class="fa fa-file-pdf-o fa-2x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="details-bookmark">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_10_contract_price_table"); ?>
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
</div>
