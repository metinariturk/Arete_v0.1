<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td style="width: 15%"><b>Bağlı Olduğu Proje Kodu / Ad</b></td>
        <td>
            <span><?php echo project_code_name($item->proje_id); ?></span>
        </td>
    </tr>
    <tr>
        <td><b>Dosya No</b></td>
        <td><span><?php echo $item->dosya_no; ?></span>
    </tr>
    <tr>
        <td><b>Sözleşme Adı</b></td>
        <td>
            <input type="text" class="form-control"
                   name="sozlesme_ad" placeholder="İnce İşler, Kaba İşler, Elektrik vs..."
                   value="<?php echo isset($form_error) ? set_value("sozlesme_ad") : "$item->sozlesme_ad"; ?>">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("sozlesme_ad"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>İşveren</b></td>
        <td>
            <select class="form-control" data-plugin="select2" name="isveren">
                <option value="<?php echo isset($form_error) ? set_value("isveren") : "$item->isveren"; ?>"><?php echo isset($form_error) ? company_name(set_value("isveren")) : company_name($item->isveren); ?></option>
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
        <td><b>Yüklenici/Taşeron Firma</b></td>
        <td>
            <select class="form-control" data-plugin="select2" name="yuklenici">
                <option value="<?php echo isset($form_error) ? set_value("yuklenici") : $item->yuklenici; ?>"><?php echo isset($form_error) ? company_name(set_value("yuklenici")) : company_name($item->yuklenici); ?></option>
                <?php foreach ($not_employers as $not_employer) { ?>
                    <option value="<?php echo $not_employer->id; ?>"><?php echo $not_employer->company_name; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("yuklenici"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b>Fiyat Farkı</b></td>
        <td>
            <select id="select2-demo-1" style="width: 100%;" class="form-control"
                    data-plugin="select2" name="fiyat_fark">
                <option value="<?php echo $item->fiyat_fark; ?>"><?php if ($item->fiyat_fark == null or $item->fiyat_fark == 0) {echo "YOK";} else { echo "VAR";}?></option>
                <option value="0">YOK</option>
                <option value="1">VAR</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("fiyat_fark"); ?></div>
            <?php } ?>

        </td>
    </tr>
    <tr>
        <td>
            <b>Sözleşme Genel Notları</b>
        </td>
        <td>
            <textarea class="form-control" name="aciklama" placeholder="Sözleşme özel notlarınızı ekleyiniz"><?php echo $item->aciklama; ?></textarea>
        </td>
    </tr>
    </tbody>
</table>
