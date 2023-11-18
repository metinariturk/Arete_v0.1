<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td style="width: 25%"><b>Bağlı Olduğu Proje Kodu / Ad</b></td>
        <td>
            <span><?php echo project_code_name($item->proje_id); ?></span>
        </td>
    </tr>
    <tr>
        <td style="width: 25%"><b>Bağlı Olduğu Sözleşme</b></td>
        <td>
            <?php echo cms_if_echo($item->contract_id,"0","Sözleşmesiz Şantiye",contract_name($item->contract_id)); ?>
        </td>
    </tr>

    <tr>
        <td><b>Dosya No *</b></td>
        <td>
            <?php echo $item->dosya_no; ?>
        </td>
    </tr>

    <tr>
        <td><b>Şantiye Adı *</b></td>
        <td>
            <input type="text" class="form-control"
                   name="santiye_ad" placeholder="Şantiye Adı"
                   value="<?php echo isset($form_error) ? set_value("santiye_ad") : $item->santiye_ad; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("santiye_ad"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Şantiye Şefi *</b></td>
        <td>
            <select class="form-control" data-plugin="select2" name="santiye_sefi">
                <option selected value="<?php echo isset($form_error) ? set_value("santiye_sefi") : $item->santiye_sefi; ?>"><?php echo isset($form_error) ? full_name(set_value("santiye_sefi")) : full_name($item->santiye_sefi); ?></option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("santiye_sefi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Teknik Personeller</b></td>
        <td>
            <select style="width: 100%;" id="select2-demo-5" class="form-control" data-plugin="select2"
                    name="teknik_personeller[]"
                    multiple data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php
                if (!empty($item->teknik_personel)) { ?>
                    <?php $teknik_personeller = get_as_array($item->teknik_personel);
                    foreach ($teknik_personeller as $teknik_personel) { ?>
                        <option selected='selected'
                                value='<?php echo $teknik_personel; ?>'><?php echo full_name($teknik_personel); ?></option>";
                    <?php } ?>
                <?php } ?>
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("teknik_personeller[]");
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
        <td><b>Araçlar</b></td>
        <td>
            <select style="width: 100%;" id="select2-demo-5" class="form-control" data-plugin="select2"
                    name="araclar[]"
                    multiple data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php
                if (!empty($item->araclar)) { ?>
                    <?php $araclar = get_as_array($item->araclar);
                    foreach ($araclar as $arac) { ?>
                        <option selected='selected'
                                value='<?php echo $arac; ?>'><?php echo vehicle_detail($arac); ?></option>";
                    <?php } ?>
                <?php } ?>
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("araclar[]");
                    foreach ($returns as $return){ ?>
                        <option selected value="<?php echo $return; ?>"><?php echo vehicle_detail($arac); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($vehicles as $vehicle) { ?>
                    <option value="<?php echo $vehicle->id; ?>"><?php echo vehicle_detail($vehicle->id); ?></option>
                <?php } ?>
                <?php if (isset($form_error)) { ?>
                    <small class="pull-left input-form-error"> <?php echo form_error("araclar"); ?></small></div>
                <?php } ?>
            </select>
        </td>
    </tr>

    <tr>
        <td><b>Bağlı Alt Sözleşmeler</b></td>
        <td >
            <select style="width: 100%;" id="select2-demo-5" class="form-control" data-plugin="select2"
                    name="sub_contract[]"
                    multiple data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                <?php
                if (!empty($item->sub_contracts)) { ?>
                    <?php $sub_contracts = get_as_array($item->sub_contracts);
                    foreach ($sub_contracts as $sub_contract) { ?>
                        <option selected='selected'
                                value='<?php echo $sub_contract; ?>'><?php echo contract_name($sub_contract); ?></option>";
                    <?php } ?>
                <?php } ?>
                <?php if (isset($form_error)) { ?>
                    <?php $returns = set_value("sub_contract[]");
                    foreach ($returns as $return){ ?>
                        <option selected value="<?php echo $return; ?>"><?php echo contract_name($return); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($active_subcontracts as $active_subcontract) { ?>
                    <option value="<?php echo $active_subcontract->id; ?>"><?php echo $active_subcontract->sozlesme_ad; ?></option>
                <?php } ?>
                <?php if (isset($form_error)) { ?>
                    <small class="pull-left input-form-error"> <?php echo form_error("sub_contract"); ?></small></div>
                <?php } ?>
            </select>
        </td>
    </tr>

    <tr>
        <td style="width: 25%"><b>Yer Teslimi Tarihi *</b></td>
        <td>
            <input type="text" id="datetimepicker" class="form-control"
                   name="teslim_tarihi"
                   value="<?php echo isset($form_error) ? set_value("sozlesme_tarih") : dateFormat_dmy($item->teslim_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("teslim_tarihi"); ?></small></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Şantiye Genel Notları</b>
        </td>
        <td>
            <textarea class="form-control" name="aciklama" placeholder="Şantiye özel notlarınızı ekleyiniz"><?php echo isset($form_error) ? set_value("aciklama") : $item->aciklama; ?></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            * Doldurulması Gerekli Alanlar
        </td>
    </tr>
    </tbody>
</table>
