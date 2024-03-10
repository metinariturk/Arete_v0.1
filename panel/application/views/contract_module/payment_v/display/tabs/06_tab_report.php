<div class="fade tab-pane <?php if ($active_tab == "report") {
    echo "active show";
} ?>"
     id="report" role="tabpanel"
     aria-labelledby="report-tab">
    <?php if (empty($payment_settings)) { ?>
        <div class="alert alert-light-secondary" role="alert">
            <h5 class="alert-heading pb-2 txt-secondary">Finanasal kriterler belirlenmemiş</h5>
            <p>Hakediş girişi yapmadan önce hakediş hesabına esass finasnsal kriterleri belirlemeniz gerekir.</p>
            <hr>
            <p class="mb-0">Rapor sayfası otomatik olarak hesaplamaları yapacaktır</p>
            <a href="<?php echo base_url("payment/file_form/$item->id/settings"); ?>"><p class="mb-0">Ayarları yapmak
                    için tıklayınız.</p></a>
        </div>

    <?php } else { ?>
        <?php
        $all_boqs = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no));
        $this_payment_calculation_price = 0;
        foreach ($all_boqs as $boq) {
            $boq_price = get_from_any("contract_price", "price", "id", "$boq->boq_id");
            $calculation_price = $boq->total * $boq_price;
            $this_payment_calculation_price += $calculation_price;
        } ?>
        <?php $sum_old_B = $this->Payment_model->sum_all(array('contract_id' => $item->contract_id, "hakedis_no <" => $item->hakedis_no), "B"); ?>
        <?php $sum_old_contract_ff = $this->Payment_model->sum_all(array('contract_id' => $item->contract_id, "hakedis_no <" => $item->hakedis_no), "C"); ?>
        <?php $sum_old_advance = $this->Payment_model->sum_all(array('contract_id' => $item->contract_id, "hakedis_no <" => $item->hakedis_no), "I"); ?>
        <?php $sum_old_A = $this->Payment_model->sum_all(array('contract_id' => $item->contract_id, "hakedis_no <" => $item->hakedis_no), "A"); ?>
        <?php $sum_old_A1 = $this->Payment_model->sum_all(array('contract_id' => $item->contract_id, "hakedis_no <" => $item->hakedis_no), "A1"); ?>
        <?php $advance_given = sum_from_table("advance", "avans_miktar", $item->contract_id); ?>
        <div class="refresh_payment">
            <?php if (empty($item->A)) { ?>
                <div class="col-sm-8 offset-2">
                    <form id="save_payment"
                          action="<?php echo base_url("$this->Module_Name/save/$item->id"); ?>" method="post"
                          enctype="multipart/form-data" autocomplete="off">
                        <table style="width: 18cm">
                            <thead>
                            <tr>
                                <th colspan="3" class="text-center">
                                    <p style="font-weight: bold; font-size: 14pt; text-align: center">
                                        06 - HAKEDİŞ RAPORU (HESAP CETVELİ)
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="total-group-row-left">
                                <td colspan="2">İşin
                                    Adı: <?php echo mb_strtoupper(contract_name($contract->id)); ?></td>
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
                                <td class="total-group-row-left">Bu Hakediş Sözleşme Fiyatları İle Yapılan İşin Tutarı
                                </td>
                                <td class="total-group-row-left">
                                    <input type="number" step=".01" id="A" name="A"
                                           value="<?php echo isset($item->A) ? $item->A : $this_payment_calculation_price; ?>"
                                           readonly
                                           onblur="calcular()"
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">A1</td>
                                <td class="total-group-row-left">Önceki Hakedişler Sözleşme Fiyatları İle Yapılan İşin
                                    Tutarı
                                </td>
                                <td class="total-group-row-left">
                                    <input type="number" step=".01" id="A1" name="A1"
                                           value="<?php echo isset($item->A1) ? $item->A1 : $sum_old_A; ?>" readonly
                                           onblur="calcular()"
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">B</td>
                                <td class="total-group-row-left">Bu Hakediş Fiyat Farkı Tutarı</td>
                                <td class="total-group-row-left">
                                    <input type="number" step=".01" id="B" name="B"
                                           value="<?php echo isset($item->B) ? $item->B : null; ?>"
                                           onblur="calcular()"
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">B1</td>
                                <td class="total-group-row-left">Önceki Hakediş Fiyat Farkı Toplamı</td>
                                <td class="total-group-row-left">
                                    <input type="number" step=".01" id="B1" name="B1"
                                           readonly value="<?php echo isset($item->B1) ? $item->B1 : $sum_old_B; ?>"
                                           onblur="calcular()"
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">C</td>
                                <td class="total-group-row-left" style="font-weight: bold">Toplam Tutar (A+A1+B+B1)</td>
                                <td class="total-group-row-left">
                                    <input type="number" step=".01" id="C" name="C"
                                           readonly value="<?php echo isset($item->C) ? $item->C : null; ?>"
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
                                    <input type="number" step=".01" id="D" name="D"
                                           value="<?php echo isset($item->D) ? $item->D : $sum_old_B + $sum_old_A; ?>"
                                           readonly
                                           onblur="calcular()"
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">E</td>
                                <td class="total-group-row-left">Bu Hakedişin Tutarı (C-D)</td>
                                <td class="total-group-row-left">
                                    <input type="number" step=".01" id="E" name="E"
                                           value="<?php echo isset($item->E) ? $item->E : null; ?>"
                                           onblur="calcular()"
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">F</td>
                                <td class="total-group-row-left">KDV (E x <select id="F_a" onblur="calcular()"
                                                                                  onclick="calcular()"
                                                                                  data-plugin="select2" name="F_a">
                                        <option value="<?php echo isset($item->F_a) ? $item->F_a : $payment_settings->kdv_oran; ?>">
                                            %<?php echo isset($item->F_a) ? $item->F_a : $payment_settings->kdv_oran; ?></option>
                                        <?php $oranlar = str_getcsv($settings->KDV_oran);
                                        foreach ($oranlar as $oran) { ?>
                                            <option value="<?php echo $oran; ?>">
                                                % <?php echo money_format($oran); ?></option>
                                        <?php } ?>
                                    </select> )
                                </td>
                                <td class="total-group-row-left">
                                    <input id="F" type="number" step=".01" name="F" onblur="calcular()"
                                           onfocus="calcular()"
                                           value="<?php echo isset($item->F) ? $item->F : null; ?>"
                                           readonly
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">G</td>
                                <td class="total-group-row-left" style="font-weight: bold">Tahakkuk Tutarı</td>
                                <td class="total-group-row-left">
                                    <input type="number" step=".01" id="G" name="G"
                                           value="<?php echo isset($item->G) ? $item->G : null; ?>"
                                           onblur="calcular()" readonly
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="9"
                                    style="-webkit-transform:rotate(180deg);text-align:center; writing-mode:tb-rl; border: 1px solid #a8b5cf;">
                                    <p style="width: 20px; padding-left: 40px "><strong>KESİNTİLER VE MAHSUPLAR</strong>
                                    </p>
                                </td>
                                <td class="total-group-row-left">a)Gelir / Kurumlar Vergisi (E x
                                    <select id="KES_a_s" onblur="calcular()" onclick="calcular()"
                                            data-plugin="select2" name="KES_a_s">
                                        <option value="<?php echo isset($item->Kes_a_s) ? $item->Kes_a_s : $payment_settings->stopaj_oran; ?>"
                                                onblur="calcular()" onfocus="calcular()">
                                            %<?php echo isset($item->Kes_a_s) ? $item->Kes_a_s : $payment_settings->stopaj_oran; ?>
                                        </option>
                                        <?php $oranlar = str_getcsv($settings->stopaj_oran);
                                        foreach ($oranlar as $oran) { ?>
                                            <option value="<?php echo $oran; ?>">
                                                % <?php echo money_format($oran); ?></option>";
                                        <?php } ?>
                                    </select>
                                    )
                                </td>
                                <td class="total-group-row-left">
                                    <input id="KES_a" type="number" step=".01" name="KES_a"
                                           value="<?php echo isset($item->Kes_a) ? $item->Kes_a : null; ?>"
                                           onfocus="calcular()" onblur="calcular()"
                                           readonly
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">b)Damga Vergisi (E x
                                    <select name="KES_b_s" id="KES_b_s" onclick="calcular()"
                                            onfocus="calcular()">
                                        <option value="<?php echo isset($item->Kes_b_s) ? $item->Kes_b_s : $payment_settings->damga_vergisi_oran; ?>"
                                                onblur="calcular()" onfocus="calcular()">
                                            ‰ <?php echo isset($item->Kes_b_s) ? $item->Kes_b_s : $payment_settings->damga_vergisi_oran; ?></option>
                                        <?php $oranlar = str_getcsv($settings->damga_oran);
                                        foreach ($oranlar as $oran) { ?>
                                            <option value="<?php echo $oran; ?>">‰ <?php echo $oran; ?></option>";
                                        <?php } ?>
                                    </select>
                                    )
                                </td>
                                <td class="total-group-row-left">
                                    <input id="KES_b" type="number" step=".01" name="KES_b"
                                           value="<?php echo isset($item->Kes_b) ? $item->Kes_b : null; ?>"
                                           readonly
                                           onfocus="calcular()" onblur="calcular()"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">c)KDV Tevkifatı (F x
                                    <select name="KES_c_s" id="KES_c_s" onclick="calcular()"
                                            onfocus="calcular()">
                                        <option value="<?php echo isset($item->Kes_c_s) ? $item->Kes_c_s : $payment_settings->tevkifat_oran / 10; ?>"
                                                onblur="calcular()" onfocus="calcular()">
                                            <?php echo isset($item->Kes_c_s) ? $item->Kes_c_s * 10 : intval($payment_settings->tevkifat_oran); ?>
                                            /10
                                        </option>
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
                                    <input id="KES_c" type="number" step=".01" name="KES_c"
                                           onblur="calcular()"
                                           readonly
                                           onfocus="calcular()"
                                           value="<?php echo isset($item->Kes_c) ? $item->Kes_c : null; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">d)Sosyal Sigortalar Kurumu Kesintisi</td>
                                <td class="total-group-row-left">
                                    <input id="KES_d" type="number" step=".01" name="KES_d"
                                           value="<?php echo isset($item->Kes_d) ? $item->Kes_d : null; ?>"
                                           onblur="calcular()"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">e)Geçici Kabul Kesintisi %
                                    <input id="KES_e_s" type="number" step=".01" name="KES_e_s"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->Kes_e_s) ? $item->Kes_e_s : $payment_settings->gecici_teminat_oran; ?>"
                                           onfocus="calcular()">
                                </td>
                                <td class="total-group-row-left">
                                    <input id="KES_e" type="number" step=".01" name="KES_e"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->Kes_e) ? $item->Kes_e : null; ?>"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">f)İş Makinesi Kiraları</td>
                                <td class="total-group-row-left">
                                    <input id="KES_f" type="number" step=".01" name="KES_f"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->Kes_f) ? $item->Kes_f : null; ?>"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">g)Gecikme Cezası</td>
                                <td class="total-group-row-left">
                                    <input id="KES_g" type="number" step=".01" name="KES_g"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->Kes_g) ? $item->Kes_g : null; ?>"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr
                            <tr>
                                <td class="total-group-row-left">h)İş Sağlığı ve Güvenliği Cezası</td>
                                <td class="total-group-row-left">
                                    <input id="KES_h" type="number" step=".01" name="KES_h"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->Kes_h) ? $item->Kes_h : null; ?>"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">i)Diğer</td>
                                <td class="total-group-row-left">
                                    <input id="KES_i" type="number" step=".01" name="KES_i"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->Kes_i) ? $item->Kes_i : null; ?>"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr>

                            <tr>
                                <td class="total-group-row-center">H</td>
                                <td class="total-group-row-left" style="font-weight: bold">Kesinti ve Mahsuplar Toplamı
                                </td>
                                <td class="total-group-row-left">
                                    <input id="H" type="number" step=".01" name="H"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->H) ? $item->H : null; ?>"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-center">I</td>
                                <td class="total-group-row-left">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td style="font-weight: bold" colspan="2">Avans Mahsubu A x %
                                                <input type="number" step=".01" id="I_s" name="I_s"
                                                       onblur="calcular()" onfocus="calcular()"
                                                       value="<?php echo isset($item->I_s) ? $item->I_s : $payment_settings->avans_oran; ?>"
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Toplam Verilen Avans</td>
                                            <td><?php echo money_format($advance_given) . " " . get_currency($item->contract_id); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Önceki Hakediş Mahsup Edilen</td>
                                            <td><?php echo money_format($sum_old_advance) . " " . get_currency($item->contract_id); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kalan Avans</td>
                                            <td><?php echo money_format($advance_given - $sum_old_advance) . " " . get_currency($item->contract_id); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="total-group-row-left">
                                    <input id="I" type="number" step=".01" name="I"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->I) ? $item->I : null; ?>"
                                           onfocus="calcular()">
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-center"></td>
                                <td class="total-group-row-left" style="font-weight: bold">Yükleniciye Ödenecek Tutar
                                    (G-H-I)
                                </td>
                                <td class="total-group-row-left">
                                    <input id="X" type="number" step=".01" name="balance"
                                           onblur="calcular()"
                                           value="<?php echo isset($item->balance) ? $item->balance : null; ?>"
                                           onfocus="calcular()"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-weight: bold; text-align: right" colspan="2">Yazıyla:
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" id="submit_button"  onclick="calcular()">Kaydet</button>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            <?php } else { ?>
                <div class="col-sm-8 offset-2" style="overflow-x: auto; white-space: nowrap;">
                    <form id="save_payment"
                          action="<?php echo base_url("$this->Module_Name/empty_report/$item->id"); ?>" method="post"
                          enctype="multipart/form-data" autocomplete="off">
                        <table style="width: 18cm">
                            <thead>
                            <tr>
                                <th colspan="3" class="text-center">
                                    <p style="font-weight: bold; font-size: 14pt; text-align: center">
                                        06 - HAKEDİŞ RAPORU (HESAP CETVELİ)
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="total-group-row-left">
                                <td colspan="2">İşin
                                    Adı: <?php echo mb_strtoupper(contract_name($contract->id)); ?></td>
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
                                <td class="total-group-row-left">Bu Hakediş Sözleşme Fiyatları İle Yapılan İşin Tutarı
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->A); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">A1</td>
                                <td class="total-group-row-left">Önceki Hakedişler Sözleşme Fiyatları İle Yapılan İşin
                                    Tutarı
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->A1); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">B</td>
                                <td class="total-group-row-left">Bu Hakediş Fiyat Farkı Tutarı</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->B); ?><?php echo get_currency($item->contract_id); ?></span>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">B1</td>
                                <td class="total-group-row-left">Önceki Hakediş Fiyat Farkı Toplamı</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->B1); ?><?php echo get_currency($item->contract_id); ?></span>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">C</td>
                                <td class="total-group-row-left" style="font-weight: bold">Toplam Tutar (A+A1+B+B1)</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->C); ?><?php echo get_currency($item->contract_id); ?></span>

                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left" colspan="3"></td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">D</td>
                                <td class="total-group-row-left">Bir Önceki Hakedişin Toplam Tutarı</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->D); ?><?php echo get_currency($item->contract_id); ?></span>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">E</td>
                                <td class="total-group-row-left">Bu Hakedişin Tutarı (C-D)</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->E); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">F</td>
                                <td class="total-group-row-left">KDV (E x <span>%<?php echo $item->F_a; ?>)</span>

                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->F); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-5 total-group-row-center">G</td>
                                <td class="total-group-row-left" style="font-weight: bold">Tahakkuk Tutarı</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->G); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="9"
                                    style="-webkit-transform:rotate(180deg);text-align:center; writing-mode:tb-rl; border: 1px solid #a8b5cf;">
                                    <p style="width: 20px; padding-left: 40px "><strong>KESİNTİLER VE MAHSUPLAR</strong>
                                    </p>
                                </td>
                                <td class="total-group-row-left">a)Gelir / Kurumlar Vergisi (E
                                    x<span>%<?php echo $item->Kes_a_s; ?></span>)
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_a); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">b)Damga Vergisi (E
                                    x<span>%<?php echo $item->Kes_b_s; ?></span>)
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_b); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">c)KDV Tevkifatı (F
                                    x<span><?php echo $item->Kes_c_s * 10; ?></span>/10)
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_c); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">d)Sosyal Sigortalar Kurumu Kesintisi</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_d); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">e)Geçici Kabul Kesintisi %
                                    <span><?php echo $item->Kes_e_s; ?></span>
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_e); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">f)İş Makinesi Kiraları</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_f); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">g)Gecikme Cezası</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_g); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr
                            <tr>
                                <td class="total-group-row-left">h)İş Sağlığı ve Güvenliği Cezası</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_h); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-left">i)Diğer</td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->Kes_i); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="total-group-row-center">H</td>
                                <td class="total-group-row-left" style="font-weight: bold">Kesinti ve Mahsuplar Toplamı
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->H); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-center">I</td>
                                <td class="total-group-row-left">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td style="font-weight: bold" colspan="2">Avans Mahsubu A x %
                                                <span><?php echo $item->I_s; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Toplam Verilen Avans</td>
                                            <td><?php echo money_format($advance_given) . " " . get_currency($item->contract_id); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Önceki Hakediş Mahsup Edilen</td>
                                            <td><?php echo money_format($sum_old_advance) . " " . get_currency($item->contract_id); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kalan Avans</td>
                                            <td><?php echo money_format($advance_given - $sum_old_advance) . " " . get_currency($item->contract_id); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->I); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="total-group-row-center"></td>
                                <td class="total-group-row-left" style="font-weight: bold">Yükleniciye Ödenecek Tutar
                                    (G-H-I)
                                </td>
                                <td class="total-group-row-right">
                                    <span><?php echo money_format($item->balance); ?><?php echo get_currency($item->contract_id); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-weight: bold; text-align: right" colspan="2">
                                    Yazıyla:<?php echo yaziyla_para($item->balance); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="submit"
                                class="btn btn-success btn-block" style="text-align: right">
                            <i class="fas fa-broom"></i> Hakedişi Temizle
                        </button>
                    </form>
                </div>
            <?php } ?>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                    <div class="h-100 checkbox-checked">
                        <h6 class="sub-title">06 - Hakediş Raporu (Hesap Cetveli)</h6>
                        <div style="height: 50px;" hidden>
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="rep1"
                                       data-url="<?php echo base_url("payment/print_report/$item->id"); ?>"
                                       type="radio" name="report" value="report" checked="">
                                <label class="form-check-label" for="rep1">Tümünü Yazdır</label>
                            </div>
                        </div>
                        <div class="form-check radio radio-success">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-success" name="report"
                                                onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                            İndir
                                        </button>
                                        <button class="btn btn-outline-success" name="report"
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
    <?php } ?>
</div>
