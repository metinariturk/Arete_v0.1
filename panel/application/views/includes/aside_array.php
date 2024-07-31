<?php

$sidebarList = array(
    array(
        "title" => "Ana Sayfa",
        "icon" => "home",
        "url" => base_url("dashboard")
    ),
    array(
        "title" => "Projeler",
        "icon" => "box",
        "url" => base_url("project")
    ),

    array(
        "title" => "Sözleşmeler",
        "icon" => "edit",
        "url" => base_url("contract")
    ),

    array(
        "title" => "Sözleşme Süreçleri",
        "url" => "#",
        "icon" => "edit-3",
        "submodules" => array(
            array(
                "title" => "Hakedişler",
                "url" => base_url("payment")
            ),
            array(
                "title" => "Hakediş Metrajları",
                "url" => base_url("boq")
            ),
            array(
                "title" => "Tahsilat İşlemleri",
                "url" => base_url("collection")
            ),
            array(
                "title" => "Avans İşlemleri",
                "url" => base_url("advance")
            ),
            array(
                "title" => "Teminat İşlemleri",
                "url" => base_url("Bond")
            ),
            array(
                "title" => "Keşif Artışı",
                "url" => base_url("Costinc")
            ),
            array(
                "title" => "Yeni Birim Fiyat",
                "url" => base_url("Newprice")
            ),
            array(
                "title" => "Süre Uzatımı",
                "url" => base_url("Extime")
            ),
            array(
                "title" => "Teknik Çizim ve Föy",
                "url" => base_url("Drawings")
            ),
            array(
                "title" => "Katalog",
                "url" => base_url("Catalog")
            ),

        )
    ),
    array(
        "title" => "Teklif Süreçleri",
        "icon" => "briefcase",
        "url" => "#",
        "submodules" => array(
            array(
                "title" => "Teklif Listesi",
                "url" => base_url("contract/offer_list")
            ),
            array(
                "title" => "Teklif Projeler",
                "url" => base_url("aucdraw")
            ),
            array(
                "title" => "Metrajlar",
                "url" => base_url("compute")
            ),
            array(
                "title" => "Yaklaşık Maliyet",
                "url" => base_url("Cost")
            ),
            array(
                "title" => "Şartnameler",
                "url" => base_url("Condition")
            ),
            array(
                "title" => "Teşvik Belgeleri",
                "url" => base_url("Incentive")
            ),
            array(
                "title" => "Teklif Yayınlama",
                "url" => base_url("Notice")
            ),
            array(
                "title" => "Teklif Teklifleri",
                "url" => base_url("Offer")
            )
        )
    ),

    array(
        "title" => "Şantiye Yönetimi",
        "icon" => "triangle",
        "url" => "#",
        "submodules" => array(
            array(
                "title" => "Şantiyeler",
                "url" => base_url("Site")
            ),
            array(
                "title" => "Günlük Rapor",
                "url" => base_url("Report")
            ),
            array(
                "title" => "İş Grupları",
                "url" => base_url("Workgroup")
            ),
            array(
                "title" => "İş Makineleri",
                "url" => base_url("Workmachine")
            ),
            array(
                "title" => "Şantiye Depo",
                "url" => base_url("Sitestock")
            ),
            array(
                "title" => "Hava Durumu",
                "url" => base_url("Weather")
            )        )
    ),

    array(
        "title" => "Personel Yönetimi",
        "icon" => "users",
        "url" => base_url("user")
    ),

    array(
        "title" => "Firma Yönetimi",
        "icon" => "trello",
        "url" => base_url("company")
    ),

    array(
        "title" => "Ayarlar",
        "icon" => "settings",
        "url" => "#",

        "submodules" => array(
            array(
                "title" => "Genel Ayarlar",
                "url" => base_url("settings")
            ),
            array(
                "title" => "E Posta Ayarlar",
                "url" => base_url("emailsettings")
            )
        )
    ),

    array(
        "title" => "ÇIKIŞ",
        "icon" => "log-out",
        "url" => base_url("logout")
    ),



);

foreach ($sidebarList as $module) { ?>
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title
        <?php if (empty($module["submodules"])) { ?>
                link-nav
        <?php } ?>
        "
           href="<?php echo $module["url"]; ?>">
            <i data-feather="<?php echo $module["icon"]; ?>"></i>
            <span><?php echo $module["title"]; ?></span>
        </a>
        <?php if (isset($module["submodules"])) { ?>
            <ul class="sidebar-submenu ">
                <?php foreach ($module["submodules"] as $submodule) { ?>
                    <li>
                        <a href="<?php echo $submodule["url"]; ?>"><?php echo $submodule["title"]; ?></a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </li>
<?php } ?>
