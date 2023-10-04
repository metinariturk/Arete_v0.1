<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td style="width: 15%"><b>Bağlı Olduğu Proje Kodu / Ad</b></td>
        <td>
            <span><?php echo project_code_name($pid); ?></span>
        </td>
    </tr>

    <tr>
        <td><b>Dosya No *</b></td>
        <td>
            <div class="input-group">
                <span class="input-group-addon">IHL</span>
                <?php if (!empty(get_last_fn("auction"))) { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("auction"); ?>">
                    <?php
                } else { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                <?php } ?>

            </div>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("dosya_no"); ?></div>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td><b>Teklif Adı *</b></td>
        <td>
            <input type="text" class="form-control"
                   name="ihale_ad" placeholder="Teklif Adı"
                   value="<?php echo isset($form_error) ? set_value("ihale_ad") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("ihale_ad"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Teklif Yapan *</b></td>
        <td>
            <select class="form-control" data-plugin="select2" name="isveren">
                <option value="<?php echo isset($form_error) ? set_value("isveren") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : "Seçiniz"; ?></option>
                <?php foreach ($employers as $employer) { ?>
                    <option value="<?php echo $employer->id; ?>"><?php echo $employer->company_name; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("isveren"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Teklif Bütçe Tutar</b></td>
        <td>
            <div class="row">
                <div class="col-sm-7">
                    <input type="number" min="1" step="any" class="form-control"
                           name="butce"
                           value="<?php echo isset($form_error) ? set_value("butce") : ""; ?>">
                    <?php if (isset($form_error)) { ?>
                        <small class="pull-left input-form-error"> <?php echo form_error("butce"); ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-5">
                    <select id="select2-demo-1" style="width: 100%;" class="form-control"
                            data-plugin="select2" name="para_birimi">
                        <option selected="selected"
                                value="<?php echo isset($form_error) ? cms_if_echo(set_value("para_birimi"),null,"",set_value("para_birimi")) : ""; ?>">
                            <?php echo isset($form_error) ? cms_if_echo(set_value("para_birimi"),null,"Seçiniz",set_value("para_birimi")) :"Seçiniz"; ?>
                        </option>
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

    <tr>
        <td><b>Yetkili Personeller</b></td>
        <td >
            <select style="font-size: 18pt; height: 100px; width:280px; " id="select2-demo-5" class="form-control"
                    data-plugin="select2"
                    name="yetkili_personeller[]"
                    multiple data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("yetkili_personeller[]");
                    foreach ($returns as $return){ ?>
                        <option selected value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name." ".$user->surname; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td style="width: 15%"><b>Ön Görülen İlan Tarihi *</b></td>
        <td>
            <input type="text" id="datetimepicker" class="form-control"
                   name="talep_tarih"
                   value="<?php echo isset($form_error) ? set_value("talep_tarih") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("talep_tarih"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Teklif Genel Notları</b>
        </td>
        <td>
            <textarea class="form-control" name="aciklama" placeholder="Teklif özel notlarınızı ekleyiniz"><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            * Doldurulması Gerekli Alanlar
        </td>
    </tr>
    </tbody>
</table>
