<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-2 box-col-6">
                <div class="email-left-aside">
                    <div class="card">
                        <div class="card-body">
                            <div class="email-app-sidebar left-bookmark">
                                <ul class="nav main-menu" role="tablist">
                                    <li></li>
                                    <li class="nav-item"><span class="main-title">Detaylar</span></li>
                                    <li><a id="pills-created-tab" data-bs-toggle="pill" href="#pills-created" role="tab"
                                           aria-controls="pills-created" aria-selected="true"><span class="title">Proje Genel Bilgileri</span></a>
                                    </li>
                                    <li><a class="show" id="pills-favourites-tab" data-bs-toggle="pill"
                                           href="#pills-favourites" role="tab" aria-controls="pills-favourites"
                                           aria-selected="false"><span class="title"> Teklifler</span></a></li>
                                    <li><a class="show" id="pills-shared-tab" data-bs-toggle="pill" href="#pills-shared"
                                           role="tab" aria-controls="pills-shared" aria-selected="false"><span
                                                    class="title">Ana Sözleşmeler</span></a></li>
                                    <li><a class="show" id="pills-bookmark-tab" data-bs-toggle="pill"
                                           href="#pills-bookmark" role="tab" aria-controls="pills-bookmark"
                                           aria-selected="false"><span class="title">Alt Sözleşmeler</span></a></li>
                                    <li><a class="show" id="pills-notification-tab" data-bs-toggle="pill"
                                           href="#pills-notification" role="tab" aria-controls="pills-notification"
                                           aria-selected="false"><span class="title"> Şantiyeler</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-md-12 box-col-12">
                <div class="email-right-aside bookmark-tabcontent">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="pills-created" role="tabpanel"
                                     aria-labelledby="pills-created-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Proje Özeti</h6>
                                            <a onclick="changeIcon(this)"
                                               url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
                                               id="myBtn">
                                                <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?> fa-2x">
                                                </i>
                                            </a>
                                        </div>
                                        <div class="card-body pb-0">
                                            <?php $this->load->view("{$viewFolder}/{$subViewFolder}/display_table"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="fade tab-pane" id="pills-favourites" role="tabpanel"
                                     aria-labelledby="pills-favourites-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Teklifler</h6>
                                            <ul>
                                                <li>
                                                    <a class="pager-btn btn btn-info btn-outline"
                                                       href="<?php echo base_url("auction/new_form/$item->id"); ?>">
                                                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
                                                        Teklif Ekle
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($prep_auctions)) { ?>
                                                <?php $this->load->view("{$viewFolder}/{$subViewFolder}/connected_auction"); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="fade tab-pane" id="pills-shared" role="tabpanel"
                                     aria-labelledby="pills-shared-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Ana Sözleşmeler</h6>
                                            <ul>
                                                <li>
                                                    <a class="pager-btn btn btn-info btn-outline"
                                                       href="<?php echo base_url("contract/new_form_project/$item->id"); ?>">
                                                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
                                                        Sözleşme Ekle
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($contracts)) { ?>
                                                <?php $this->load->view("{$viewFolder}/{$subViewFolder}/connected_contract"); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="fade tab-pane" id="pills-bookmark" role="tabpanel"
                                     aria-labelledby="pills-bookmark-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Alt Sözleşmeler</h6>
                                            <ul>
                                                <li>
                                                    <a class="pager-btn btn btn-info btn-outline"
                                                       href="<?php echo base_url("subcontract/new_form_project/$item->id/project"); ?>">
                                                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Alt
                                                        Sözleşme Ekle
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($subcontracts)) { ?>
                                                <?php $this->load->view("{$viewFolder}/{$subViewFolder}/connected_subcontract"); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="fade tab-pane" id="pills-notification" role="tabpanel"
                                     aria-labelledby="pills-notification-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Şantiyeler</h6>
                                            <ul>
                                                <li>
                                                    <a class="pager-btn btn btn-info btn-outline"
                                                       href="<?php echo base_url("site/new_form_project/$item->id"); ?>">
                                                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
                                                        Şantiye Ekle
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($sites)) { ?>
                                                <?php $this->load->view("{$viewFolder}/{$subViewFolder}/connected_site"); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-12 box-col-12">
                <div class="tab-content">
                    <?php $this->load->view("{$viewFolder}/$this->Common_Files/add_document"); ?>
                    <div class="widget">
                        <div class="widget-body image_list_container">
                            <?php $this->load->view("{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                        </div><!-- .widget-body -->
                    </div><!-- .widget -->
                </div>
            </div>
        </div>
    </div>
</div>


