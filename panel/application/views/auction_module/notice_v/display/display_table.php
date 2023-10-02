<?php $yayin_durum = datetime_minus($item->ilan_tarih, date("m/d/Y")); ?>
<?php $son_gun_durum = datetime_minus($item->son_tarih, date("m/d/Y")); ?>
<table class="table">
    <tr>
        <td class="w-50"><strong>Yayın Durumu</strong><br>
            <small><?php cms_if_echo($item->isActive, "1", "Yayında", "Yayında Değil"); ?></small>
        </td>
        <td><strong>:</strong></td>
        <td>
            <?php if ($yayin_durum > 0) { ?>
                <b><?php $fark = yayin_kalan_sure($item->ilan_tarih); ?></b> Sonra
                <b><?php cms_if_echo($item->auto_air, "1", "Otomatik ", " Manuel"); ?></b>
                Olarak Yayınlanacak
            <?php } elseif ($son_gun_durum < 0) { ?>
                İhale Yayın Süresi Doldu
            <?php } else { ?>
                <div class="media-body text-start icon-state switch-outline">
                    <label class="switch">
                        <input class="isActive"
                               type="checkbox"
                               name="notice"
                               onclick="isActive(this)"
                               data-url="<?php echo base_url("Notice/isActiveSetter/$item->id"); ?>"
                            <?php echo ($item->isActive) ? "checked" : ""; ?>>
                        <span class="switch-state bg-primary"></span>
                    </label>
                </div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><strong>İhale Yayını Dosya No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td><strong>Zeyilname Dosyasını İndir</strong></td>
        <td><strong>:</strong></td>
        <td>
            <a href="<?php echo base_url("$this->Module_Name/download_all/$item->id"); ?>">
                <i class="fa fa-download f-18"></i>
            </a>
        </td>
    </tr>
    <tr>
        <td><strong>İhale Dosyasını İndir</strong></td>
        <td><strong>:</strong></td>
        <td>
            <a href="<?php echo base_url("$this->Module_Name/download_all/$item->original_notice"); ?>">
                <i class="fa fa-download f-18"></i>
            </a>
        </td>
    </tr>
    <tr>
        <td><strong>İhale İlan Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat_dmy_hi($item->ilan_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Askı Süresi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aski_sure; ?> Gün</td>
    </tr>
    <tr>
        <td><strong>Dosya Toplama Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat_dmy_hi($item->son_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Otomatik Yayınlanma</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo var_yok_name($item->auto_air); ?> </td>
    </tr>
    <tr>
        <td><strong>Otomatik Yayından Kaldırma</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo var_yok_name($item->auto_cancel_air); ?></td>
    </tr>
    <tr>
        <td><strong>Onay</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo full_name($item->onay); ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>İletişim</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->iletisim; ?></td>
    </tr>
</table>
</form>


