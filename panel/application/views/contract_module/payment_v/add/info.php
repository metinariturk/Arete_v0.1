<table class="table">
    <tbody>
    <tr>
        <td colspan="3">
            <h3 class="text-center">
                <strong>Hakediş Ayarları
                    <a data-tooltip-location="right" data-tooltip="Hakediş Ayarlarını Düzenle"
                       class="" href="<?php echo base_url("contract/update_form/$contract->id/tab5"); ?>">
                        <i class="menu-icon fa fa-edit fa-lg" aria-hidden="true"></i>
                    </a>
                </strong>
            </h3>
        </td>
    </tr>
    <tr>
        <td class="w60"><strong>Sözleşme Bedel</td>
        <td class="w5"><strong>:</strong></td>
        <td class="w35"><b><?php echo money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi; ?></b></td>
    </tr>
    <?php if (!empty(get_from_any("sitedel", "teslim_tarihi","contract_id",$contract->id))) { ?>
    <tr>
        <td><strong>Yer Teslim Tarihi</td>
        <td><strong>:</strong></td>
        <td><b><?php echo $yer_teslim = dateFormat("d-m-Y",get_from_any("sitedel", "teslim_tarihi","contract_id",$contract->id)); ?></b></td>
    </tr>
    <?php } ?>
    <?php if (!empty(get_from_contract_id_array("costinc", "$contract->id"))) {
        $kesifler = get_from_contract_id_array("costinc", "$contract->id"); ?>

        <?php $i = 0;
        foreach ($kesifler

                 as $kesif) {
            $i++; ?>
            <tr>
                <td class="col-md-5">
                    <strong><a href="<?php echo base_url("costinc/file_form/$kesif->id"); ?>">
                            <?php echo cms_if_echo($i, "1", "1", $i . ""); ?>. Keşif Artışı</a>
                    </strong>
                </td>
                <td><strong>:</strong></td>

                <td class="col-md-7">
                    <span><?php echo money_format($kesif->artis_miktar) . " " . $contract->para_birimi; ?></span>

                </td>
            </tr>
        <?php } ?>
        <tr>
            <td><strong>TOPLAM İŞ BEDELİ</td>
            <td><strong>:</strong></td>
            <td>
                <?php echo money_format(limit_cost($contract->id)). " " . $contract->para_birimi; ?>
            </td>
        </tr>
    <?php } ?>


    <tr>
        <td><strong>Fiyat Farkı</td>
        <td><strong>:</strong></td>
        <td>
            <?php cms_if_echo($contract->fiyat_fark, "1", "Var", "Yok"); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Fiyat Farkı Teminatı Kesintisi</td>
        <td><strong>:</strong></td>
        <td>
            <?php cms_if_echo($contract->fiyat_fark_teminat, "1", "Evet", "Hayır"); ?>
        </td>
    </tr>
    <tr>
        <td><strong>KDV (%)</td>
        <td><strong>:</strong></td>
        <td>
            % <?php echo $contract->kdv_oran; ?>
        </td>
    </tr>
    <tr>
        <td><strong>Tevkifat Oran</td>
        <td><strong>:</strong></td>

        <td>
            <?php echo cms_if_echo($contract->tevkifat_oran, null, "Seçilmemiş", "$contract->tevkifat_oran"); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Damga Vergisi (Binde)</td>
        <td><strong>:</strong></td>

        <td>
            ‰ <?php echo $contract->damga_oran; ?>
        </td>
    </tr>
    <tr>
        <td><strong>Damga Vergisi Kesintisi</td>
        <td><strong>:</strong></td>

        <td>
            <?php cms_if_echo($contract->damga_kesinti,"1","Var","Yok"); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Stopaj (%)</td>
        <td><strong>:</strong></td>

        <td>
            % <?php echo $contract->stopaj_oran; ?>
        </td>
    </tr>
    <tr>
        <td><strong>Stopaj Hesabında Avans Mahsubu Miktarı Düşülsün</td>
        <td><strong>:</strong></td>
        <td>
            <?php echo cms_if_echo($contract->avans_stopaj, "1", "Var", "Yok"); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Sözleşme Avans Durumu</td>
        <td><strong>:</strong></td>
        <td><?php cms_if_echo($contract->avans_durum, "1", "Var", "Yok"); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Varsa Avans Mahsup Oranı</td>
        <td><strong>:</strong></td>
        <td>% <?php echo $contract->avans_mahsup_oran; ?>
        </td>
    </tr>
    <tr>
        <td><strong>Verilen Toplam Avans</td>
        <td><strong>:</strong></td>
        <td><?php echo money_format(sum_from_table("advance", "avans_miktar", $contract->id)) . " " . get_currency($contract->id); ?>
        </td>
    </tr>
    <tr>
        <td><strong>İhzarat</td>
        <td><strong>:</strong></td>
        <td><?php cms_if_echo($contract->ihzarat, "1", "Var", "Yok"); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Geçici Kabul Teminat</td>
        <td><strong>:</strong></td>
        <td>
            % <?php echo $contract->teminat_oran; ?>
        </td>
    </tr>
    <tr>
        <td><strong>Hakedişte Geçici Kabul Kesintisi</td>
        <td><strong>:</strong></td>
        <td>
            <?php cms_if_echo($contract->gecici_kabul_kesinti, "1", "Var", "Yok"); ?>
        </td>
    </tr>
    </tbody>
</table>
