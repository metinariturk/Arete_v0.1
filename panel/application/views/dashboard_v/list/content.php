<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-4 box-col-6">
                <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                    <div class="email-left-aside">
                        <div class="card">
                            <div class="card-body">
                                <div class="email-app-sidebar left-bookmark">

                                    <ul class="nav main-menu" role="tablist">

                                        <hr>

                                        <li>
                                            <span class="main-title">Projeler</span>
                                        </li>

                                        <?php foreach ($favorites as $favorite) { ?>
                                            <?php if ($favorite->module == "project") { ?>
                                                <li>
                                                    <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>"
                                                       role="tab"
                                                       aria-controls="pills-<?php echo $favorite->module_id; ?>"
                                                       aria-selected="false"><span
                                                                class="title"> <?php echo $favorite->title; ?></span></a>
                                                </li>

                                            <?php } ?>
                                        <?php } ?>

                                        <hr>

                                        <li>
                                            <span class="main-title">Sözleşmeler</span>
                                        </li>

                                        <?php foreach ($favorites as $favorite) { ?>
                                            <?php if ($favorite->module == "contract") { ?>
                                                <li>
                                                    <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>"
                                                       role="tab"
                                                       aria-controls="pills-<?php echo $favorite->module_id; ?>"
                                                       aria-selected="false"><span
                                                                class="title"> <?php echo $favorite->title; ?></span></a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>

                                        <hr>

                                        <li>
                                            <span class="main-title">Şantiyeler
                                            </span>
                                        </li>

                                        <?php foreach ($favorites as $favorite) { ?>
                                            <?php if ($favorite->module == "site") { ?>
                                                <li>
                                                    <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>"
                                                       role="tab"
                                                       aria-controls="pills-<?php echo $favorite->module_id; ?>"
                                                       aria-selected="false"><span
                                                                class="title"> <?php echo $favorite->title; ?></span></a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                        <hr>

                                        <li>
                                            <span class="main-title">Hızlı Günlük Rapor</span>
                                        </li>

                                        <?php foreach ($favorites as $favorite) { ?>
                                            <?php if ($favorite->module == "site") { ?>
                                                <li>
                                                    <a href="<?php echo base_url("Report/new_form/$favorite->module_id"); ?>"
                                                       role="tab"
                                                       aria-controls="pills-<?php echo $favorite->module_id; ?>"
                                                       aria-selected="false"><span
                                                                class="title"> <?php echo $favorite->title; ?></span></a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-6">
                <div class="card">
                    <div class="cal-date-widget card-body">
                        <div class="cal-info text-center">
                            <h2><?php echo date("d"); ?></h2>
                            <div class="d-inline-block mt-2"><span
                                        class="b-r-dark pe-3"></span><?php echo ay_isimleri(date("m")); ?><span
                                        class="ps-3"><?php echo date("Y"); ?></span></div>
                            <p class="mt-4 f-16 text-muted">
                                <?php $idiom = random_idioms(); ?>
                                <?php echo get_from_any("idioms", "idiom", "id", $idiom); ?>
                            </p>
                            <p class="mt-3 f-14 text-muted" style="text-align: right">
                                <?php echo get_from_any("idioms", "owner", "id", $idiom); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <?php $this->load->view("{$viewFolder}/list/todo"); ?>
            </div>
        </div>
    </div>
</div>
