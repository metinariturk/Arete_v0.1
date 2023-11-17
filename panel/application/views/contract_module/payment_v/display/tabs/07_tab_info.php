<div class="fade tab-pane <?php if ($active_tab == "info") {
    echo "active show";
} ?>"
     id="info" role="tabpanel"
     aria-labelledby="info-tab">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2" style="border: 3px solid black; padding: 20px; ">
                <table class="" style="width: 100%;">
                    <thead>
                    <tr>
                        <th colspan="3" class="text-center">
                            HAKEDİŞ RAPORU
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width:49%; text-align: right; font-weight: bold">
                            Tarih
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left">
                            <?php echo dateFormat_dmy($item->imalat_tarihi); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: right; font-weight: bold">
                            No
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left">
                            <?php echo $item->hakedis_no; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Yapılan İşin Adı
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php echo $contract->sozlesme_ad; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Yapılan İşin Etüt / Proje No.su
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Yüklenicinin Adı / Ticari Unvanı
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php echo company_name($contract->yuklenici); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Sözleşme Bedeli
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php echo money_format($contract->sozlesme_bedel) . " " . $contract->para_birimi; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            İhale Tarihi
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            İhale Kom. Karar Tarihi ve No.su
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Sözleşme Tarihi ve No.su
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php echo dateFormat_dmy($contract->sozlesme_tarih); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            İşyeri Teslim Tarihi
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php echo dateFormat_dmy($contract->sitedel_date); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Sözleşmeye Göre İşin Süresi
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php echo $contract->isin_suresi; ?> Gün
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Sözleşmeye Göre İşin Bitim Tarihi
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php echo dateFormat_dmy($contract->sozlesme_bitis); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Verilen Avanslar Toplamı
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php $advance_given = sum_from_table("advance", "avans_miktar", $item->contract_id);
                            echo money_format($advance_given) . " " . $contract->para_birimi; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:49%; text-align: left; font-weight: bold; ">
                            Mahsubu Yapılan Avansın Toplam Tutarı
                        </td>
                        <td style="width:2%; text-align: center">:</td>
                        <td style="width:49%; text-align: left;">
                            <?php $sum_advance = $this->Payment_model->sum_all(array('contract_id' => $item->contract_id, "hakedis_no <=" => $item->hakedis_no), "I");
                            echo money_format($sum_advance) . " " . $contract->para_birimi; ?>

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table-bordered" style="margin-top: 30px;">
                    <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold; height: 15px; width: 25%;">Sözleşme Bedeli
                        </th>
                        <th style="text-align: center; font-weight: bold; height: 15px; width: 25%;">Sözleşme Artış
                            Onayının Tarih ve Nosu
                        </th>
                        <th style="text-align: center; font-weight: bold; height: 15px; width: 25%;">Ek Sözleşme
                            Bedeli
                        </th>
                        <th style="text-align: center; font-weight: bold; height: 15px; width: 25%;">Toplam Sözleşme
                            Bedeli
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    for ($i = 0; $i < 5; $i++) { ?>
                        <tr>
                            <td style="text-align: center; width: 25%;"></td>
                            <td style="text-align: center; width: 25%;"></td>
                            <td style="text-align: center; width: 25%;"></td>
                            <td style="text-align: center; width: 25%;"></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <br>
                <table class="table-bordered">
                    <thead>
                    <tr>
                        <th style="text-align:center; width: 30%" colspan="2">Süre Uzatım Kararlarının</th>
                        <th style="text-align:center; width: 20%" rowspan="2">Verilen Süre</th>
                        <th style="text-align:center; width: 25%" rowspan="2">İş Bitim Tarihi</th>
                        <th style="text-align:center; width: 25%" rowspan="2">Uzatım Sebebi</th>
                    </tr>
                    <tr>
                        <th style="text-align:center;">Sayısı</th>
                        <th style="text-align:center;">Karar Tarihi</th>
                    </tr>
                    </thead>
                    <tbody
                    <?php
                    for ($i = 0; $i < 5; $i++) { ?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                    <div class="h-100 checkbox-checked">
                        <h6 class="sub-title">07 - Hakediş Raporu (Kapak)</h6>
                        <div style="height: 50px;" hidden>
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="cover1"
                                       data-url="<?php echo base_url("payment/print_cover/$item->id"); ?>"
                                       type="radio" name="cover" value="cover" checked="">
                                <label class="form-check-label" for="cover1">Tümünü Yazdır</label>
                            </div>
                        </div>
                        <div class="form-check radio radio-success">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-success" name="cover"
                                                onclick="handleButtonClick(1)"
                                                type="button"><i class="fa fa-download"></i> İndir
                                        </button>
                                        <button class="btn btn-outline-success" name="cover"
                                                onclick="handleButtonClick(0)"
                                                type="button"><i class="fa fa-file-pdf-o"></i>Önizle
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

