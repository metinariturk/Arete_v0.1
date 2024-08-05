<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-2 box-col-6">
                <div class="email-left-aside">

                    <div class="card">
                        <div class="card-body">
                            <a onclick="changeIcon(this)"
                               url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
                               id="myBtn">
                                <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?> fa-2x"></i> Ana Sayfaya Ekle
                            </a>

                            <hr>
                            <div class="email-app-sidebar left-bookmark">
                                <ul class="nav main-menu" role="tablist">
                                    <li>
                                        <span class="title"><?php echo $item->project_code . "/" . $item->project_name; ?></span>
                                    </li>
                                    <li>
                                        <hr>
                                    </li>
                                    <li>
                                        <a class="show" id="pills-shared-tab" data-bs-toggle="pill" href="#pills-shared"
                                           role="tab" aria-controls="pills-shared" aria-selected="false"><span
                                                    class="title">Sözleşmeler</span></a>
                                    </li>
                                    <li><a class="show" id="pills-favourites-tab" data-bs-toggle="pill"
                                           href="#pills-favourites" role="tab" aria-controls="pills-favourites"
                                           aria-selected="false"><span class="title"> Teklifler</span></a></li>
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
                                <div class="fade tab-pane active show" id="pills-shared" role="tabpanel"
                                     aria-labelledby="pills-shared-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Ana Sözleşmeler</h6>
                                            <ul>
                                                <li>
                                                    <a class="pager-btn btn btn-info btn-outline"
                                                       href="<?php echo base_url("contract/new_form_main/$item->id"); ?>">
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
                                <div class="fade tab-pane" id="pills-favourites" role="tabpanel"
                                     aria-labelledby="pills-favourites-tab">

                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Teklifler</h6>
                                            <ul>
                                                <li>
                                                    <a class="pager-btn btn btn-info btn-outline"
                                                       href="<?php echo base_url("contract/new_form_offer/$item->id"); ?>">
                                                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
                                                        Teklif Ekle
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($offers)) { ?>
                                                <?php $this->load->view("{$viewFolder}/{$subViewFolder}/connected_offer"); ?>
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
                                                       href="<?php echo base_url("site/new_form/$item->id"); ?>">
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
                <div class="card mb-0">
                        <?php $this->load->view("{$viewFolder}/$this->Common_Files/add_document"); ?>
                    </div>
            </div>
        </div>
    </div>
</div>


