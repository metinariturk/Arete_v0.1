<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td class="w45"><b>KDV (%)</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control float-right " data-plugin="select2" name="kdv_oran">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("kdv_oran") : $item->kdv_oran; ?>"><?php echo isset($form_error) ? set_value("tevkifat_oran") : $item->kdv_oran; ?></option>
                <?php
                $oranlar = get_as_array($settings->KDV_oran);
                foreach ($oranlar as $oran) {
                    echo "<option value='$oran'>%$oran</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Tevkifat Oran</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="tevkifat_oran">
                <option value="">Yok</option>
                <option selected value="<?php echo isset($form_error) ? set_value("tevkifat_oran") : $item->tevkifat_oran; ?>"><?php echo isset($form_error) ? set_value("tevkifat_oran") : $item->tevkifat_oran; ?></option>
                <?php
                $oranlar = get_as_array($settings->kdv_tevkifat_oran);
                foreach ($oranlar as $oran) {
                    echo "<option value='$oran'>$oran</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Damga Vergisi (Binde)</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="damga_oran">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("damga_oran") : $item->damga_oran; ?>"><?php echo isset($form_error) ? set_value("damga_oran") : $item->damga_oran; ?></option>
                <?php
                $oranlar = get_as_array($settings->damga_oran);
                foreach ($oranlar as $oran) {
                    echo "<option value='$oran'>$oran</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Damga Vergisi Kesintisi</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="damga_kesinti">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("damga_kesinti") : $item->damga_kesinti; ?>">
                    <?php echo isset($form_error) ? set_value("damga_kesinti") : cms_if_echo($item->damga_kesinti,"1","Var","Yok"); ?></option>
                <option value="0">Yok</option>
                <option value="1">Var</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("damga_kesinti"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Stopaj (%)</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="stopaj_oran">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("stopaj_oran") : $item->stopaj_oran; ?>"><?php echo isset($form_error) ? set_value("stopaj_oran") : $item->stopaj_oran; ?></option>
                <?php
                $oranlar = get_as_array($settings->stopaj_oran);
                foreach ($oranlar as $oran) {
                    echo "<option value='$oran'>$oran</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Avans</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="avans_durum">
                <option value="<?php echo $item->avans_durum; ?>"><?php if ($item->avans_durum == null or $item->avans_durum == 0) {echo "Yok";} else { echo "Var";}?></option>
                <option value="0">Yok</option>
                <option value="1">Var</option>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Hakedişte Avans Mahsubu</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="avans_mahsup_durum">
                <option value="<?php echo $item->avans_mahsup_durum; ?>"><?php if ($item->avans_mahsup_durum == null or $item->avans_mahsup_durum == 0) {echo "Yok";} else { echo "Var";}?></option>
                <option value="0">Yok</option>
                <option value="1">Var</option>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Avans Mahsup Oranı</b></td>
        <td>
            <input class="form-control" placeholder="Avans Mahsup Oranı %"
                   name="avans_mahsup_oran"
                   value="<?php echo isset($form_error) ? set_value("avans_mahsup_oran") : $item->avans_mahsup_oran; ?>"/>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("avans_mahsup_oran"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Stopaj Hesabında Avans Mahsubu Miktarı Düşülsün</b></td>
        <td><select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="avans_stopaj">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("avans_stopaj") : $item->avans_stopaj; ?>">
                    <?php echo isset($form_error) ? set_value("avans_stopaj") : cms_if_echo($item->avans_stopaj,"1","Evet","Hayır"); ?></option>
                <option value="0">Hayır</option>
                <option value="1">Evet</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("avans_stopaj"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Fiyat Farkı</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="fiyat_fark">
                <option value="<?php echo $item->fiyat_fark; ?>"><?php price_gap($item->fiyat_fark)?></option>
                <option value="0">Yok</option>
                <option value="1">Genel Endeks</option>
                <option value="2">Ağırlık Oranları</option>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Fiyat Farkı Teminatını Hakedişten Düş</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="fiyat_fark_teminat">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("fiyat_fark_teminat") : $item->fiyat_fark_teminat; ?>">
                    <?php echo isset($form_error) ? price_gap(set_value("fiyat_fark_teminat")) : cms_if_echo($item->fiyat_fark_teminat,"1","Evet","Hayır"); ?></option>
                <option value="1">Evet</option>
                <option value="2">Hayır</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("fiyat_fark_teminat"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>İhzarat Ödemesi</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="ihzarat">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("ihzarat") : $item->ihzarat; ?>">
                    <?php echo isset($form_error) ? set_value("ihzarat") : cms_if_echo($item->ihzarat,"1","Var","Yok"); ?></option>
                <option value="0">Yok</option>
                <option value="1">Var</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("ihzarat"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Geçici Kabul Teminat %</b></td>
        <td>
            <input class="form-control" placeholder="Teminat Oranı %"
                   name="teminat_oran"
                   value="<?php echo isset($form_error) ? set_value("teminat_oran") : $item->teminat_oran; ?>"/>
        </td>
    </tr>
    <tr>
        <td><b>Hakedişlerden Geçici Kabul Kesintisi</b></td>
        <td><select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="gecici_kabul_kesinti">
                <option value="<?php echo $item->gecici_kabul_kesinti; ?>"><?php if ($item->gecici_kabul_kesinti == null or $item->gecici_kabul_kesinti == 0) {echo "Yok";} else { echo "Var";}?></option>
                <option value="0">Yok</option>
                <option value="1">Var</option>
            </select>

        </td>
    </tr>
    </tbody>
</table>
