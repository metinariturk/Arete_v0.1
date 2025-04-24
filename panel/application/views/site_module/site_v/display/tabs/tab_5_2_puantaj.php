<div class="puantaj_list" id="puantaj_list">
    <form id="puantaj_form"
          action="<?php echo base_url("Site/update_puantaj"); ?>" method="post"
          enctype="multipart/form-data" autocomplete="off">
        <div class="row" id="puantajDate" url="<?php echo base_url("Site/puantaj_date/$item->id"); ?>">
            <div class="col-2"><select class="form-control" onchange="puantajDate(this)" id="month"
                                       name="month">
                    <option selected value="<?php echo $month; ?>"><?php echo ay_isimleri($month); ?></option>
                    <option value="01">Ocak</option>
                    <option value="02">Şubat</option>
                    <option value="03">Mart</option>
                    <option value="04">Nisan</option>
                    <option value="05">Mayıs</option>
                    <option value="06">Haziran</option>
                    <option value="07">Temmuz</option>
                    <option value="08">Ağustos</option>
                    <option value="09">Eylül</option>
                    <option value="10">Ekim</option>
                    <option value="11">Kasım</option>
                    <option value="12">Aralık</option>
                </select>
            </div>
            <div class="col-2"><select class="form-control" onchange="puantajDate(this)" name="year" id="year">
                    <?php if ($year < date('Y')) { ?>
                        <option><?php echo date('Y'); ?></option>
                    <?php } ?>
                    <option selected><?php echo $year; ?></option>
                    <option><?php echo $year - 1; ?></option>
                    <option><?php echo $year - 2; ?></option>
                    <option><?php echo $year - 3; ?></option>
                    <option><?php echo $year - 4; ?></option>
                    <option><?php echo $year - 5; ?></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table-bordered">
                        <thead>
                        <tr>
                            <th style="position: sticky; left: 0; background-color: #fff; z-index: 1;">#</th>
                            <?php
                            for ($j = 1; $j <= $count_of_days; $j++) { ?>
                                <th style="width: 70px; height: 50px; text-align: center"><?php echo str_pad($j, 2, "0", STR_PAD_LEFT); ?></th>
                            <?php } ?>
                            <th>Toplam</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($active_personel_datas as $personel_data) {
                            ?>
                            <tr>
                                <td style="width: 250px; position: sticky; left: 0; background-color: #fff; z-index: 1;">
                                    <b><?php echo $personel_data->name_surname; ?></b>
                                </td>
                                <?php
                                $working_days = 0;  // Toplam çalışma günleri sayacı
                                for ($j = 1; $j <= $count_of_days; $j++) {
                                    $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT);
                                    ?>
                                    <td style="width: 70px; height: 30px; text-align: center">
                                        <input type="checkbox"
                                               style="transform: scale(1.3); -webkit-transform: scale(1.3); -moz-transform: scale(1.3);"
                                               onclick="savePuantaj(this)"
                                               workerid="<?php echo $personel_data->id; ?>"
                                               date="<?php echo $year . '-' . $month . '-' . $j; ?>"
                                            <?php
                                            if (isset($puantaj_data[$j_double_digit]) &&
                                                in_array($personel_data->id, $puantaj_data[$j_double_digit])) {
                                                echo "checked";
                                                $working_days++;  // İşaretli gün sayısını artır
                                            }
                                            ?>
                                        >
                                    </td>
                                <?php } ?>
                                <td style="text-align: center; font-weight: bold;"><?php echo $working_days; ?></td> <!-- Çalışma gün sayısı -->
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
