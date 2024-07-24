<?php $user = get_active_user(); ?>

<div class="header-logo-wrapper col-auto p-0">
    <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="<?php echo base_url("assets");?>/images/logo/logo.png" alt=""></a></div>
    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
</div>
<div class="left-header col horizontal-wrapper ps-0">
    <ul class="horizontal-menu">
        <div class="col-sm-12 d-flex justify-content-end">
            <div class="row">
                <div class="col-3 col-sm-3 col-md-3 d-flex justify-content-end">
                    <div class="mode">
                        <a onclick="changeMode(this)"
                           url="<?php echo base_url("User/mode"); ?>"
                           id="myBtn">
                            <i class="fa fa-moon-o" style="font-size: 1.66em;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-3 col-sm-3 col-md-3 d-flex justify-content-end">
                    <a href="#!" onclick="javascript:toggleFullScreen()"><i
                                data-feather="maximize"></i></a>
                </div>
                <div class="col-3 col-sm-3 col-md-3 d-flex justify-content-end" style="margin-top: -4px">
                    <a href="<?php echo base_url("user/file_form/$user->id"); ?>">
                        <img class="img-50 img-fluid m-r-20 rounded-circle update_img_1"
                            <?php echo get_avatar($user->id); ?> alt=""></a>
                </div>
                <div class="col-3 col-sm-3 col-md-3 d-flex justify-content-end">
                    <a href="<?php echo base_url("logout"); ?>"><i
                                data-feather="log-in"> </i></a>
                </div>
            </div>
        </div>
    </ul>
</div>
