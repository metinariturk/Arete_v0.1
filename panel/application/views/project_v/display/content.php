<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-2 box-col-6">
                <div class="email-left-aside">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <a  style="cursor: pointer;"  data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i class="fa fa-edit fa-2x"></i> Proje Düzenle</a>
                                <div class="modal fade" id="exampleModalgetbootstrap" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                <h3 class="modal-header justify-content-center border-0">Proje Bilgilerini Düzenle</h3>
                                                <div class="modal-body">
                                                    <form class="row g-3 needs-validation" novalidate="" action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post" enctype="multipart/form-data">
                                                        <div class="mb-3">
                                                            <div class="col-form-label">Proje Kodu</div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="inputGroupPrepend"><?php echo $item->project_code; ?></span>

                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input class="form-control <?php echo cms_isset(form_error("project_name"), "is-invalid", "$item->project_name"); ?>"
                                                                   placeholder="Proje Adı" aria-describedby="inputGroupPrepend" name="project_name"
                                                                   value="<?php echo isset($form_error) ? set_value("project_name") : "$item->project_name"; ?>">
                                                            <?php if (isset($form_error)) { ?>
                                                                <div class="invalid-feedback"><?php echo form_error("project_name"); ?></div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input type="text" class="form-control" name="notes" value="<?php echo $item->notes; ?>">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button class="btn btn-primary" type="submit">Değişiklikleri Kaydet</button>
                                                        </div>
                                                        <?php print_r(validation_errors()); ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <a onclick="changeIcon(this)" style="cursor: pointer;"
                               url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
                               id="myBtn">
                                <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?> fa-2x"></i> Ana Sayfaya Ekle
                            </a>
                            <hr>
                            <div class="email-app-sidebar left-bookmark">
                                <ul class="nav main-menu" role="tablist">
                                    <li>
                                        <span class="title"><b><?php echo $item->project_code; ?> </b><br> <?php echo $item->project_name; ?></span>
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


