<div class="email-left-aside">
    <div class="card">
        <div class="card-body">
            <div class="email-app-sidebar left-bookmark">
                <ul class="nav main-menu" role="tablist">
                    <li></li>
                    <li class="nav-item"><span class="main-title">Detaylar</span></li>
                    <li><a id="genel-tab" data-bs-toggle="pill" href="#genel" role="tab"
                           aria-controls="genel" aria-selected="true"><span class="title">Genel Bilgiler</span></a>
                    </li>
                    <li><a id="report-tab" data-bs-toggle="pill" href="#report" role="tab"
                           aria-controls="report" aria-selected="true"><span class="title">Raporlar</span></a>
                    </li>
                    <?php if ($item->subcont != 1) { ?>
                        <li><a class="show" id="sitedel-tab" data-bs-toggle="pill"
                               href="#sitedel" role="tab" aria-controls="sitedel"
                               aria-selected="false">
                            <span class="title">
                                 Yer Teslimi
                            </span>
                                <span class="badge pull-right">
                                <?php if (!empty($item->sitedel_date)) { ?>
                                    <i class="icon-check"></i>
                                <?php } else { ?>
                                    <i class="icon-plus"></i>
                                <?php } ?>
                            </span>
                            </a>
                        </li>

                    <?php } ?>
                    <li><a class="show" id="workplan-tab" data-bs-toggle="pill" href="#workplan"
                           role="tab" aria-controls="workplan" aria-selected="false">
                            <span class="title">
                                 İş Programı
                            </span>
                            <span class="badge pull-right">
                                <?php if (!empty($item->workplan_payment)) { ?>
                                    <i class="icon-check"></i>
                                <?php } else { ?>
                                    <i class="icon-plus"></i>
                                <?php } ?>
                            </span>
                        </a>
                    </li>
                    <?php if ($item->avans_durum == 1) { ?>
                        <li><a class="show" id="avans-tab" data-bs-toggle="pill"
                               href="#avans" role="tab" aria-controls="avans"
                               aria-selected="false">
                            <span class="title">
                               Avans
                            </span>
                                <span class="badge pull-right">
                                (<?php echo count($advances) ?>)
                            </span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($item->subcont != 1) { ?>
                        <li><a class="show" id="teminat-tab" data-bs-toggle="pill"
                               href="#teminat" role="tab" aria-controls="teminat"
                               aria-selected="false">
                            <span class="title">
                                Teminatlar
                            </span>
                                <span class="badge pull-right">
                                (<?php echo count($bonds) ?>)
                            </span>
                            </a>
                        </li>
                    <?php } ?>
                    <li><a class="show" id="payment-tab" data-bs-toggle="pill"
                           href="#payment" role="tab" aria-controls="payment"
                           aria-selected="false">
                            <span class="title">
                                Hakedişler
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($payments) ?>)
                            </span>
                        </a>
                    </li>

                    <li><a class="show" id="boq-tab" data-bs-toggle="pill"
                           href="#boq" role="tab" aria-controls="boq"
                           aria-selected="false">
                            <span class="title">
                                Sözleşme Pozları
                            </span>
                        </a>
                    </li>


                    <li><a cdata-bs-toggle="pill"
                           href="<?php echo base_url("contract/file_form/$item->id/price"); ?>" role="tab"
                           aria-selected="false">
                            <span class="title">
                                Birim Fiyatlar
                            </span>
                        </a>
                    </li>

                    <?php if ($item->subcont != 1) { ?>
                        <li><a class="show" id="newprice-tab" data-bs-toggle="pill"
                               href="#newprice" role="tab" aria-controls="newprice"
                               aria-selected="false">
                            <span class="title">
                                Yeni Birim Fiyat
                            </span>
                                <span class="badge pull-right">
                                (<?php echo count($newprices) ?>)
                            </span>
                            </a>
                        </li>

                        <li><a class="show" id="costinc-tab" data-bs-toggle="pill"
                               href="#costinc" role="tab" aria-controls="costinc"
                               aria-selected="false">
                            <span class="title">
                                Keşif Artışı
                            </span>
                                <span class="badge pull-right">
                                (<?php echo count($costincs) ?>)
                            </span>
                            </a>
                        </li>

                        <li><a class="show" id="extime-tab" data-bs-toggle="pill"
                               href="#extime" role="tab" aria-controls="extime"
                               aria-selected="false">
                            <span class="title">
                                Süre Uzatımı
                            </span>
                                <span class="badge pull-right">
                                (<?php echo count($extimes) ?>)
                            </span>
                            </a>
                        </li>

                        <li><a class="show" id="provision-tab" data-bs-toggle="pill"
                               href="#provision" role="tab" aria-controls="provision"
                               aria-selected="false">
                            <span class="title">
                                Geçici Kabul
                            </span>
                                <span class="badge pull-right">
                                <?php if (!empty($item->provision_date)) { ?>
                                    <i class="icon-check"></i>
                                <?php } else { ?>
                                    <i class="icon-plus"></i>
                                <?php } ?>
                            </span>
                            </a>
                        </li>

                        <li><a class="show" id="final-tab" data-bs-toggle="pill"
                               href="#final" role="tab" aria-controls="final"
                               aria-selected="false">
                            <span class="title">
                                Kesin Kabul
                            </span>
                                <span class="badge pull-right">
                                <?php if (!empty($item->final_date)) { ?>
                                    <i class="icon-check"></i>
                                <?php } else { ?>
                                    <i class="icon-plus"></i>
                                <?php } ?>
                            </span>
                            </a>
                        </li>
                    <?php } ?>
                    <li><a class="show" id="catalog-tab" data-bs-toggle="pill"
                           href="#catalog" role="tab" aria-controls="catalog"
                           aria-selected="false">
                            <span class="title">
                                Katalog
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($catalogs) ?>)
                            </span>
                        </a>
                    </li>

                    <li><a class="show" id="catalog-tab" data-bs-toggle="pill"
                           href="#drawings" role="tab" aria-controls="drawings"
                           aria-selected="false">
                            <span class="title">
                                Diğer
                            </span>
                            <span class="badge pull-right">
                                (<?php echo count($drawings) ?>)
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
