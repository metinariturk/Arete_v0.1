<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <h3 class="text-center">
                <div id="puantajDate" url="<?php echo base_url("Site/puantaj_date/$item->id"); ?>">
                    <select onchange="puantajDate(this)" id="month" name="month">
                        <option  selected value="<?php echo $month; ?>"><?php echo ay_isimleri($month); ?></option>
                        <option  value="01">Ocak</option>
                        <option  value="02">Şubat</option>
                        <option  value="03">Mart</option>
                        <option  value="04">Nisan</option>
                        <option  value="05">Mayıs</option>
                        <option  value="06">Haziran</option>
                        <option  value="07">Temmuz</option>
                        <option  value="08">Ağustos</option>
                        <option  value="09">Eylül</option>
                        <option  value="10">Ekim</option>
                        <option  value="11">Kasım</option>
                        <option  value="12">Aralık</option>
                    </select>
                    <select onchange="puantajDate(this)" name="year" id="year">
                        <option  selected><?php echo $year; ?></option>
                        <option  ><?php echo $year-1; ?></option>
                        <option  ><?php echo $year-2; ?></option>
                        <option  ><?php echo $year-3; ?></option>
                        <option  ><?php echo $year-4; ?></option>
                        <option  ><?php echo $year-5; ?></option>
                    </select>
                </div>
                <a href="#" onclick="sendFormData(this)">Form Verilerini Gönder</a>
            </h3>
            <table class="table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Adı Soyadı</th>
                    <th>Ekip</th>
                    <?php for ($j = 1;
                               $j <= gun_sayisi();
                               $j++): ?>
                        <th><?php echo $j; ?></th>
                    <?php endfor; ?>
                    <th>Toplam</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $count_of_days = get_days_in_month($year, $month);
                foreach ($personel_datas as $personel_data) { ?>
                    <tr>
                        <td> <?php echo $i++; ?></td>
                        <td> <?php echo $personel_data->name_surname; ?></td>
                        <td> <?php echo group_name($personel_data->group); ?></td>
                        <?php

                        for ($j = 1; $j <= gun_sayisi(); $j++): ?>
                            <?php $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT); ?>
                            <td>
                                <div>
                                    <input type="checkbox"
                                           name="isChecked"
                                           onclick="savePuantaj(this)"
                                           style="margin: 6px; padding: 6px;"
                                           workerid="<?php echo $personel_data->id; ?>"
                                           date="<?php echo $year . "-" . $month . "-" . $j; ?>"
                                        <?php if (isset($puantaj_data[$j_double_digit]) && in_array($personel_data->id, $puantaj_data[$j_double_digit])) {
                                            echo "checked"; // Checkbox işaretlenmişse checked özniteliğini ekle
                                        } ?>
                                    >
                                </div>
                            </td>
                        <?php endfor; ?>
                        <td>
                            <?php
                            if (isset($puantaj_data)) {
                                $value_to_count = $personel_data->id;

                                // Toplam sayacı başlat
                                $count_of_value = 0;

                                // Her bir alt dizi için kontrol edelim
                                foreach ($puantaj_data as $sub_array) {
                                    // Eğer değer alt dizide bulunuyorsa, sayaca ekleyelim
                                    if (in_array($value_to_count, $sub_array)) {
                                        // Değerin sayısını alt dizide say
                                        $count_of_value += array_count_values($sub_array)[$value_to_count];
                                    }
                                }
                                echo $count_of_value;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <?php if (isset($puantaj_data)) { ?>
                    <tr>
                        <td colspan="3">
                            Toplam
                        </td>
                        <?php

                        for ($j = 1;
                             $j <= gun_sayisi();
                             $j++):
                            $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT);
                            if (array_key_exists($j_double_digit, $puantaj_data)) { ?>
                                <td>
                                    <?php echo count($puantaj_data[$j_double_digit]); ?>
                                </td>
                                <?php
                            } else { ?>
                                <td>
                                    <?php echo "0"; ?>
                                </td>
                            <?php }
                        endfor; ?>
                        <td colspan="3"><b>
                                <?php
                                $total_keys = 0;
                                $total_keys = 0;
                                foreach ($puantaj_data as $sub_array) {
                                    $total_keys += count($sub_array);
                                }
                                echo $total_keys;
                                ?></b>
                        </td>
                    </tr>
                <?php } ?>
                </tfoot>
            </table>
        </div>
    </div>
</div>

