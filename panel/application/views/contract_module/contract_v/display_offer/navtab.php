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

                    <li>
                        <a class="show" id="payment-tab" data-bs-toggle="pill"
                           href="#payment" role="tab" aria-controls="payment"
                           aria-selected="false">
                            <span class="title">
                                Yaklaşık Maliyet
                            </span>
                            <span class="badge pull-right">
                            </span>
                        </a>
                    </li>

                    <li><a class="show" id="boq-tab" data-bs-toggle="pill"
                           href="#boq" role="tab" aria-controls="boq"
                           aria-selected="false">
                            <span class="title">
                                İmalat Grupları
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



                </ul>
            </div>
        </div>
    </div>
</div>
