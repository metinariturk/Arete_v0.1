<?php

$sidebarList = array(
    array(
        "title" => "Ana Sayfa",
        "icon" => "fas fa-home", // home -> fas fa-home
        "url" => base_url("dashboard")
    ),
    array(
        "title" => "Projeler",
        "icon" => "fas fa-project-diagram", // box -> fas fa-project-diagram (daha uygun bir ikon)
        "url" => base_url("project")
    ),
    array(
        "title" => "Sözleşmeler",
        "icon" => "fas fa-file-contract", // box -> fas fa-file-contract (daha uygun bir ikon)
        "url" => base_url("Contract")
    ),
    array(
        "title" => "Şantiye Yönetimi",
        "icon" => "fas fa-hard-hat", // triangle -> fas fa-hard-hat (daha uygun bir ikon)
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
                "title" => "Hava Durumu",
                "url" => base_url("Weather")
            )
        )
    ),
    array(
        "title" => "Personel Yönetimi",
        "icon" => "fas fa-users", // users -> fas fa-users
        "url" => base_url("user")
    ),
    array(
        "title" => "Araçlar",
        "icon" => "fas fa-wrench", // gear -> fas fa-wrench (veya fas fa-cog)
        "url" => "#",
        "submodules" => array(
            array(
                "title" => "Donatı Metrajı",
                "url" => base_url("Rebar")
            ),
            array(
                "title" => "AutoCAD Araçları",
                "url" => base_url("Template")
            )
        )
    ),
    array(
        "title" => "Firma Yönetimi",
        "icon" => "fas fa-building", // trello -> fas fa-building (daha uygun bir ikon)
        "url" => base_url("company")
    ),
    array(
        "title" => "Ayarlar",
        "icon" => "fas fa-cogs", // settings -> fas fa-cogs
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
        "icon" => "fas fa-sign-out-alt", // log-out -> fas fa-sign-out-alt
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
            <i class="<?php echo $module["icon"]; ?>"></i>
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