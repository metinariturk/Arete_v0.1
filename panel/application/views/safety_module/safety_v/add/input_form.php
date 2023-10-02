<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td style="width: 20%"><b>Bağlı Olduğu Proje Kodu / Ad</b></td>
        <td>
            <span><?php echo site_name($sid); ?></span>
        </td>
    </tr>


    <tr>
        <td><b>Dosya No *</b></td>
        <td>
            <div class="input-group">
                <span class="input-group-addon">ISG</span>
                <?php if (!empty(get_last_fn("safety"))) { ?>
                    <input type="number" name="dosya_no" class="form-control"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("safety"); ?>">
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
        <td><b>Şantiye Adı *</b></td>
        <td>
            <span><?php echo "$site->santiye_ad"; ?></span>
        </td>
    </tr>
    <tr>
        <td><b>Şantiye Şefi *</b></td>
        <td>
            <span><?php echo full_name($site->santiye_sefi) . " " . get_avatar($site->santiye_sefi); ?></span>
        </td>
    </tr>
    <tr>
        <td><b>Teknik Personeller</b></td>
        <td>
            <?php foreach (get_as_array($site->teknik_personel) as $personel) { ?>
                <?php echo full_name($personel) . " " . get_avatar($personel); ?><br>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="width: 15%"><b>OSGB Firması</b></td>
        <td>
            <select class="form-control" data-plugin="select2" name="osgb">
                <option value="<?php echo isset($form_error) ? set_value("osgb") : ""; ?>"><?php echo isset($form_error) ? company_name(set_value("osgb")) : "Seçiniz"; ?></option>
                <?php foreach ($not_employers as $not_employer) { ?>
                    <option value="<?php echo $not_employer->id; ?>"><?php echo $not_employer->company_name; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("osgb"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>İSG Uzmanı</b></td>
        <td >
            <select style="font-size: 18pt; height: 100px; width:280px; " id="select2-demo-5" class="form-control"
                    data-plugin="select2"
                    name="isg_personeller[]"
                    multiple data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("isg_personeller[]");
                    foreach ($returns as $return){ ?>
                        <option selected value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name." ".$user->surname; ?></option>
                <?php } ?>
            </select>
            <br>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("isg_personeller"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>İş Yeri Hekimi</b></td>
        <td >
            <select class="form-control" data-plugin="select2"
                    name="isg_hekim" >
                <option value="<?php echo isset($form_error) ? set_value("isg_hekim") : ""; ?>"><?php echo isset($form_error) ? full_name(set_value("isg_hekim")) : "Seçiniz"; ?></option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo $user->name." ".$user->surname; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("isg_hekim"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="width: 15%"><b>İş Yeri Sicil No (26 Haneli)</b></td>
        <td>
            <input type="number" step="1" class="form-control"
                   name="sicil_no"
                   value="<?php echo isset($form_error) ? set_value("sicil_no") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("sicil_no"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="width: 15%"><b>NACE Kodu (6 Haneli)</b></td>
        <td>
            <input type="number" step="1" class="form-control"
                   name="nace_kodu"
                   value="<?php echo isset($form_error) ? set_value("nace_kodu") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("nace_kodu"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="width: 15%"><b>İş Yeri Açılış Tarihi</b></td>
        <td>
            <input type="text" id="datetimepicker" class="form-control"
                   name="acilis_tarihi"
                   value="<?php echo isset($form_error) ? set_value("acilis_tarihi") : ""; ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("acilis_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="width: 15%"><b>Tehlike Sınıfı</b></td>
        <td>
            <select id="select2-demo-1" class="form-control col-sm-12"
                    data-plugin="select2" name="danger_class">
                <option value="<?php echo isset($form_error) ? set_value("danger_class") : ""; ?>"><?php echo isset($form_error) ? danger_class(set_value("danger_class")) : "Seçiniz"; ?></option>
                <option value="1">Az Tehlikeli</option>
                <option value="2">Tehlikeli</option>
                <option value="3">Çok Tehlikeli</option>

            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("danger_class"); ?></div>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td>
            <b>İşyeri Genel Notları</b>
        </td>
        <td>
            <textarea class="form-control" name="aciklama" placeholder="Şantiye özel notlarınızı ekleyiniz"><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </td>

    </tr>
    <tr>
        <td colspan="2">
            * Doldurulması Gerekli Alanlar
        </td>

    </tr>
    </tbody>
</table>
