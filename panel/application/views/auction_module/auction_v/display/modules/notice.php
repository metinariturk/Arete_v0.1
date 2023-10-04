<div class="col-sm-12 d-none d-sm-block">
    <table class="table content-container">
        <thead>
        <tr>
            <th class="w5"><i class="fa fa-reorder"></i></th>
            <th class="w10">Dosya No</th>
            <th class="w10">Türü</th>
            <th class="w20">Yayınlanma Tarihi</th>
            <th class="w5">Askı Süresi</th>
            <th class="w20">Yayından Kalkacağı Tarih</th>
            <th class="w5">
                <a class="pager-btn btn btn-info btn-outline"
                    <?php if (empty($ilanlar)) { ?>
                        disabled=""
                    <?php } else { ?>
                        onclick="page_forward(this)"
                        data-url="<?php echo base_url("notice/download_all/$item->id"); ?>"
                    <?php } ?>
                >
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>
            </th>
            <th class="w15">Teklif Yayını<br>Kapalı / Açık</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($ilanlar)) {
            foreach ($ilanlar as $ilan){ ?>
                <tr data-toggle="collapse" data-target="#_notice<?php echo $ilan->id; ?>" class="clickable"
                    id="center_row">
                    <td>
                        <a href="<?php echo base_url("notice/file_form/$ilan->id"); ?>">
                            <?php echo $ilan->id; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("notice/file_form/$ilan->id"); ?>">
                            <?php echo $ilan->dosya_no; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("notice/file_form/$ilan->id"); ?>">
                            <?php echo cms_isset($ilan->original_notice, "Zeyilname", "Teklif"); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("notice/file_form/$ilan->id"); ?>">
                            <?php echo dateFormat_dmy_hi($ilan->ilan_tarih); ?>
                        </a>

                    </td>
                    <td>
                        <a href="<?php echo base_url("notice/file_form/$ilan->id"); ?>">
                            <?php echo $ilan->aski_sure; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("notice/file_form/$ilan->id"); ?>">
                            <?php echo dateFormat_dmy_hi($ilan->son_tarih); ?>
                        </a>

                    </td>
                    <td>
                        <?php if (empty($ilan->original_notice)) { ?>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                               data-url="<?php echo base_url("notice/download_notice/$ilan->id"); ?>">
                                <i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                        <?php } else { ?>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                               data-url="<?php echo base_url("notice/download_addendum/$ilan->id"); ?>">
                                <i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                        <?php } ?>
                    </td>
                    <td>
                        <div class="media-body text-start icon-state switch-outline">
                            <label class="switch">
                                <input class="isActive"
                                       type="checkbox"
                                       name="notice"
                                       onclick="isActive(this)"
                                       data-url="<?php echo base_url("Notice/isActiveSetter/$ilan->id"); ?>"
                                    <?php echo ($ilan->isActive) ? "checked" : ""; ?>>
                                <span class="switch-state bg-primary"></span>
                            </label>
                        </div>
                    </td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>

<div class="col-12 d-sm-none">
    <table class="table content-container">
        <thead>
        <tr>
            <th class="w20">Yayınlanma Tarihi</th>
            <th class="w5">
                <a class="pager-btn btn btn-info btn-outline"
                    <?php if (empty($ilanlar)) { ?>
                        disabled=""
                    <?php } else { ?>
                        onclick="page_forward(this)"
                        data-url="<?php echo base_url("notice/download_all/$item->id"); ?>"
                    <?php } ?>
                >
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>
            </th>
            <th class="w15">Teklif Yayını<br>Kapalı / Açık</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($ilanlar)) {
            foreach ($ilanlar as $ilan){ ?>
                <tr data-toggle="collapse" data-target="#_notice<?php echo $ilan->id; ?>" class="clickable"
                    id="center_row">
                    <td>
                        <a href="<?php echo base_url("notice/file_form/$ilan->id"); ?>">

                            <?php echo cms_isset($ilan->original_notice, "Zeyilname", "Teklif"); ?><br>

                            <?php echo dateFormat_dmy($ilan->ilan_tarih); ?> <br>

                            <?php echo dateFormat_dmy($ilan->son_tarih); ?>
                        </a>
                    </td>
                    <td>
                        <?php if (empty($ilan->original_notice)) { ?>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                               data-url="<?php echo base_url("notice/download_notice/$ilan->id"); ?>">
                                <i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                        <?php } else { ?>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                               data-url="<?php echo base_url("notice/download_addendum/$ilan->id"); ?>">
                                <i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                        <?php } ?>
                    </td>
                    <td>
                        <div class="media-body text-start icon-state switch-outline">
                            <label class="switch">
                                <input class="isActive"
                                       type="checkbox"
                                       name="notice"
                                       onclick="isActive(this)"
                                       data-url="<?php echo base_url("Notice/isActiveSetter/$ilan->id"); ?>"
                                    <?php echo ($ilan->isActive) ? "checked" : ""; ?>>
                                <span class="switch-state bg-primary"></span>
                            </label>
                        </div>
                    </td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>




