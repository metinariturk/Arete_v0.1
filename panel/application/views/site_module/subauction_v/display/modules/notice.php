<div class="col-sm-10 col-sm-offset-1">
    <div class="text-center">
        <?php if (empty($ilanlar)) { ?>
            <h4>
                Teklif Yayınla
                <a data-tooltip-location="right" data-tooltip="Yeni Teklif İlanı veya Zeyilname" class=""
                   href="<?php echo base_url("notice/new_form/auction_display/$item->id"); ?>">
                    <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i> </a>
            </h4>
        <?php } ?>
        <table class="table">
            <thead>
            <tr>
                <th class="w5"><i class="fa fa-reorder"></i></th>
                <th class="w10">Dosya No</th>
                <th class="w10">Türü</th>
                <th class="w20">Yayınalama Tarihi</th>
                <th class="w5">Askı Süresi</th>
                <th class="w20">Yayından Kalkacağı Tarih</th>
                <th class="w5">
                    <a class="pager-btn btn btn-info btn-outline"
                        <?php if (empty($ilanlar)) { ?>

                            disabled=""
                        <?php } else { ?>
                       onclick="page_forward(this)"
                       <?php } ?>
                                  data-text="Bu Poliçe"
                                  data-note="Dosyayı İndirmek İstiyor Musunuz"
                                  data-url="<?php echo base_url("notice/download_not_add/$item->id"); ?>">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                </th>
                <th class="w20">İşlem</th>
                <th class="w15">Teklif Yayını<br>Kapalı / Açık</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($ilanlar)) { ?>
                <?php foreach ($ilanlar as $ilan) { ?>
                    <tr data-toggle="collapse" data-target="#_notice<?php echo $ilan->id; ?>" class="clickable"
                        id="center_row">
                        <td>
                            <a data-tooltip-location="right" data-tooltip="" class=""
                               href="">
                                <?php echo $ilan->id; ?>
                            </a>
                        </td>
                        <td><?php echo $ilan->dosya_no; ?></td>
                        <td><?php echo cms_isset($ilan->original_notice, "Zeyilname", "Teklif"); ?></td>
                        <td><?php echo dateFormat_dmy_hi($ilan->ilan_tarih); ?></td>
                        <td><?php echo $ilan->aski_sure; ?></td>
                        <td><?php echo dateFormat_dmy_hi($ilan->son_tarih); ?></td>
                        <td>
                            <?php if (empty($ilan->original_notice)) { ?>
                                <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                                   data-text="Bu Poliçe"
                                   data-note="Teklif Dosyasını İndirmek İstiyor Musunuz"
                                   data-url="<?php echo base_url("notice/download_notice/$ilan->id"); ?>">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                            <?php } else { ?>
                                <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                                   data-text="Bu Poliçe"
                                   data-note="Teklif Dosyasını İndirmek İstiyor Musunuz"
                                   data-url="<?php echo base_url("notice/download_addendum/$ilan->id"); ?>">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                        </td>
                        <?php if (empty($ilan->original_notice)) { ?>
                            <td>
                                <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                                   data-text="Bu Poliçe"
                                   data-note="Sayfadan Çıkmak Üzeresiniz"
                                   data-url="<?php echo base_url("notice/file_form/$ilan->id"); ?>">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                                </a>
                                <?php if (empty($ilan->original_notice)) { ?>
                                    <?php if (!empty($ilanlar)) { ?>
                                        <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                                           data-text="Bu Teklif İle İlgili Zeyilname Yayınlama"
                                           data-note="Sayfadan Çıkmak Üzeresiniz"
                                           data-url="<?php echo base_url("addendum/new_form/auction_display/$item->id/$ilan->id"); ?>">
                                            <i class="fa-brands fa-autoprefixer"></i> Zeyilname Yayınla
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if (!empty($ilan->original_notice)) { ?>
                            <td>
                                <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                                   data-text="Bu Poliçe"
                                   data-note="Sayfadan Çıkmak Üzeresiniz"
                                   data-url="<?php echo base_url("addendum/file_form/$ilan->id"); ?>">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                                </a>
                            </td>
                        <?php } ?>
                        <td>
                            <input
                                    data-url="<?php echo base_url("notice/isActiveSetter/$ilan->id"); ?>"
                                    class="isActive"
                                    type="checkbox"
                                    data-switchery
                                    data-color="#10c469"
                                <?php echo ($ilan->isActive) ? "checked" : ""; ?>
                            />
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-sm-2>">

</div>




