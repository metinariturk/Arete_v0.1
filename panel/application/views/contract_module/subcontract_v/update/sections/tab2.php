<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td style="width: 15%"><b>Sözleşme İmza Tarih</b></td>
        <td>
            <input type="text" id="datetimepicker" class="form-control"
                   name="sozlesme_tarih"
                   value="<?php echo isset($form_error) ? set_value("sozlesme_tarih") : dateFormat_dmy($item->sozlesme_tarih); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("sozlesme_tarih"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Teklif Türü</b></td>
        <td>
            <select  id="select2-demo-1" class="form-control" style="width: 100%"
                    data-plugin="select2" name="sozlesme_turu">
                <option value="<?php echo isset($form_error) ? set_value("sozlesme_turu") : "$item->sozlesme_turu"; ?>"><?php echo isset($form_error) ? set_value("sozlesme_turu") : $item->sozlesme_turu; ?></option>
                <?php
                $is_turleri = get_as_array($settings->isin_turu);
                foreach ($is_turleri as $is_tur) { ?>
                    <option value="<?php echo $is_tur; ?>"><?php echo $is_tur; ?></option>";
               <?php }
                ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("sozlesme_turu"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>İşin Türü</b></td>
        <td>
            <select  class="form-control" data-plugin="select2" style="width: 100%"
                    name="isin_turu">
                <option value="<?php echo isset($form_error) ? set_value("isin_turu") : "$item->isin_turu"; ?>"><?php echo isset($form_error) ? set_value("isin_turu") : $item->isin_turu; ?></option>
                <?php
                $is_turleri = get_as_array($settings->isin_turu);
                foreach ($is_turleri as $is_tur) {
                    echo "<option value='$is_tur'>$is_tur</option>";
                }
                ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("isin_turu"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>İşin Süresi</b></td>
        <td>
            <input type="number" min="1" step="any" class="form-control"
                   name="isin_suresi"
                   value="<?php echo isset($form_error) ? set_value("isin_suresi") : "$item->isin_suresi"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("isin_suresi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Sözleşme Bedel</b></td>
        <td>
            <div class="row">
                <div class="col-sm-7">
                    <input type="number" min="1" step="any" class="form-control"
                    name="sozlesme_bedel"
                    value="<?php echo isset($form_error) ? set_value("sozlesme_bedel") : $item->sozlesme_bedel; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("sozlesme_bedel"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-5">
                    <select id="select2-demo-1" style="width: 100%;" class="form-control"
                            data-plugin="select2" name="para_birimi">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? set_value("para_birimi") : $item->para_birimi; ?>"><?php echo isset($form_error) ? set_value("para_birimi") : $item->para_birimi; ?></option>
                        <?php
                        $para_birimleri = get_as_array($settings->para_birimi);
                        foreach ($para_birimleri as $para_birimi) {
                            echo "<option value='$para_birimi'>$para_birimi</option>";
                        }
                        ?>
                    </select>
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("para_birimi"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
