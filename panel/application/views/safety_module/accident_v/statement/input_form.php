<table class="table">
    <tbody>
    <tr>
        <td class="w20"><strong>Dosya No</strong></td>
        <td>
            <?php echo "$item->dosya_no"; ?>
        </td>
    </tr>
    <tr>
        <td class="w15"><strong>Belge No</strong></td>
        <td>
            <?php echo "$item->belge_no"; ?>

        </td>
    </tr>
    <tr>
        <td><strong>Kaza Türü</strong></td>
        <td>
            <?php echo "$item->kaza_turu"; ?>
        </td>
    </tr>
    <tr>
        <td><strong>Kaza Tarihi</strong></td>
        <td>
            <?php echo dateFormat_dmy($item->kaza_tarihi); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Etiketler</strong></td>
        <td>
            <?php echo tags($item->etiketler); ?>
        </td>
    </tr>
    <tr>
        <td><b>Tespit Yapan</b></td>
        <td>
            <?php echo full_name($item->tespit_yapan); ?>
        </td>
    </tr>
    <tr>
        <td><strong>Bildiri Tarihi</strong></td>
        <td>
            <input type="text" id="datetimepicker"
                   class="form-control"
                   name="bildiri_tarihi"
                   value="<?php echo isset($form_error) ? set_value("bildiri_tarihi") : dateFormat_dmy($item->bildiri_tarihi); ?>"
                   data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }">
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("bildiri_tarihi"); ?></div>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>
