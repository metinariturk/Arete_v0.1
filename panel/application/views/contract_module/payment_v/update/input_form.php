<table class="table">
    <tbody>
    <tr>
        <td>
            <label>Dosya No</label>
            <span> <?php echo $item->dosya_no; ?></span>
        </td>
        <td>
            <label>Hakediş Mueyene Tarihi</label>
            <input type="text" id="datetimepicker" class="form-control"
                   name="muayene_tarihi"
                   value="<?php echo ($item->muayene_tarihi=='') ? '' : dateFormat('d-m-Y',$item->muayene_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("muayene_tarihi"); ?></div>
            <?php } ?>
        </td>
        <td>
            <label>Hakediş İtibar Tarihi</label>
            <input type="text" id="datetimepicker" class="form-control"
                   name="itibar_tarihi"
                   value="<?php echo ($item->itibar_tarihi=='') ? '' : dateFormat('d-m-Y',$item->itibar_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("itibar_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <label>Kabul Heyeti</label>
            <select style="width: 100%;" id="select2-demo-5" class="form-control" data-plugin="select2" name="kabul_heyet[]"
                    multiple data-options="{ tags: true, tokenSeparators: [',', ' '] }" >
                <?php
                $heyet_grup = str_getcsv($item->kabul_heyet);
                foreach ($heyet_grup as $heyet) {
                    echo "<option selected='selected' value='$heyet'>$heyet</option>";
                }
                ?>
                <option value="76">Mahmut HAMDİ</option>
                <option value="96">Osman YANARDAĞ</option>
                <option value="47">Mevlüt AKARSU</option>
                <option value="42">Deli DUMRUL</option>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("kabul_heyet"); ?></div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <label>Açıklama</label>
            <textarea class="form-control" name="aciklama" placeholder="Eksik evrak, istenmeyen evrak not alınız"><?php echo $item->aciklama; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>
