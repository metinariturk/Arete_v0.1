<?php $user = get_active_user(); ?>

<div class="header-wrapper row m-0">
    <div class="header-logo-wrapper col-auto p-0">
        <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                                                            src="<?php echo base_url("assets"); ?>/images/logo/logo.png"
                                                            alt=""></a>
        </div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle fas fa-align-left"></i></div>
    </div>

    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
        <ul class="nav-menus">

            <li>
                <div class="mode">
                    <a onclick="changeMode(this)"
                       url="<?php echo base_url("User/mode"); ?>"
                       id="myBtn">
                        <i class="fa fa-moon-o" style="font-size: 2em"></i>
                    </a>
                </div>
            </li>

            <li class="profile-nav onhover-dropdown pe-0 py-0">
                <div class="media profile-media">
                    <img class="img-50 img-fluid m-r-20 rounded-circle update_img_1"
                        <?php echo get_avatar($user->id); ?> alt="">
                    <div class="media-body"><span><?php echo $user->name . " " . $user->surname; ?></span>
                        <p class="mb-0"><?php echo $user->unvan; ?> <i class="fa fa-angle-down"></i></p>
                    </div>
                </div>

                <ul class="profile-dropdown onhover-show-div">
                    <li><a href="<?php echo base_url("user/file_form/$user->id"); ?>">
                            <i class="fas fa-user"></i><span>Hesabım </span></a></li>
                    <li><a href="<?php echo base_url("settings"); ?>">
                            <i class="fas fa-cogs"></i><span>Ayarlar</span></a></li>
                    <li><a href="<?php echo base_url("logout"); ?>">
                            <i class="fas fa-sign-in-alt"> </i><span> ÇIKIŞ YAP</span></a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
