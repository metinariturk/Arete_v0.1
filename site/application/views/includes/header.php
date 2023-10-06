<!-- HEADER START -->
<header class="site-header header-style-1 mobile-sider-drawer-menu">
    <div class="top-bar bg-gray">
        <div class="container">
            <div class="row">
                <div class="mt-topbar-left">
                    <ul class="list-unstyled e-p-bx pull-right">
                        <li><a href="mailto:someone@example.com" class="text-black-50"><i class="fa fa-envelope"></i>bilgi@aretemuhendislik.com.tr</a></li>
                        <li><a class="text-black-50" href="tel:+903325014414"><i class="fa fa-phone"></i>+90 332 501 44 14</li></a>
                        <li><a class="text-black-50" href="tel:+905452344264"><i class="fa fa-phone"></i>+90 545 234 42 64</li></a>
                    </ul>
                </div>
                <div class="mt-topbar-right">
                    <div class="appint-btn"><a href="#" class="contact-slide-show"><div class="site-button">Görüşme Talep Et</div></a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-header main-bar-wraper">
        <div class="main-bar bg-white">
            <div class="container">
                <div class="logo-header">
                    <div class="logo-header-inner logo-header-one">
                        <a href="index.html">
                            <img src="<?php echo base_url("assets"); ?>/images/logo-light.png" alt="" />
                        </a>
                    </div>
                </div>
                <!-- NAV Toggle Button -->
                <button id="mobile-side-drawer" data-target=".header-nav" data-toggle="collapse" type="button" class="navbar-toggler collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar icon-bar-first"></span>
                    <span class="icon-bar icon-bar-two"></span>
                    <span class="icon-bar icon-bar-three"></span>
                </button>
                <!-- ETRA Nav -->
                <!-- ETRA Nav -->

                <?php $this->load->view("includes/contact_nav"); ?>
                <!-- SITE Search -->
                <div id="search">
                    <span class="close"></span>
                    <form role="search" id="searchform" action="/search" method="get" class="radius-xl">
                        <div class="input-group">
                            <input value="" name="q" type="search" placeholder="Type to search"/>
                            <span class="input-group-btn"><button type="button" class="search-btn"><i class="fa fa-search arrow-animation"></i></button></span>
                        </div>
                    </form>
                </div>
                <!-- MAIN Vav -->
                <div class="header-nav navbar-collapse collapse">
                    <ul class=" nav navbar-nav">
                        <li class="active">
                            <a href="#">AnaSayfa</a>
                        </li>

                        <li>
                            <a href="about-1.html">Hakkımızda</a>
                        </li>

                        <li>
                            <a href="javascript:;">Hizmetler</a>
                            <ul class="sub-menu">
                                <li><a href="post-image.html">Üst Yapı</a></li>
                                <li><a href="post-gallery.html">Atık Su ve Yağmur Suyu</a></li>
                                <li><a href="post-video.html">Akaryakıt İstasyonu</a></li>
                                <li><a href="post-right-sidebar.html">Yol İnşaatı</a></li>
                            </ul>
                        </li>
                        <li class="submenu-direction">
                            <a href="<?php echo base_url("panel");?>">KULLANICI PANELİ</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</header>
<!-- HEADER END -->