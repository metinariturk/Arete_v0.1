<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="<?php echo base_url(); ?>"><img class="mg-fluid for-light"
                                      src="<?php echo base_url("assets"); ?>/images/logo/logo.png" alt=""><img
                        class="img-fluid for-dark" src="<?php echo base_url("assets"); ?>/images/logo/logo_dark.png" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper"><a href="<?php echo base_url(); ?>"><img class="img-fluid"
                                                                 src="<?php echo base_url("assets"); ?>/images/logo/logo-icon.png"
                                                                 alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="<?php echo base_url(); ?>"><img class="img-fluid"
                                                                   src="<?php echo base_url("assets"); ?>/images/logo/logo-icon.png"
                                                                   alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                              aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                                href="<?php echo base_url("dashboard"); ?>"><i data-feather="home"> </i><span>Ana Sayfa</span></a>
                    </li>


                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                                href="<?php echo base_url("project"); ?>"><i
                                    data-feather="box"> </i><span>Projeler</span></a></li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#"><i data-feather="briefcase"></i><span>İhale Süreçleri</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo base_url("auction"); ?>">İhale Listesi</a></li>
                            <li><a href="<?php echo base_url("aucdraw"); ?>">İhale Projeler</a></li>
                            <li><a href="<?php echo base_url("compute"); ?>">Metrajlar</a></li>
                            <li><a href="<?php echo base_url("Cost"); ?>">Yaklaşık Maliyet</a></li>
                            <li><a href="<?php echo base_url("Condition"); ?>">Şartnameler</a></li>
                            <li><a href="<?php echo base_url("Incentive"); ?>">Teşvik Belgeleri</a></li>
                            <li><a href="<?php echo base_url("Notice"); ?>">İhale Yayınlama</a></li>
                            <li><a href="<?php echo base_url("Offer"); ?>">İhale Teklifleri</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#"><i data-feather="edit-3"></i><span>Sözleşme Süreçleri</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo base_url("Contract"); ?>">Sözleşmeler</a></li>
                            <li><a href="<?php echo base_url("Subcontract"); ?>">Alt Sözleşmeler</a></li>
                            <li><a href="<?php echo base_url("Payment"); ?>">Hakedişler</a></li>
                            <li><a href="<?php echo base_url("advance"); ?>">Avans İşlemleri</a></li>
                            <li><a href="<?php echo base_url("Bond"); ?>">Teminat İşlemleri</a></li>
                            <li><a href="<?php echo base_url("Costinc"); ?>">Keşif Artışı</a></li>
                            <li><a href="<?php echo base_url("Newprice"); ?>">Yeni Birim Fiyat</a></li>
                            <li><a href="<?php echo base_url("Extime"); ?>">Süre Uzatımı</a></li>
                            <li><a href="<?php echo base_url("Drawings"); ?>">Teknik Çizim ve Föy</a></li>
                            <li><a href="<?php echo base_url("Catalog"); ?>">Katalog</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#"><i data-feather="triangle"></i><span>Şantiye Yönetimi</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo base_url("Site"); ?>">Şantiyeler</a></li>
                            <li><a href="<?php echo base_url("Report"); ?>">Günlük Rapor</a></li>
                            <li><a href="<?php echo base_url("Workgroup"); ?>">İş Grupları</a></li>
                            <li><a href="<?php echo base_url("Workmachine"); ?>">İş Makineleri</a></li>
                            <li><a href="<?php echo base_url("Sitestock"); ?>">Şantiye Depo</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#"><i data-feather="shield"></i><span>İSG</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo base_url("Safety"); ?>">İş Yerleri</a></li>
                            <li><a href="<?php echo base_url("Workman"); ?>">Personel İşlemleri</a></li>
                            <li><a href="<?php echo base_url("Education"); ?>">Eğitimler</a></li>
                            <li><a href="<?php echo base_url("Debit"); ?>">Zimmetler</a></li>
                            <li><a href="<?php echo base_url("Accident"); ?>">İş Kazaları</a></li>
                            <li><a href="<?php echo base_url("Checkup"); ?>">Sağlık Raporları</a></li>
                            <li><a href="<?php echo base_url("Report"); ?>">Puantaj</a></li>
                            <li><a href="<?php echo base_url("Workgroup"); ?>">İşe Giriş-Çıkış</a></li>
                            <li><a href="<?php echo base_url("Workmachine"); ?>">İSG Eğitim</a></li>
                            <li><a href="<?php echo base_url("Sitestock"); ?>">Zimmet Takip</a></li>
                            <li><a href="<?php echo base_url("Sitestock"); ?>">Saha Gözlem Raporu</a></li>
                            <li><a href="<?php echo base_url("Sitestock"); ?>">Kaza İşlemleri</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#"><i data-feather="shield"></i><span>Personel Yönetimi</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo base_url("user"); ?>">Sistem Kullanıcıları</a></li>
                            <li><a href="<?php echo base_url("user_roles"); ?>">Kullanıcı Yetkileri</a></li>
                            <li><a href="<?php echo base_url("fuel"); ?>">Yakıt Yönetimi</a></li>
                            <li><a href="<?php echo base_url("rent"); ?>">Kiralama Yönetimi</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#"><i data-feather="shield"></i><span>Araç/Filo Yönetimi</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo base_url("vehicle"); ?>">Araç Yönetimi</a></li>
                            <li><a href="<?php echo base_url("insurance"); ?>">Sigorta/Kasko Yönetimi</a></li>
                            <li><a href="<?php echo base_url("fuel"); ?>">Yakıt Yönetimi</a></li>
                            <li><a href="<?php echo base_url("rent"); ?>">Kiralama Yönetimi</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                                href="<?php echo base_url("company"); ?>"><i
                                    data-feather="box"> </i><span>Firma Yönetimi</span></a></li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#"><i data-feather="shield"></i><span>Ayarlar</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo base_url("settings"); ?>">Genel Ayarlar</a></li>
                            <li><a href="<?php echo base_url("emailsettings"); ?>">E Posta Ayarlar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
SSS