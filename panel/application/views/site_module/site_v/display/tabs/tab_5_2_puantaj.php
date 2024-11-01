<div class="puantaj_list" id="puantaj_list">
    <form id="puantaj_form"
          action="<?php echo base_url("$this->Module_Name/update_puantaj"); ?>" method="post"
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
                <div class="table-container">
                    <table id="table_puantaj" class="table-bordered">
                        <thead>
                        <tr>
                            <th  style="
                                transform: rotate(-90deg); /* 90 derece döndür */
                                transform-origin: bottom left; /* Dönme noktası */
                                height: 150px">#</th>
                            <?php foreach ($active_personel_datas as $i => $personel_data) { ?>
                                <th style="
                                transform: rotate(-90deg); /* 90 derece döndür */
                                transform-origin: bottom left; /* Dönme noktası */
                                height: 150px"><?php echo $personel_data->name_surname; ?></th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count_of_days = gun_sayisi();
                        for ($j = 1; $j <= $count_of_days; $j++) {
                            $j_double_digit = str_pad($j, 2, "0", STR_PAD_LEFT);
                            ?>
                            <tr>
                                <td><b><?php echo $j; ?></b></td>
                                <?php foreach ($active_personel_datas as $personel_data) { ?>
                                    <td>
                                        <input type="checkbox"
                                               onclick="savePuantaj(this)"
                                               workerid="<?php echo $personel_data->id; ?>"
                                               date="<?php echo $year . '-' . $month . '-' . $j; ?>"
                                            <?php
                                            if (isset($puantaj_data[$j_double_digit]) &&
                                                in_array($personel_data->id, $puantaj_data[$j_double_digit])) {
                                                echo "checked";
                                            }
                                            ?>
                                        >
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>


