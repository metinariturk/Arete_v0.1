<div class="fade tab-pane <?php if ($active_tab == "report") {
    echo "active show";
} ?>"
     id="report" role="tabpanel"
     aria-labelledby="report-tab">
    <div class="col-sm-8 offset-2">
        <table style="width: 18cm">
            <thead>
            <tr>
                <th colspan="3" class="text-center"><p style="font-weight: bold; font-size: 14pt; text-align: center">
                        HAKEDİŞ RAPORU</p></th>
            </tr>
            </thead>
            <tbody>
            <tr style="font-weight: bold; font-size: 14pt; text-align: left">
                <td colspan="2">İşin Adı: <?php echo mb_strtoupper(contract_name($contract->id)); ?></td>
                <td style="text-align: right">Hakediş No:<?php echo $item->hakedis_no; ?> No lu</td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold; text-align: center"><?php echo $item->imalat_tarihi; ?>
                    TARİHİNE KADAR YAPILAN İŞİN
                </td>
            </tr>
            <tr>
                <td class="w-5">A</td>
                <td>Sözleşme Fiyatları İle Yapılan İşin Tutarı</td>
                <td></td>
            </tr>
            <tr>
                <td class="w-5">B</td>
                <td>Fiyat Farkı Tutarı</td>
                <td></td>
            </tr>
            <tr>
                <td class="w-5">C</td>
                <td style="font-weight: bold">Toplam Tutar (A+B)</td>
                <td>
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>D</td>
                <td>Bir Önceki Hakedişin Toplam Tutarı</td>
                <td><?php echo money_format((sum_payments("bu_imalat", $contract->id))) . " " . get_currency($contract->id); ?></td>
            </tr>
            <tr>
                <td>E</td>
                <td>Bu Hakedişin Tutarı (C-D)
                </td>
                <td>
                    <input type="number" step=".01" id="E" name="bu_imalat"
                           value="<?php echo $boq->total; ?>"
                           onblur="calcular()" required
                           onfocus="calcular()">
                </td>
            </tr>
            <tr>
                <td>F</td>
                <td>KDV (E x <select id="F_a" onblur="calcular()" onclick="calcular()"
                                     data-plugin="select2" name="kdv_oran">
                        <option value="<?php echo $contract->kdv_oran; ?>">
                            %<?php echo $contract->kdv_oran; ?></option>
                        <?php $oranlar = str_getcsv($settings->KDV_oran);
                        foreach ($oranlar as $oran) { ?>
                            <option value="<?php echo $oran; ?>">% <?php echo money_format($oran); ?></option>
                        <?php } ?>
                    </select> )
                </td>
                <td>
                    <input id="F" type="number" step=".01" name="kdv_tutar" onblur="calcular()"
                           onfocus="calcular()" onblur="calcular()"
                           readonly
                           value="<?php echo $contract->kdv_oran * $boq->total / 100; ?>">
                </td>
            </tr>
            <tr>
                <td>G</td>
                <td style="font-weight: bold">Tahakkuk Tutarı</td>
                <td>
                    <input type="number" step=".01" id="G" name="taahhuk"
                           value="<?php echo $contract->kdv_oran * $boq->total / 100 + $boq->total; ?>"
                           onblur="calcular()" readonly
                           onfocus="calcular()">
                </td>
            </tr>
            <tr>
                <td rowspan="8" style="-webkit-transform:rotate(180deg);text-align:center; writing-mode:tb-rl; ">
                    <p style="width: 20px; padding-left: 40px "><strong>KESİNTİLER VE MAHSUPLAR</strong></p>
                </td>
                <td>a)Gelir / Kurumlar Vergisi (E x
                    <select id="KES_a_s" onblur="calcular()" onclick="calcular()"
                            data-plugin="select2" name="stopaj_oran">
                        <option value="<?php echo $contract->stopaj_oran; ?>"
                                onblur="calcular()" onfocus="calcular()">
                            %<?php echo money_format($contract->stopaj_oran); ?>
                        </option>
                        <?php $oranlar = str_getcsv($settings->stopaj_oran);
                        foreach ($oranlar as $oran) { ?>
                            <option value="<?php echo $oran; ?>">% <?php echo money_format($oran); ?></option>";
                        <?php } ?>
                    </select>
                    )
                </td>
                <td>
                    <input id="KES_a" type="number" step=".01" name="stopaj_tutar" onblur="calcular()"
                           readonly
                           onfocus="calcular()" onblur="calcular()"
                           value="<?php echo $contract->stopaj_oran * $boq->total; ?>">

                </td>
            </tr>
            <tr>
                <td>b)Damga Vergisi (E x
                    <select name="damga_oran" id="KES_b_s" onclick="calcular()"
                            onfocus="calcular()">
                        <option value="<?php echo $contract->damga_oran; ?>"
                                onblur="calcular()" onfocus="calcular()">
                            ‰ <?php echo $contract->damga_oran; ?></option>
                        <?php $oranlar = str_getcsv($settings->damga_oran);
                        foreach ($oranlar as $oran) { ?>
                            <option value="<?php echo $oran; ?>">‰ <?php echo $oran; ?></option>";
                        <?php } ?>
                    </select>
                    )
                </td>
                <td><input id="KES_b" type="number" step=".01" name="stopaj_tutar" onblur="calcular()"
                           readonly
                           onfocus="calcular()" onblur="calcular()"
                           value="<?php echo $contract->damga_oran * $boq->total; ?>">
                </td>
            </tr>
            <tr>
                <td>c)KDV Tevkifatı (F x
                    <select name="damga_oran" id="KES_c_s" onclick="calcular()"
                            onfocus="calcular()">
                        <option value="<?php echo $contract->tevkifat_oran; ?>"
                                onblur="()" onfocus="calcular()">
                            <?php echo $contract->tevkifat_oran; ?></option>
                        <?php $oranlar = str_getcsv($settings->kdv_tevkifat_oran);
                        foreach ($oranlar as $oran) { ?>
                            <option value="<?php echo $oran; ?>"><?php echo $oran; ?></option>";
                        <?php } ?>
                    </select>
                    )
                </td>
                <td><input id="KES_c" type="number" step=".01" name="stopaj_tutar" onblur="()"
                           readonly
                           onfocus="calcular()" onblur="()"
                           value="<?php echo $contract->damga_oran * $boq->total; ?>">
                </td>
            </tr>
            <tr>
                <td>d)Sosyal Sigortalar Kurumu Kesintisi</td>
                <td></td>
            </tr>
            <tr>
                <td>e)Geçici Kabul Kesintisi</td>
                <td></td>
            </tr>
            <tr>
                <td>f)İdare Makinesi Kiraları</td>
                <td></td>
            </tr>
            <tr>
                <td>g)Gecikme Cezası</td>
                <td></td>
            </tr
            <tr>
                <td>h)İş Sağlığı ve Güvenliği Cezası</td>
                <td></td>
            </tr>
            <tr>
                <td>H</td>
                <td style="font-weight: bold">Kesinti ve Mahsuplar Toplamı
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="font-weight: bold">Yükleniciye Ödenecek Tutar (G-H)
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="font-weight: bold; text-align: right" colspan="2">Yazıyla: Birmilyon Üçyüzyirmibeşbin
                    Beşyüzyirmiüç TL Elli Kr
                </td>
            </tr>
            </tbody>
        </table>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/0"); ?>">Önizleme</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">Sıfır
            Olanları Gizle</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/2"); ?>">Sadece
            Bu Hakediş</a>
    </div>
</div>