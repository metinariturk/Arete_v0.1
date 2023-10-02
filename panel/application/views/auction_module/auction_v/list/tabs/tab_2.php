<div class="tab-pane fade" id="top-prep" role="tabpanel" aria-labelledby="prep-top-tab">
    <div class="row">
        <?php foreach ($passive_items as $item) { ?>
            <?php $ilan = $this->Notice_model->get(array('auction_id' => $item->id)); ?>
            <?php $zeyil = $this->Notice_model->get(array(
                'auction_id' => $item->id,
                'original_notice >' => 0
            )); ?>
            <?php if (!isAdmin()) { ?>
                <?php $yetkili = auction_auth($item->id);
                if (in_array(active_user_id(), $yetkili)) { ?>
                    <div class="col-xxl-4 col-lg-6">
                        <div class="project-box">
                            <?php if (!empty($ilan)) { ?>
                                <?php if (remaining_day($ilan->son_tarih) >= 0) { ?>
                                    <span class="badge badge-warning">Yayında</span>
                                <?php } elseif (remaining_day($ilan->son_tarih) < 0) { ?>
                                    <span class="badge badge-danger">Yayından Kalktı</span>
                                <?php } ?>
                            <?php } elseif (empty($ilan)) { ?>
                                <span class="badge badge-primary">Hazırlık</span>
                            <?php } ?>
                            <h6>
                                <a href="<?php echo base_url("auction/file_form/$item->id"); ?>"><?php echo $item->ihale_ad; ?></a>
                            </h6>
                            <div class="media"><img class="img-20 me-1 rounded-circle"
                                                    src="<?php echo base_url("assets"); ?>/images/user/3.jpg" alt=""
                                                    data-original-title="" title="">
                                <div class="media-body">
                                    <p><?php echo $item->dosya_no; ?></p>
                                </div>
                            </div>
                            <p><?php echo $item->aciklama; ?></p>
                            <div class="row details">
                                <div class="col-6"><span>Bütçe </span></div>
                                <div class="col-6 text-primary"><?php echo money_format($item->butce) . " " . $item->para_birimi; ?></div>
                                <div class="col-6"><span>Yaklaşık Maliyet </span></div>
                                <div class="col-6 text-primary"><?php echo money_format(sum_anything("cost", "cost", "auction_id", "$item->id")) . " " . $item->para_birimi; ?></div>


                                <div class="col-6"><span>İhale Yayın Tarihi</span></div>

                                <div class="col-6 text-primary">
                                    <?php if (!empty($ilan)) { ?>
                                        <?php echo dateFormat_dmy($ilan->ilan_tarih); ?>
                                    <?php } ?>
                                </div>

                                <div class="col-6"><span>İhale Son Tarihi</span></div>
                                <div class="col-6 text-primary">
                                    <?php if (!empty($ilan)) { ?>
                                        <?php echo dateFormat_dmy($ilan->son_tarih); ?>
                                    <?php } ?>
                                </div>
                                <div class="col-6"><span>Zeyilname Tarihi</span></div>

                                <div class="col-6 text-primary">
                                    <?php if (!empty($zeyil)) { ?>
                                        <?php echo dateFormat_dmy($zeyil->ilan_tarih); ?>
                                    <?php } ?>
                                </div>
                                <div class="col-6"><span>Zeyilname Son Tarihi</span></div>
                                <div class="col-6 text-primary">
                                    <?php if (!empty($zeyil)) { ?>
                                        <?php echo dateFormat_dmy($zeyil->son_tarih); ?>
                                    <?php } ?>
                                </div>
                                <div class="col-6"><span>Toplam Askı Süresi</span></div>
                                <div class="col-6 text-primary">
                                    <?php echo sum_anything("notice", "aski_sure", "auction_id", "$item->id") . " Gün"; ?>
                                </div>
                            </div>
                            <div class="customers">
                                <ul>
                                    <?php $yetkililer = get_as_array($item->yetkili_personeller); ?>
                                    <?php foreach ($yetkililer as $yetkili) { ?>
                                        <li class="d-inline-block">
                                <span data-tooltip-location="top" data-tooltip="<?php echo full_name($yetkili); ?>">
                                    <img class="img-30 rounded-circle"  <?php echo get_avatar($yetkili); ?> data-tooltip="asd"
                                         alt="" data-original-title="" title=""></li>
                                        </span>
                                    <?php } ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-xxl-4 col-lg-6">
                    <div class="project-box">
                        <?php if (!empty($ilan)) { ?>
                            <?php if (remaining_day($ilan->son_tarih) >= 0) { ?>
                                <span class="badge badge-warning">Yayında</span>
                            <?php } elseif (remaining_day($ilan->son_tarih) < 0) { ?>
                                <span class="badge badge-danger">Yayından Kalktı</span>
                            <?php } ?>
                        <?php } elseif (empty($ilan)) { ?>
                            <span class="badge badge-primary">Hazırlık</span>
                        <?php } ?>
                        <h6>
                            <a href="<?php echo base_url("auction/file_form/$item->id"); ?>"><?php echo $item->ihale_ad; ?></a>
                        </h6>
                        <div class="media"><img class="img-20 me-1 rounded-circle"
                                                src="<?php echo base_url("assets"); ?>/images/user/3.jpg" alt=""
                                                data-original-title="" title="">
                            <div class="media-body">
                                <p><?php echo $item->dosya_no; ?></p>
                            </div>
                        </div>
                        <p><?php echo $item->aciklama; ?></p>
                        <div class="row details">
                            <div class="col-6"><span>Bütçe </span></div>
                            <div class="col-6 text-primary"><?php echo money_format($item->butce) . " " . $item->para_birimi; ?></div>
                            <div class="col-6"><span>Yaklaşık Maliyet </span></div>
                            <div class="col-6 text-primary"><?php echo money_format(sum_anything("cost", "cost", "auction_id", "$item->id")) . " " . $item->para_birimi; ?></div>


                            <div class="col-6"><span>İhale Yayın Tarihi</span></div>

                            <div class="col-6 text-primary">
                                <?php if (!empty($ilan)) { ?>
                                    <?php echo dateFormat_dmy($ilan->ilan_tarih); ?>
                                <?php } ?>
                            </div>

                            <div class="col-6"><span>İhale Son Tarihi</span></div>
                            <div class="col-6 text-primary">
                                <?php if (!empty($ilan)) { ?>
                                    <?php echo dateFormat_dmy($ilan->son_tarih); ?>
                                <?php } ?>
                            </div>
                            <div class="col-6"><span>Zeyilname Tarihi</span></div>

                            <div class="col-6 text-primary">
                                <?php if (!empty($zeyil)) { ?>
                                    <?php echo dateFormat_dmy($zeyil->ilan_tarih); ?>
                                <?php } ?>
                            </div>
                            <div class="col-6"><span>Zeyilname Son Tarihi</span></div>
                            <div class="col-6 text-primary">
                                <?php if (!empty($zeyil)) { ?>
                                    <?php echo dateFormat_dmy($zeyil->son_tarih); ?>
                                <?php } ?>
                            </div>
                            <div class="col-6"><span>Toplam Askı Süresi</span></div>
                            <div class="col-6 text-primary">
                                <?php echo sum_anything("notice", "aski_sure", "auction_id", "$item->id") . " Gün"; ?>
                            </div>
                        </div>
                        <div class="customers">
                            <ul>
                                <?php $yetkililer = get_as_array($item->yetkili_personeller); ?>
                                <?php foreach ($yetkililer as $yetkili) { ?>
                                    <li class="d-inline-block">
                                <span data-tooltip-location="top" data-tooltip="<?php echo full_name($yetkili); ?>">
                                    <img class="img-30 rounded-circle"  <?php echo get_avatar($yetkili); ?> data-tooltip="asd"
                                         alt="" data-original-title="" title=""></li>
                                    </span>
                                <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div></div>
