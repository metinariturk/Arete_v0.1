<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-12 col-md-12 box-col-12">
                <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="pills-personal" role="tabpanel"
                                     aria-labelledby="pills-personal-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h5>Tüm Kişiler</h5>
                                            <span class="f-14 pull-right mt-0"><?php echo count($items); ?> Kişi</span>
                                            <span class="f-14 pull-right mt-0">
                                                <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal" id="openUserModal" data-bs-target="#AddUserModal"></i>
                                            </span>
                                        </div>
                                        <div id="user_table">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/user/user_table"); ?>
                                        </div>
                                        <div id="add_user_modal">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/user/add_user_modal"); ?>
                                        </div>
                                        <div id="edit_user_modal">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/user/edit_user_modal_form"); ?>
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
