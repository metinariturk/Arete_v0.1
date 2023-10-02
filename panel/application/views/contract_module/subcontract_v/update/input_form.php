<div class="widget">
    <div class="m-b-lg nav-tabs-horizontal">
        <!-- tabs list -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="<?php if ($active_tab == null) {echo "active";} ?>">
                <a href="#tab-1" aria-controls="tab-3" role="tab" data-toggle="tab">Genel Bilgiler
                    <?php $errors = array("dosya_no", "sozlesme_ad", "isveren", "yuklenici", "aciklama"); ?>
                    <?php if (isset($form_error)) {
                        $i = 0;
                        foreach ($errors as $error) {
                            if (!empty(form_error("$error"))) {
                                $i++;
                            }
                        }
                    } else {
                        $i = "";
                    }
                    ?>
                </a>
                <div class="text-center"><?php if ($i > 0) { ?> <i class="fa fa-exclamation-circle" style="color:red;"
                                                                   aria-hidden="true"></i> <?php echo $i;
                    } ?></div>
            </li>
            <li role="presentation"><a href="#tab-2" aria-controls="tab-1" role="tab" data-toggle="tab">Detay Bilgiler
                    <?php $errors = array("sozlesme_tarih", "sozlesme_turu", "isin_turu", "isin_suresi", "sozlesme_bedel", "para_birimi"); ?>
                    <?php if (isset($form_error)) {
                        $i = 0;
                        foreach ($errors as $error) {
                            if (!empty(form_error("$error"))) {
                                $i++;
                            }
                        }
                    }
                    ?>
                </a>
                <div class="text-center"><?php if ($i > 0) { ?>
                        <i class="fa fa-exclamation-circle" style="color:red;" aria-hidden="true"> </i> <?php echo $i;
                    } ?>
                </div>
            </li>
            <li role="presentation" >
                <a href="#tab-3" aria-controls="tab-2" role="tab" data-toggle="tab">
                    Adres ve Konum
                    <?php $errors = array("adres", "adress_city", "adress_district"); ?>
                    <?php if (isset($form_error)) {
                        $i = 0;
                        foreach ($errors as $error) {
                            if (!empty(form_error("$error"))) {
                                $i++;
                            }
                        }
                    }
                    ?>
                </a>
                <div class="text-center"><?php if ($i > 0) { ?> <i class="fa fa-exclamation-circle" style="color:red;"
                                                                   aria-hidden="true"></i> <?php echo $i;
                    } ?></div>
            </li>
            <li role="presentation" class="<?php if ($active_tab == "tab4") {echo "active";} ?>">
                <a href="#tab-4" aria-controls="tab-3" role="tab" data-toggle="tab">Personel
                    Atamaları</a></li>
            <li role="presentation"  class="<?php if ($active_tab == "tab4") {echo "active";} ?>">
                <a href="#tab-5" aria-controls="tab-4" role="tab" data-toggle="tab">Hakediş Ayarları
                    <?php $errors = array("kdv_oran", "tevkifat_oran", "damga_oran", "damga_kesinti", "stopaj_oran","avans_durum","avans_mahsup_durum","avans_mahsup_oran","avans_stopaj","ihzarat","fiyat_fark","fiyat_fark_teminat","teminat_oran","gecici_kabul_kesinti"); ?>
                    <?php if (isset($form_error)) {
                        $i = 0;
                        foreach ($errors as $error) {
                            if (!empty(form_error("$error"))) {
                                $i++;
                            }
                        }
                    } else {
                        $i = "";
                    }
                    ?>
                </a>
                <div class="text-center"><?php if ($i > 0) { ?> <i class="fa fa-exclamation-circle" style="color:red;"
                                                                   aria-hidden="true"></i> <?php echo $i;
                    } ?></div>
            </li>
        </ul><!-- .nav-tabs -->

        <!-- Tab panes -->
        <div class="tab-content p-md">
            <div role="tabpanel" class="tab-pane <?php if ($active_tab == null) {echo "in active";} ?> fade" id="tab-1">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/tab1"); ?>
            </div><!-- .tab-pane  -->

            <div role="tabpanel" class="tab-pane <?php if ($active_tab == "tab2") {echo "in active";} ?> fade"  id="tab-2">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/tab2"); ?>
            </div><!-- .tab-pane  -->

            <div role="tabpanel" class="tab-pane <?php if ($active_tab == "tab3") {echo "in active";} ?> fade"  id="tab-3">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/tab3"); ?>
            </div><!-- .tab-pane  -->

            <div role="tabpanel" class="tab-pane <?php if ($active_tab == "tab4") {echo "in active";} ?>  fade" id="tab-4">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/tab4"); ?>
            </div>

            <div role="tabpanel" class="tab-pane <?php if ($active_tab == "tab5") {echo "in active";} ?> fade"  id="tab-5">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/tab5"); ?>
            </div><!-- .tab-pane  -->
        </div><!-- .tab-content  -->
    </div><!-- .nav-tabs-horizontal -->
</div><!-- .widget -->
