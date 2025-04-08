<div class="tab-pane fade active show" id="pills-personal" role="tabpanel"
     aria-labelledby="pills-personal-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h5>Tüm Kişiler</h5>
            <span class="f-14 pull-right mt-0"><?php echo count($items); ?> Kişi</span>
            <span class="f-14 pull-right mt-0">
                <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                   id="openUserModal"
                   data-bs-target="#AddUserModal"></i>
            </span>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row list-persons">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                <?php foreach ($items as $item) { ?>
                                    <a class="contact-tab-0 nav-link" data-bs-toggle="pill"
                                       onclick="show_user_detail(<?php echo $item->id; ?>)"
                                       role="tab" aria-controls="v-pills-user" aria-selected="false" tabindex="-1">
                                        <div class="media"> <?php if ($item->is_Admin == 1) {
                                                echo "<i class='fa fa-star' style='color: gold'></i>";
                                            } ?>
                                            <img class="img-50 img-fluid m-r-20 rounded-circle update_img_0"
                                                <?php echo get_avatar($item->id); ?> alt="">
                                            <div class="media-body">
                                                <h6>
                                                    <span class="first_name_0"><?php echo $item->name; ?> </span><span
                                                            class="last_name_0">   <?php echo $item->surname; ?><br></span>
                                                </h6>
                                                <p class="email_add_0"><?php echo $item->unvan; ?></p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
