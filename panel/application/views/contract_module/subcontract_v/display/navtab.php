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
