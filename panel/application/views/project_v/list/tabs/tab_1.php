<div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
    <div class="row">
        <?php foreach ($actives as $active) { ?>
            <?php if (!isAdmin()) { ?>
                <?php $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$active->id"));
                if (in_array(active_user_id(), $yetkili)) { ?>
                    <div class="col-xxl-4 col-lg-6">
                        <div class="project-box">
                            <span class="badge badge-primary">Devam Ediyor</span>
                            <a href="<?php echo base_url("project/file_form/$active->id"); ?>"
                            <h6><?php echo $active->proje_ad; ?></h6>
                            </a>
                            <div class="media"><img class="img-20 me-1 rounded-circle"
                                                    src="<?php echo base_url("assets"); ?>/images/user/3.jpg" alt=""
                                                    data-original-title="" title="">
                                <div class="media-body">
                                    <p><?php echo $active->proje_kodu; ?></p>
                                </div>
                            </div>
                            <p><?php echo tags($active->etiketler); ?></p>
                            <p><?php echo $active->department; ?></p>
                            <div class="row details">
                                <div class="col-6"><span>Sözleşme</span></div>
                                <div class="col-6 text-primary"><?php echo count_data("contract", "proje_id", $active->id); ?></div>
                                <div class="col-6"><span>İhale</span></div>
                                <div class="col-6 text-primary"><?php echo count_data("auction", "proje_id", $active->id); ?></div>
                                <div class="col-6"><span>Şantiye</span></div>
                                <div class="col-6 text-primary"><?php echo count_data("site", "proje_id", $active->id); ?></div>
                            </div>
                            <div class="customers">

                                <ul>
                                    <?php $yetkililer = str_getcsv($active->yetkili_personeller); ?>
                                    <?php foreach ($yetkililer as $yetkili) { ?>
                                        <li class="d-inline-block">
                                <span data-tooltip-location="top" data-tooltip="<?php echo full_name($yetkili); ?>">
                                    <img class="img-30 rounded-circle"  <?php echo get_avatar($yetkili); ?> data-tooltip="asd"
                                         alt="" data-original-title="" title=""></li>
                                        </span>
                                    <?php } ?>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-xxl-4 col-lg-6">
                    <div class="project-box">
                        <span class="badge badge-primary">Devam Ediyor</span>
                        <a href="<?php echo base_url("project/file_form/$active->id"); ?>"
                        <h6><?php echo $active->proje_ad; ?></h6>
                        </a>
                        <div class="media"><img class="img-20 me-1 rounded-circle"
                                                src="<?php echo base_url("assets"); ?>/images/user/3.jpg" alt=""
                                                data-original-title="" title="">
                            <div class="media-body">
                                <p><?php echo $active->proje_kodu; ?></p>
                            </div>
                        </div>
                        <p><?php echo tags($active->etiketler); ?></p>
                        <p><?php echo $active->department; ?></p>
                        <div class="row details">
                            <div class="col-6"><span>Sözleşme</span></div>
                            <div class="col-6 text-primary"><?php echo count_data("contract", "proje_id", $active->id); ?></div>
                            <div class="col-6"><span>İhale</span></div>
                            <div class="col-6 text-primary"><?php echo count_data("auction", "proje_id", $active->id); ?></div>
                            <div class="col-6"><span>Şantiye</span></div>
                            <div class="col-6 text-primary"><?php echo count_data("site", "proje_id", $active->id); ?></div>
                        </div>
                        <div class="customers">

                            <ul>
                                <?php $yetkililer = str_getcsv($active->yetkili_personeller); ?>
                                <?php foreach ($yetkililer as $yetkili) { ?>
                                    <li class="d-inline-block">
                                <span data-tooltip-location="top" data-tooltip="<?php echo full_name($yetkili); ?>">
                                    <img class="img-30 rounded-circle"  <?php echo get_avatar($yetkili); ?> data-tooltip="asd"
                                         alt="" data-original-title="" title=""></li>
                                    </span>
                                <?php } ?>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>

