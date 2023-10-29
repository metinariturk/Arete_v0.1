<div class="fade tab-pane <?php if ($active_tab == "report") {
    echo "active show";
} ?>"
     id="report" role="tabpanel"
     aria-labelledby="report-tab">
    <?php if (empty($payment_settings)) { ?>
       Hakediş ayalarını yapın sonra gelin
    <?php } else { ?>
        <?php
        $sum_of_total_this_payment = 0;

        foreach ($calculates as $calculate) {
            $desiredKey = $calculate->boq_id;
            $price = null;

            array_map(function ($subarray) use ($desiredKey, &$price) {
                if (isset($subarray[$desiredKey]['price'])) {
                    $price = $subarray[$desiredKey]['price'];
                }
            }, $prices);

            if ($price !== null) {
                $total_this_payment = $price * $calculate->total;
                $sum_of_total_this_payment += $total_this_payment;
            }
        }
        ?>
        <?php $total_old_payment = sum_payments("E", $contract->id); ?>
        <div class="col-sm-8 offset-2">
            <table style="width: 18cm">
                <thead>
                <tr>
                    <th colspan="3" class="text-center"><p
                                style="font-weight: bold; font-size: 14pt; text-align: center">
                            HAKEDİŞ RAPORU</p></th>
                </tr>
                </thead>
                <tbody>
                <tr class="total-group-row-left">
                    <td colspan="2">İşin Adı: <?php echo mb_strtoupper(contract_name($contract->id)); ?></td>
                    <td style="text-align: right">Hakediş No:<?php echo $item->hakedis_no; ?> No lu</td>
                </tr>
                <tr>
                    <td class="total-group-row-left" colspan="3"
                        style="font-weight: bold; text-align: center"><?php echo $item->imalat_tarihi; ?>
                        TARİHİNE KADAR YAPILAN İŞİN
                    </td>
                </tr>
                <tr>
                    <td class="w-5 total-group-row-center">A</td>
                    <td class="total-group-row-left">Sözleşme Fiyatları İle Yapılan İşin Tutarı</td>
                    <td class="total-group-row-left">
                        <input type="number" step=".01" id="A" name="toplam"
                               value="<?php echo $total_old_payment + $sum_of_total_this_payment; ?>" readonly
                               onblur="calcular()"
                               onfocus="calcular()">
                    </td>
                </tr>
                <tr>
                    <td class="w-5 total-group-row-center">B</td>
                    <td class="total-group-row-left">Fiyat Farkı Tutarı</td>
                    <td class="total-group-row-left">
                        <input type="number" step=".01" id="B" name="fiyat_fark"
                               value=""
                               onblur="calcular()"
                               onfocus="calcular()">
                    </td>
                </tr>
                <tr>
                    <td class="w-5 total-group-row-center">C</td>
                    <td class="total-group-row-left" style="font-weight: bold">Toplam Tutar (A+B)</td>
                    <td class="total-group-row-left">
                        <input type="number" step=".01" id="C" name="genel_toplam"
                               value="" readonly
                               onblur="calcular()"
                               onfocus="calcular()">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left" colspan="3"></td>
                </tr>
                <tr>
                    <td class="w-5 total-group-row-center">D</td>
                    <td class="total-group-row-left">Bir Önceki Hakedişin Toplam Tutarı</td>
                    <td class="total-group-row-left">
                        <input type="number" step=".01" id="D" name="onceki_hak_top"
                               value="<?php echo $total_old_payment = $total_old_payment ?? 0; ?>"
                               readonly
                               onblur="calcular()"
                               onfocus="calcular()">
                    </td>
                </tr>
                <tr>
                    <td class="w-5 total-group-row-center">E</td>
                    <td class="total-group-row-left">Bu Hakedişin Tutarı (C-D)
                    </td>
                    <td class="total-group-row-left">
                        <input type="number" step=".01" id="E" name="bu_hak_top"
                               value="<?php echo $sum_of_total_this_payment; ?>"
                               onblur="calcular()" required
                               onfocus="calcular()">
                    </td>
                </tr>
                <tr>
                    <td class="w-5 total-group-row-center">F</td>
                    <td class="total-group-row-left">KDV (E x <select id="F_a" onblur="calcular()" onclick="calcular()"
                                                                      data-plugin="select2" name="kdv_oran">
                            <option value="<?php echo $payment_settings->kdv_oran; ?>">
                                %<?php echo $payment_settings->kdv_oran; ?></option>
                            <?php $oranlar = str_getcsv($settings->KDV_oran);
                            foreach ($oranlar as $oran) { ?>
                                <option value="<?php echo $oran; ?>">% <?php echo money_format($oran); ?></option>
                            <?php } ?>
                        </select> )
                    </td>
                    <td class="total-group-row-left">
                        <input id="F" type="number" step=".01" name="kdv_tutar" onblur="calcular()"
                               onfocus="calcular()"
                               readonly
                               value="<?php echo $payment_settings->kdv_oran * $boq->total / 100; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="w-5 total-group-row-center">G</td>
                    <td class="total-group-row-left" style="font-weight: bold">Tahakkuk Tutarı</td>
                    <td class="total-group-row-left">
                        <input type="number" step=".01" id="G" name="taahhuk"
                               value="<?php echo $payment_settings->kdv_oran * $boq->total / 100 + $boq->total; ?>"
                               onblur="calcular()" readonly
                               onfocus="calcular()">
                    </td>
                </tr>
                <tr>
                    <td rowspan="9"
                        style="-webkit-transform:rotate(180deg);text-align:center; writing-mode:tb-rl; border: 1px solid #a8b5cf;">
                        <p style="width: 20px; padding-left: 40px "><strong>KESİNTİLER VE MAHSUPLAR</strong></p>
                    </td>
                    <td class="total-group-row-left">a)Gelir / Kurumlar Vergisi (E x
                        <select id="KES_a_s" onblur="calcular()" onclick="calcular()"
                                data-plugin="select2" name="stopaj_oran">
                            <option value="<?php echo $payment_settings->stopaj_oran; ?>"
                                    onblur="calcular()" onfocus="calcular()">
                                %<?php echo money_format($payment_settings->stopaj_oran); ?>
                            </option>
                            <?php $oranlar = str_getcsv($settings->stopaj_oran);
                            foreach ($oranlar as $oran) { ?>
                                <option value="<?php echo $oran; ?>">% <?php echo money_format($oran); ?></option>";
                            <?php } ?>
                        </select>
                        )
                    </td>
                    <td class="total-group-row-left">
                        <input id="KES_a" type="number" step=".01" name="stopaj_tutar" onblur="calcular()"
                               readonly
                               onfocus="calcular()" onblur="calcular()"
                               value="<?php echo $payment_settings->stopaj_oran * $boq->total; ?>">

                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left">b)Damga Vergisi (E x
                        <select name="damga_oran" id="KES_b_s" onclick="calcular()"
                                onfocus="calcular()">
                            <option value="<?php echo $payment_settings->damga_vergisi_oran; ?>"
                                    onblur="calcular()" onfocus="calcular()">
                                ‰ <?php echo $payment_settings->damga_vergisi_oran; ?></option>
                            <?php $oranlar = str_getcsv($settings->damga_oran);
                            foreach ($oranlar as $oran) { ?>
                                <option value="<?php echo $oran; ?>">‰ <?php echo $oran; ?></option>";
                            <?php } ?>
                        </select>
                        )
                    </td>
                    <td class="total-group-row-left"><input id="KES_b" type="number" step=".01" name="stopaj_tutar"
                                                            onblur="calcular()"
                                                            readonly
                                                            onfocus="calcular()" onblur="calcular()"
                                                            value="<?php echo $payment_settings->damga_vergisi_oran * $boq->total; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left">c)KDV Tevkifatı (F x
                        <select name="damga_oran" id="KES_c_s" onclick="calcular()"
                                onfocus="calcular()">
                            <option value="<?php echo $payment_settings->tevkifat_oran; ?>"
                                    onblur="()" onfocus="calcular()">
                                <?php echo $payment_settings->tevkifat_oran; ?></option>
                            <?php $oranlar = str_getcsv($settings->kdv_tevkifat_oran);
                            foreach ($oranlar as $oran) { ?>
                                <option value="<?php
                                $oran_bol = explode("/", $oran);
                                if (count($oran_bol) == 2) {
                                    echo $oran_bol[0] / $oran_bol[1];
                                } else {
                                    echo 0;
                                } ?>"><?php echo $oran; ?></option>";
                            <?php } ?>
                        </select>
                        )
                    </td>
                    <td class="total-group-row-left">
                        <input id="KES_c" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               readonly
                               onfocus="calcular()"
                               value="<?php
                               $parcalar = explode("/", $payment_settings->tevkifat_oran);
                               if (count($parcalar) == 2) {
                                   echo $parcalar[0] / $parcalar[1] * $boq->total;
                               } else {
                                   echo 0;
                               } ?>">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left">d)Sosyal Sigortalar Kurumu Kesintisi</td>
                    <td class="total-group-row-left">
                        <input id="KES_d" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left">e)Geçici Kabul Kesintisi %
                        <input id="KES_e_s" type="number" step=".01" name=""
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                    <td class="total-group-row-left">
                        <input id="KES_e" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left">f)İdare Makinesi Kiraları</td>
                    <td class="total-group-row-left">
                        <input id="KES_f" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left">g)Gecikme Cezası</td>
                    <td class="total-group-row-left">
                        <input id="KES_g" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                </tr
                <tr>
                    <td class="total-group-row-left">h)İş Sağlığı ve Güvenliği Cezası</td>
                    <td class="total-group-row-left">
                        <input id="KES_h" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-left">i)Diğer</td>
                    <td class="total-group-row-left">
                        <input id="KES_i" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                </tr>

                <tr>
                    <td class="total-group-row-center">H</td>
                    <td class="total-group-row-left" style="font-weight: bold">Kesinti ve Mahsuplar Toplamı
                    </td>
                    <td class="total-group-row-left">
                        <input id="H" type="number" step=".01" name="stopaj_tutar"
                               onblur="calcular()"
                               onfocus="calcular()"
                               value="">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-center">I</td>
                    <td class="total-group-row-left" style="font-weight: bold">Avans Mahsubu<br>
                        <i>Toplam Verilen
                            Avans <?php echo money_format(sum_from_table("advance", "avans_miktar", $payment_settings->id)) . " " . get_currency($payment_settings->id); ?>
                        </i>
                        <br>
                        <i>Toplam Mahsup Edilen
                        </i>
                        <br>
                        <input type="number" step=".01" id="I_s" name="avans_mahsup_oran"
                               onblur="calcular()" onfocus="calcular()"
                               value="<?php echo $payment_settings->avans_oran; ?>">

                    </td>
                    <td class="total-group-row-left">
                        <input id="I" type="number" step=".01" name=""
                               onblur="calcular()"
                               onfocus="calcular()">
                    </td>
                </tr>
                <tr>
                    <td class="total-group-row-center"></td>
                    <td class="total-group-row-left" style="font-weight: bold">Yükleniciye Ödenecek Tutar (G-H-I)
                    </td>
                    <td class="total-group-row-left">
                        <input id="X" type="number" step=".01" name="total"
                               onblur="calcular()"
                               onfocus="calcular()"
                        >
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold; text-align: right" colspan="2">Yazıyla: Birmilyon Üçyüzyirmibeşbin
                        Beşyüzyirmiüç TL Elli Kr
                    </td>
                </tr>
                </tbody>
            </table>
            <a class="btn btn-primary" target="_blank"
               href="<?php echo base_url("payment/print_green/$item->id/0"); ?>">Önizleme</a>
            <a class="btn btn-primary" target="_blank"
               href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">Sıfır
                Olanları Gizle</a>
            <a class="btn btn-primary" target="_blank"
               href="<?php echo base_url("payment/print_green/$item->id/2"); ?>">Sadece
                Bu Hakediş</a>
        </div>
    <?php } ?>
</div>