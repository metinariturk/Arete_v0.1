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
                        <a class="show" id="offers-tab" data-bs-toggle="pill"
                           href="#offers" role="tab" aria-controls="offers"
                           aria-selected="false">
                            <span class="title">
                                Teklifler
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($offers) ?>)
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="catalog-tab" data-bs-toggle="pill"
                           href="#catalog" role="tab" aria-controls="catalog"
                           aria-selected="false">
                            <span class="title"> Katalog</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
