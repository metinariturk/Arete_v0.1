<table class="table">
    <tbody>
    <tr>
        <td>
            <select id="select2-demo-1" class="form-control col-sm-12"
                    required data-plugin="select2" name="site_id">
                <option value=""></option>
                <?php foreach ($active_sites as $active_site) { ?>
                    <option value="<?php echo $active_site->id; ?>"><?php echo $active_site->santiye_ad; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <small class="pull-left input-form-error"> Sadece aktif durumda olan işler
                listelenir. Projenizi listede bulamıyorsanız Projeler listesi üzerinde
                ilgili işi "Devam Ediyor" olarak değiştirmeniz gerekmektedir.</small>
        </td>
    </tr>
    </tbody>
</table>