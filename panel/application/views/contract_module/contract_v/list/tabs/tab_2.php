<div class="tab-pane fade" id="top-prep" role="tabpanel" aria-labelledby="prep-top-tab">
    <div class="row">
        <?php foreach ($passive_items as $item) { ?>
            <?php if (sum_from_table("extime", "uzatim_miktar", $item->id) > 0) {
                $bitis_tarihi = date_plus_days($item->sozlesme_bitis, (sum_from_table("extime", "uzatim_miktar", $item->id)));
                "<br>";
                $toplam_sure_uzatim = sum_from_table("extime", "uzatim_miktar", $item->id);
            } else {
                $bitis_tarihi = $item->sozlesme_bitis;
                "<br>";
                $toplam_sure_uzatim = 0;
            }
            $toplam_gun = $item->isin_suresi + $toplam_sure_uzatim;
            ?>
            <?php if (!isAdmin()) { ?>
                <?php $yetkili = contract_auth($item->id);
                if (in_array(active_user_id(), $yetkili)) { ?>
                    <div class="col-xxl-4 col-lg-6">
                        <div class="project-box">
                            <h6>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>"><?php echo $item->sozlesme_ad; ?></a>
                            </h6>
                            <div class="media"
                                <div class="media-body">
                                    <p><?php echo company_name($item->isveren); ?></p>
                                </div>
                            </div>
                            <div class="row details">
                                <div class="col-6"><span>İş Veren </span></div>
                                <div class="col-6 text-primary"><?php echo company_name($item->isveren); ?></div>
                                <div class="col-6"><span>Sözleşme Bedel </span></div>
                                <div class="col-6 text-primary"><?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></div>
                                <div class="col-6"><span>İşin Süresi</span></div>
                                <div class="col-6 text-primary"><?php echo $toplam_gun; ?></div>
                                <div class="col-6"><span>Yer Teslimi Tarihi</span></div>
                                <div class="col-6 text-primary">
                                    <?php echo dateFormat_dmy($item->sozlesme_tarih); ?>
                                </div>
                                <div class="col-6"><span>Bitiş Tarihi</span></div>
                                <div class="col-6 text-primary">
                                    <?php echo $item->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_bitis); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-xxl-4 col-lg-6">
                    <div class="project-box">
                        <h6>
                            <a href="<?php echo base_url("contract/file_form/$item->id"); ?>"><?php echo $item->sozlesme_ad; ?></a>
                        </h6>
                        <div class="media">
                            <div class="media-body">
                                <p><?php echo company_name($item->isveren); ?></p>
                            </div>
                        </div>
                        <div class="row details">
                            <div class="col-6"><span>İş Veren </span></div>
                            <div class="col-6 text-primary"><?php echo company_name($item->isveren); ?></div>
                            <div class="col-6"><span>Sözleşme Bedel </span></div>
                            <div class="col-6 text-primary"><?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></div>
                            <div class="col-6"><span>İşin Süresi</span></div>
                            <div class="col-6 text-primary"><?php echo $toplam_gun; ?></div>
                            <div class="col-6"><span>Yer Teslimi Tarihi</span></div>
                            <div class="col-6 text-primary">
                                <?php echo dateFormat_dmy($item->sozlesme_tarih); ?>
                            </div>
                            <div class="col-6"><span>Bitiş Tarihi</span></div>
                            <div class="col-6 text-primary">
                                <?php echo $item->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_bitis); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
