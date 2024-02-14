<?php $user = get_active_user(); ?>
<form class="form-inline search-full col" action="<?php echo base_url("Dashboard/distributor"); ?>" id="distributor" method="post">
    <div class="form-group w-100">
        <div class="Typeahead Typeahead--twitterUsers">
            <div id="the-basics">
                <input class="typeahead" type="text" name="search"
                       placeholder="Proje - Sözleşme - Şantiye ve Teklifler İçinde Ara">
                <input type="submit" style="position: absolute; left: -9999px">
            </div>
        </div>
    </div>
</form>
<div class="nav-right col-8 pull-right right-header p-0">
    <ul class="nav-menus">
        <li>
            <span class="header-search"><i data-feather="search"></i></span></li>
        <li>
            <div class="mode">
                <a onclick="changeMode(this)"
                   url="<?php echo base_url("User/mode"); ?>"
                   id="myBtn">
                    <i class="fa fa-moon-o"></i>
                </a>
            </div>
        </li>
        <li class="maximize"><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                        data-feather="maximize"></i></a></li>
        <li class="profile-nav onhover-dropdown p-0 me-0">
            <div class="media profile-media"><img class="b-r-10" style="width: 35px;"
                                                  src="<?php echo get_side_avatar($user->id); ?>" alt="">
                <div class="media-body"><span><?php echo full_name($user->id); ?></span>
                    <p class="mb-0 font-roboto"><?php echo $user->profession; ?><br><?php echo $user->unvan; ?><i
                                class="middle fa fa-angle-down"></i></p>
                </div>
            </div>
            <ul class="profile-dropdown onhover-show-div">
                <li><a href="<?php echo base_url("user/file_form/$user->id"); ?>"><i data-feather="user"></i><span>Hesabım</span></a>
                </li>
                <li><a href="<?php echo base_url("logout"); ?>"><i data-feather="log-in"> </i><span>Oturumu Kapat</span></a>
                </li>
            </ul>
        </li>
    </ul>
</div>
