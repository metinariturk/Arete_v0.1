<div class="row">
    <div class="col-xl-3 xl-100 box-col-12">
        <div class="card">
            <p style="text-align: center; font-size: 15pt; font-weight: bold">Favoriler</p>
            <div class="categories pt-1">
                <div class="learning-header"><span class="f-w-600">Projeler</span></div>
                <ul>
                    <?php foreach ($favorites as $favorite) { ?>
                        <?php if ($favorite->module == "project") { ?>
                            <li>
                                <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>">
                                    <?php echo $favorite->title; ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="categories pt-0">
                <div class="learning-header"><span class="f-w-600">Sözleşmeler</span></div>
                <ul>
                    <?php foreach ($favorites as $favorite) { ?>
                        <?php if ($favorite->module == "contract") { ?>
                            <li>
                                <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>">
                                    <?php echo $favorite->title; ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="categories pt-0">
                <div class="learning-header"><span class="f-w-600">Teklifler</span></div>
                <ul>
                    <?php foreach ($favorites as $favorite) { ?>
                        <?php if ($favorite->module == "auction") { ?>
                            <li>
                                <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>">
                                    <?php echo $favorite->title; ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="categories pt-0">
                <div class="learning-header"><span class="f-w-600">Şantiyeler</span></div>
                <ul>
                    <?php foreach ($favorites as $favorite) { ?>
                        <?php if ($favorite->module == "site") { ?>
                            <li>
                                <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>">
                                    <?php echo $favorite->title; ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-xl-6 xl-100 box-col-12">
        <div class="card">
            <div class="cal-date-widget card-body">
                <div class="row">
                    <div class="col-xl-6 col-xs-12 col-md-6 col-sm-6">
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
                    <div class="col-xl-6 col-xs-12 col-md-6 col-sm-6">
                        <div class="cal-datepicker">
                            <div class="datepicker-here float-sm-end" data-language="tr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 xl-100 box-col-12">
        <div class="card">
            <div class="card-header">
                <h5>Not Defteri</h5>
            </div>
            <div class="card-body">
                <div class="todo">
                    <?php $this->load->view("{$viewFolder}/list/todo"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
