<div class="fade tab-pane <?php if ($active_tab == "leader") {
    echo "active show";
} ?>"
     id="leader" role="tabpanel"
     aria-labelledby="leader-tab">

    <div class="content">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <p style="text-align:center; font-size:14pt;">
                        <strong><?php echo contract_name($item->contract_id); ?></strong>
                    </p>
                </div>
                <div class="col-12">
                    <p style="text-align:center; font-size:14pt;">
                        <strong>03/A - Pozlar İcmali</strong>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                </div>
                <div class="col-2">
                    <p style="text-align:right; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                        <strong>Hakediş No : <?php echo $item->hakedis_no; ?></strong>
                    </p>
                </div>
            </div>
            <hr>

            <table style="width:100%;">
                <tbody>
                <tr>
                    <td rowspan="2"
                        style="width:0.9cm;" class="calculate-header-center">
                        <p><strong>Sıra No</strong></p>
                    </td>
                    <td rowspan="2"
                        style="width:2cm;" class="calculate-header-center">
                        <p><strong>Poz No</strong></p>
                    </td>
                    <td rowspan="2"
                        style="width:6.8cm;" class="calculate-header-center">
                        <p><strong>Yapılan İşin Cinsi</strong></p>
                    </td>
                    <td rowspan="2"
                        style="width:1cm;" class="calculate-header-center">
                        <p><strong>Birimi</strong></p>
                    </td>
                    <td style="width:1.9cm;" class="calculate-header-center">
                        <p><strong>A</strong></p>
                    </td>
                    <td style="width:1.9cm;" class="calculate-header-center">
                        <p><strong>B</strong></p>
                    </td>
                    <td style="width:1.9cm;" class="calculate-header-center">
                        <p><strong>C</strong></p>
                    </td>
                    <td style="width:1.9cm;" class="calculate-header-center">
                        <p><strong>D=B-C</strong>
                        </p>
                    </td>
                    <td style="width:1.9cm;" class="calculate-header-center">
                        <p><strong>E=AxB</strong>
                        </p>
                    </td>
                    <td style="width:1.9cm;" class="calculate-header-center">
                        <p><strong>F=AxC</strong></p>
                    </td>
                    <td style="width:1.9cm;" class="calculate-header-center">
                        <p><strong>G=E-F</strong></p>
                    </td>
                </tr>
                <tr>
                    <td class="calculate-header-center">
                        <p><strong>Tekif Birim Fiyatı</strong></p>
                    </td>
                    <td class="calculate-header-center">
                        <p><strong>Toplam Miktarı</strong></p>
                    </td>
                    <td class="calculate-header-center">
                        <p><strong>Önceki Hakediş Miktarı</strong></p>
                    </td>
                    <td class="calculate-header-center">
                        <p><strong>Bu Hakediş Miktarı</strong></p>
                    </td>
                    <td class="calculate-header-center">
                        <p><strong>Toplam İmalat İhzarat</strong></p>
                    </td>
                    <td class="calculate-header-center">
                        <p><strong>Bir Önceki Tutarı</strong></p>
                    </td>
                    <td class="calculate-header-center">
                        <p><strong>Bu Hakediş</strong></p>
                    </td>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($leaders as $leader) { ?>
                    <tr>
                        <td class="w5c total-group-row-center">
                            <p><strong><?php echo $i++; ?></strong></p>
                        </td>
                        <td class="w10c total-group-row-center">
                            <p><strong><?php echo $leader->code; ?></strong></p>
                        </td>
                        <td class="w20c total-group-row-left">
                            <p><strong><?php echo $leader->name; ?></strong></p>
                        </td>
                        <td class="w5c total-group-row-center">
                            <p><strong><?php echo $leader->unit; ?></strong></p>
                        </td>
                        <td class="w10c total-group-row-center">
                            <p><strong><?php echo $leader->price . " " . $contract->para_birimi; ?> </strong></p>
                        </td>
                        <?php $calculate = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "leader_id" => $leader->id), "total" ); ?>
                        <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "leader_id" => $leader->id), "total"); ?>
                        <?php $this_total = !empty($calculate) ? $calculate : 0; ?>
                        <td class="total-group-row-right">
                            <?php echo money_format($old_total + $this_total); ?>
                        </td>
                        <td class="total-group-row-right">
                            <?php echo money_format($old_total); ?>
                        </td>
                        <td class="total-group-row-right">
                            <?php echo money_format($this_total); ?>
                        </td>
                        <td class="total-group-row-right">
                            <?php echo money_format(($old_total + $this_total) * $leader->price); ?>
                        </td>
                        <td class="total-group-row-right">
                            <?php echo money_format($old_total * $leader->price); ?>
                        </td>
                        <td class="total-group-row-right">
                            <?php echo money_format($this_total * $leader->price); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="card-body">
                <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                    <div class="h-100 checkbox-checked">
                        <h6 class="sub-title">03A - Pozlar İcmali</h6>
                        <div style="height: 100px;">
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="lead1"
                                       data-url="<?php echo base_url("payment/lead_hide_zero/$item->id"); ?>"
                                       type="radio" name="lead" value="lead" checked="">
                                <label class="form-check-label" for="lead1">Sıfır Olanları Gizle</label>
                            </div>
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="lead2"
                                       data-url="<?php echo base_url("payment/lead_all/$item->id"); ?>"
                                       type="radio" name="lead" value="lead">
                                <label class="form-check-label" for="lead2">Tümünü Yazdır</label>
                            </div>
                        </div>
                        <div class="form-check radio radio-success">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-success" name="lead"
                                                onclick="handleButtonClick(1)" type="button"><i
                                                    class="fa fa-download"></i>
                                            İndir
                                        </button>
                                        <button class="btn btn-outline-success" name="lead"
                                                onclick="handleButtonClick(0)" type="button"><i
                                                    class="fa fa-file-pdf-o"></i>Önizle
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