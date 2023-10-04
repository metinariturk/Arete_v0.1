<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="bg-color-op-green">
                <?php if (isset($project)) { ?>
                    <div class="clearfix m-b-sm">
                        <div class="col-md-6"><strong>Proje Kodu <br> Adı</strong></div>
                        <div class="col-md-6">
                            <a href="<?php echo base_url("project/file_form/$project->id"); ?>"><?php echo $project->proje_kodu; ?>
                                <br><?php echo $project->proje_ad; ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($auction)) { ?>
                    <div class="clearfix m-b-sm">
                        <div class="col-md-6"><strong>Teklif Kodu <br> Teklif Adı</strong></div>
                        <div class="col-md-6">
                            <a href="<?php echo base_url("auction/file_form/$auction->id"); ?>"><?php echo $auction->dosya_no . "<br>" . auction_name($auction->id); ?></a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($contract)) { ?>
                    <div class="clearfix m-b-sm">
                        <div class="col-md-6"><strong>Sözleşme Kodu <br> Sözleşme Adı</strong></div>
                        <div class="col-md-6">
                            <a href="<?php echo base_url("contract/file_form/$item->contract_id"); ?>"><?php echo contract_code($item->contract_id) . "<br>" . contract_name($item->contract_id); ?></a>
                        </div>
                    </div>
                <?php } ?>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Şantiye Kodu <br> Şantiye Adı</strong></div>
                    <div class="col-md-6">
                        <a href="<?php echo base_url("site/file_form/$item->site_id"); ?>"><?php echo get_from_any("site", "dosya_no", "id", "$item->site_id") . "<br>" . site_name($item->site_id); ?></a>
                    </div>
                </div>

                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Dosya No</strong></div>
                    <div class="col-md-6"><?php echo $item->dosya_no; ?></b></div>
                </div>
            </div>
            <hr>
            <div class="bg-color-op-blue">
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>İş Yeri Başlangıç Tarihi</strong></div>
                    <div class="col-md-6"><?php echo dateFormat_dmy($item->acilis_tarihi); ?></div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Sicil No</strong></div>
                    <div class="col-md-6"><?php echo $item->sicil_no; ?></div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>NACE Kodu</strong></div>
                    <div class="col-md-6"><?php echo $item->nace_kodu; ?></div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-6"><strong>Tehlike Sınıfı</strong></div>
                    <div class="col-md-6"><?php echo danger_class($item->danger_class); ?></div>
                </div>
                <?php if (isset($contract)) { ?>
                    <div class="clearfix m-b-sm">
                        <div class="col-md-6"><strong>Sözleşmeye Göre Bitiş</strong></div>
                        <div class="col-md-6"><?php echo dateFormat_dmy($contract->sozlesme_bitis); ?></div>
                    </div>
                    <?php if (!empty($extimes)) { ?>
                        <?php if (count($extimes) > 0) { ?>
                            <div class="clearfix m-b-sm">
                                <div class="col-md-6"><strong>Toplam Süre Uzatımı</strong></div>
                                <div class="col-md-6">
                                    <?php echo $sure_uzatim = sum_from_table("extime", "uzatim_miktar", $contract->id); ?>
                                    Gün
                                </div>
                            </div>
                            <div class="clearfix m-b-sm">
                                <div class="col-md-6"><strong>Süre Uzatımı Dahil Bitiş</strong></div>
                                <div class="col-md-6">
                                    <?php echo date_plus_days($contract->sozlesme_bitis, $sure_uzatim); ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>

            <hr>
            <div class="bg-color-op-grey">
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
            <div class="bg-color-op-purple">
                <div class="clearfix m-b-sm">
                    <div class="col-md-4"><strong>Şantiye Şefi</strong></div>
                    <div class="col-md-8"><?php echo get_avatar($site->santiye_sefi) . full_name($site->santiye_sefi); ?></div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-4"><strong>Teknik Personeller</strong></div>
                    <div class="col-md-8">
                        <?php
                        $teknik_personeller = get_as_array($site->teknik_personel);
                        foreach ($teknik_personeller as $personel) { ?>
                            <?php get_avatar($personel); ?>
                            <?php echo full_name($personel); ?>
                            <br>
                        <?php } ?>
                    </div>
                </div>
                <div class="clearfix m-b-sm">
                    <div class="col-md-4"><strong>İSG Personeller</strong></div>
                    <div class="col-md-8">
                        <?php
                        $isg_personeller = get_as_array($item->isg_personeller);
                        foreach ($isg_personeller as $personel) { ?>
                            <?php get_avatar($personel); ?>
                            <?php echo full_name($personel); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-color-op-purple">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
            </div>
            <hr>
            <div class="bg-color-op-blue image_list_container">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                <?php $main_files = get_as_array($settings->isg_main); ?>
                <?php foreach ($main_files as $main_file) { ?>
                    <?php echo $main_file; ?><br>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
