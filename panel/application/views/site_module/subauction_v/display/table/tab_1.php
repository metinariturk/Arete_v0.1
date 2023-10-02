<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="bg-color-op-green">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Proje Kodu / Adı</strong></div>
                    <div class="col-md-6">
                        <?php $proje_id = get_from_id("projects", "id", $item->proje_id); ?>
                        <a class="pull-left" data-tooltip-location="right" data-tooltip="Ana Projeyi Görütüle" class=""
                           href="<?php echo base_url("project/file_form/$proje_id"); ?>">
                            <?php echo get_from_id("projects", "proje_kodu", $item->proje_id); ?> /
                            <?php echo get_from_id("projects", "proje_ad", $item->proje_id); ?>
                        </a>
                    </div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Dosya No</strong></div>
                    <div class="col-md-6"><?php echo $item->dosya_no; ?></b></div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6 pull-left"><strong>İhale Adı</strong></div>
                    <div class="col-md-6"><?php echo $item->ihale_ad; ?></div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6 pull-left"><strong>İhale Yapan</strong></div>
                    <div class="col-md-6"><?php echo company_name($item->isveren); ?></div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Hedeflenen Tarih</strong></div>
                    <div class="col-md-6"><?php echo $item->talep_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->talep_tarih); ?></div>
                </div>
            </div>

            <hr>
            <div class="bg-color-op-green">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Bütçe</strong></div>

                    <div class="col-md-6">
                        <strong>
                            <?php echo money_format($item->butce) . " " . $item->para_birimi; ?>
                        </strong>
                    </div>
                </div>
            </div>
            <hr>
            <div class="bg-color-op-blue">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Yaklaşık Maliyet (Toplam)</strong></div>
                    <div class="col-md-1 pull-left">
                    </div>
                    <div class="col-md-6">
                        <strong>
                            <?php echo money_format(sum_anything("cost", "cost", "auction_id", "$item->id")) . " " . $item->para_birimi; ?>
                        </strong>
                    </div>
                </div>
                <?php if (!empty($ymler)) { ?>
                    <?php foreach ($ymler as $ym) { ?>
                        <div class="clearfix m-b-sm">
                            <div class="col-md-1 pull-left">
                            </div>
                            <div class="col-md-5 pull-left">
                                <strong><?php echo $ym->ym_grup . " (" . $ym->ym_ad . ")"; ?></strong>
                            </div>
                            <div class="col-md-6"><?php echo money_format($ym->cost) . " " . $item->para_birimi; ?></div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <hr>
            <div class="bg-color-op-yellow">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Açıklama</strong></div>

                    <div class="col-md-6">
                        <strong>
                            <?php echo $item->aciklama; ?>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-color-op-orange">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Yetkili Personeller</strong></div>
                    <div class="col-md-6">
                        <?php $personeller = get_as_array($item->yetkili_personeller);
                        foreach ($personeller as $personel) {
                            echo get_avatar($personel) . full_name($personel) . "<br>";
                        } ?></div>

                </div>
            </div>
            <hr>
            <div class="bg-color-op-purple">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Şartnameler</strong></div>
                    <div class="col-md-6"></div>
                </div>
                <?php if (!empty($sartnameler)) { ?>
                    <?php foreach ($sartnameler as $sartname) { ?>
                        <div class="clearfix m-b-sm">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <strong>
                                    <a href="<?php echo base_url("condition/file_form/$sartname->id"); ?>">
                                        <?php echo condition_type($sartname->condition_type); ?>
                                    </a>
                                </strong>
                            </div>
                            <div class="col-md-6"><?php echo dateFormat_dmy($sartname->createdAt); ?></div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <hr>
            <div class="bg-color-op-cyan">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Teşvik/Hibe</strong></div>
                    <div class="col-md-6"></div>
                </div>
                <?php if (!empty($tesvikler)) { ?>
                    <?php foreach ($tesvikler as $tesvik) { ?>
                        <div class="clearfix m-b-sm">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <strong>
                                    <a href="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>">
                                        <?php echo $tesvik->tesvik_grup; ?>
                                    </a>
                                </strong>
                            </div>
                            <div class="col-md-6"><?php echo $tesvik->tesvik_kurum; ?></div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <hr>
            <div class="bg-color-op-cyan">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>İhale Yayını</strong></div>
                    <div class="col-md-6"></div>
                </div>
                <?php if (!empty($ilanlar)) { ?>
                    <?php foreach ($ilanlar as $ilan) { ?>
                        <div class="clearfix m-b-sm">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <strong>
                                    <a href="<?php echo base_url("incentive/file_form/$ilan->id"); ?>">
                                        <?php //echo $ilan->tesvik_grup; ?>
                                    </a>
                                </strong>
                            </div>
                            <div class="col-md-6"><?php //echo $ilan->tesvik_kurum; ?></div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-color-op-green">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
            </div>
            <hr>
            <div class="bg-color-op-blue image_list_container">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
            </div>
        </div>
    </div>
</div>