<div data-url="<?php echo base_url("$this->Module_Name/refresh_condition_list/$item->id"); ?>"
     action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Condition"); ?>"
     id="dropzone_condition" class="dropzone"
     data-plugin="dropzone"
     data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Condition"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
        <h3>İdari Şartname Dokümanlarını Buraya Ekleyiniz</h3>
    </div>
</div>
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/condition_list_v"); ?>

<?php if (isset($idari)) { ?>
<div class="row">
    <div class="col-10">
        <h6>İdari Şartname Kriterleri</h6>
    </div>
    <div class="col-2">
        <a href="<?php echo base_url("Condition/update_form/$idari->id"); ?>"
           style="border: none; padding: 0; background: none;"
            <i class="fa fa-edit fa-2x"></i>
        </a>
    </div>
</div>

<table class="table">
    <tbody>
            <tr>
                <td class="w25"><b>Teklif Türü</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->teklif_turu; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>İş Bitirme</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->is_bitirme . $idari->para_birimi; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>İşin Türü</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->isin_turu; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>İşin Süresi</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->isin_suresi; ?> Gün</td>
            </tr>
            <tr>
                <td class="w25"><b>Benzer İş Grubu</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->benzer_is; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Müteahhit Sınıfı</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->muteahhit_sinif; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>KDV Oran</b></td>
                <td class="w5"><b>:</b></td>
                <td>% <?php echo $idari->kdv_oran; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Tevkifat Oran</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->tevkifat_oran; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Damga Oran</b></td>
                <td class="w5"><b>:</b></td>
                <td>‰ <?php echo $idari->damga_oran; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Stopaj Oran</b></td>
                <td class="w5"><b>:</b></td>
                <td>% <?php echo $idari->stopaj_oran; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Avans Durum</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo var_yok_name($idari->avans_durum); ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Avans Mahsup Oran</b></td>
                <td class="w5"><b>:</b></td>
                <td>% <?php echo $idari->avans_mahsup_oran; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>İhzarat Durum</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo var_yok_name($idari->ihzarat); ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Fiyat Farkı</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo var_yok_name($idari->fiyat_fark); ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Kesin Teminat Oran</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->teminat_oran; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Geçici Kabul Kesintisi</b></td>
                <td class="w5"><b>:</b></td>
                <td>% <?php echo $idari->gecici_kabul_kesinti; ?></td>
            </tr>
            <tr>
                <td class="w25"><b>Açıklama</b></td>
                <td class="w5"><b>:</b></td>
                <td><?php echo $idari->aciklama; ?></td>
            </tr>

    </tbody>
</table>
<?php } else { ?>

<div class="row">
    <div class="col-10">
        <h6>İdari Şartname Kriteri Ekleyiniz</h6>
    </div>
    <div class="col-2">
        <a href="<?php echo base_url("Condition/new_form/$item->id"); ?>"
           style="border: none; padding: 0; background: none;"

        <i class="fa fa-plus-square fa-2x"></i>
        </a>
    </div>
</div>
<?php } ?>