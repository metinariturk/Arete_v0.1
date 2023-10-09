<?php if (isset($idari_sart)) { ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <a href="<?php echo base_url("condition/file_form/$idari_sart->id"); ?>" target="_blank"><h6 class="mb-0"><?php echo $idari_sart->dosya_no?></h6></a>
            <p>Şarname Koşulları</p>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                <tr>
                    <td class="w50">KDV</td>
                    <td class="w50">
                        <span>% <?php echo $idari_sart->kdv_oran; ?></span>
                        <input hidden type="number" name="kdv_oran" value="<?php echo $idari_sart->kdv_oran; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Tevkifat Oran</td>
                    <td>
                        <span><?php echo $idari_sart->tevkifat_oran; ?></span>
                        <input hidden type="number" name="tevkifat_oran"
                               value="<?php echo $idari_sart->tevkifat_oran; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Damga Vergisi</td>
                    <td>
                        <span>‰ <?php echo $idari_sart->damga_oran; ?></span>
                        <input hidden type="number" name="damga_oran"
                               value="<?php echo $idari_sart->damga_oran; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Stopaj</td>
                    <td>
                        <span>% <?php echo $idari_sart->stopaj_oran; ?></span>
                        <input hidden type="number" name="stopaj_oran"
                               value="<?php echo $idari_sart->stopaj_oran; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Avans Ödemesi</td>
                    <td>
                        <span><?php echo var_yok_name($idari_sart->avans_durum); ?></span>
                        <input hidden type="number" name="avans_durum"
                               value="<?php echo $idari_sart->avans_durum; ?>">

                    </td>
                </tr>
                <tr>
                    <td>Avans Mahsup Oranı</td>
                    <td>
                        <span>% <?php echo $idari_sart->avans_mahsup_oran; ?></span>
                        <input hidden type="number" name="avans_mahsup_oran"
                               value="<?php echo $idari_sart->avans_mahsup_oran; ?>">
                    </td>
                </tr>
                <tr>
                    <td>İhzarat Ödemesi</td>
                    <td>
                        <span><?php echo var_yok_name($idari_sart->ihzarat); ?></span>
                        <input hidden type="number" name="ihzarat" value="<?php echo $idari_sart->ihzarat; ?>">

                    </td>
                </tr>
                <tr>
                    <td>Fiyat Farkı</td>
                    <td>
                        <span><?php echo var_yok_name($idari_sart->fiyat_fark); ?></span>
                        <input hidden type="number" name="fiyat_fark"
                               value="<?php echo $idari_sart->fiyat_fark; ?>">

                    </td>
                </tr>
                <tr>
                    <td>Geçici Kabul</td>
                    <td>
                        <span>% <?php echo $idari_sart->teminat_oran; ?></span>
                        <input hidden type="number" name="teminat_oran"
                               value="<?php echo $idari_sart->teminat_oran; ?>">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h6><p>Şarname Koşulları</p><h6>
                    &nbsp;
        </div>
        <div class="card-body">
            <a class="pager-btn btn btn-success btn-outline" href="<?php echo base_url("condition/new_form/$auction->id/1"); ?>" target="_blank" data-bs-original-title="" title="">
                <i class="menu-icon fa fa-plus" aria-hidden="true"></i> İdari Şartname Ekle
            </a>
        </div>
    </div>
</div>
<?php } ?>
