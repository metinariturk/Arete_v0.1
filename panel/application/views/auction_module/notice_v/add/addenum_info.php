<div class="card">
    <div class="card-header">
        <div class="col-9">
            <h6 class="mb-0">
                <a href="<?php echo base_url("notice/file_form/$notice->id"); ?>" target="_blank">
                    İhale Yayın Dosyası
                </a>
                <a href="<?php echo base_url("notice/file_form/$notice->id"); ?>" target="_blank">
                    <p class="mb-0">
                        <?php echo $notice->dosya_no; ?>
                    </p>
                </a>
            </h6>
        </div>
    </div>
    <table class="table">
        <tr hidden>
            <td>
                <input name="notice_id" type="text" value="<?php echo $notice->id; ?>">
            </td>
        </tr>
        <tr>
            <td><strong>Dosyayı İndir</strong></td>
            <td><strong>:</strong></td>
            <td>    <?php if (empty($ilan->original_notice)) { ?>
                    <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                       data-text="Bu Poliçe"
                       data-note="İhale Dosyasını İndirmek İstiyor Musunuz"
                       data-url="<?php echo base_url("notice/download_notice/$notice->id"); ?>">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                <?php } else { ?>
                    <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)"
                       data-text="Bu Poliçe"
                       data-note="İhale Dosyasını İndirmek İstiyor Musunuz"
                       data-url="<?php echo base_url("notice/download_addendum/$notice->id"); ?>">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td><strong>İhale İlan Tarihi</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo dateFormat_dmy_hi($notice->ilan_tarih); ?></td>
        </tr>
        <tr>
            <td><strong>Askı Süresi</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo $notice->aski_sure; ?> Gün</td>
        </tr>
        <tr>
            <td><strong>Dosya Toplama Tarihi</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo dateFormat_dmy_hi($notice->son_tarih); ?></td>
        </tr>
        <tr>
            <td><strong>Onay</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo full_name($notice->onay); ?></td>
        </tr>
        <tr>
            <td style="width: 150px"><strong>Açıklama</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo $notice->aciklama; ?></td>
        </tr>
        <tr>
            <td style="width: 150px"><strong>İletişim</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo $notice->iletisim; ?></td>
        </tr>
    </table>
</div>





