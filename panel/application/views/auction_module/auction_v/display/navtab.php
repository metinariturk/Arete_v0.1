<div class="email-left-aside">
    <div class="card">
        <div class="card-body">
            <div class="email-app-sidebar left-bookmark">
                <ul class="nav main-menu" role="tablist">
                    <li></li>
                    <li class="nav-item"><span class="main-title">Detaylar</span></li>
                    <li><a id="genel-tab" data-bs-toggle="pill" href="#genel" role="tab"
                           aria-controls="genel" aria-selected="true"><span
                                    class="title">Teklif Genel Bilgileri</span></a>
                    </li>
                    <li>
                        <a class="show" id="teknik-tab" data-bs-toggle="pill"
                           href="#teknik" role="tab" aria-controls="teknik"
                           aria-selected="false">
                            <span class="title">
                                Teknik Döküman
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($cizimler) ?>)
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="metraj-tab" data-bs-toggle="pill" href="#metraj"
                           role="tab" aria-controls="metraj" aria-selected="false">
                            <span class="title">
                              Metrajlar
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($metrajlar) ?>)
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="yaklasik-maliyet-tab" data-bs-toggle="pill"
                           href="#yaklasik-maliyet" role="tab" aria-controls="yaklasik-maliyet"
                           aria-selected="false">
                            <span class="title">
                              Yaklaşık Maliyet
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($ymler) ?>)
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="sartname-tab" data-bs-toggle="pill"
                           href="#sartname" role="tab" aria-controls="sartname"
                           aria-selected="false">
                            <span class="title">
                                Şartnameler
                            </span>
                            <span class="badge pull-right">
                                <?php if (!empty($idari_sart)) { ?>
                                    <i class="icon-check"></i>
                                <?php } else { ?>
                                    <i class="icon-plus"></i>
                                <?php } ?>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="tesvik-tab" data-bs-toggle="pill"
                           href="#tesvik" role="tab" aria-controls="tesvik"
                           aria-selected="false">
                            <span class="title">
                              Teşvik/Hibe
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($tesvikler) ?>)
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="yayin-tab" data-bs-toggle="pill"
                           href="#yayin" role="tab" aria-controls="yayin"
                           aria-selected="false">
                            <span class="title">
                            İlanlar
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($ilanlar) ?>)
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="istekliler-tab" data-bs-toggle="pill"
                           href="#istekliler" role="tab" aria-controls="istekliler"
                           aria-selected="false">
                            <span class="title">
                            İstekliler
                            </span>
                            <span class="badge pull-right">
                                (<?php if (isset($istekliler)) {
                                    echo count(json_decode($istekliler));
                                } else {
                                    echo "0";
                                } ?>)
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="show" id="yeterlilik-tab" data-bs-toggle="pill"
                           href="#yeterlilik" role="tab" aria-controls="yeterlilik"
                           aria-selected="false">
                            <span class="title">
                                Ön Yeterlilik
                            </span>
                            <span class="badge pull-right">
                                <?php if (!empty($item->yeterlilik)) { ?>
                                    <i class="icon-check"></i>
                                <?php } else { ?>
                                    <i class="icon-plus"></i>
                                <?php } ?>
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="show" id="offers-tab" data-bs-toggle="pill"
                           href="#offers" role="tab" aria-controls="offers"
                           aria-selected="false">
                            <span class="title">
                                Teklifler
                            </span>
                            <span class="badge pull-right">
                                <?php if (!empty($teklifler)) { ?>
                                    <i class="icon-check"></i>
                                <?php } else { ?>
                                    <i class="icon-plus"></i>
                                <?php } ?>
                            </span>
                        </a>
                    </li>
                    <li><a class="show" id="catalog-tab" data-bs-toggle="pill"
                           href="#catalog" role="tab" aria-controls="catalog"
                           aria-selected="false"><span class="title"> Katalog</span></a></li>
                    <li><a id="report-tab" data-bs-toggle="pill" href="#report" role="tab"
                           aria-controls="report" aria-selected="true"><span class="title">Raporlar</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
