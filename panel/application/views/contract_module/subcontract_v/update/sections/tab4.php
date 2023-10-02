<table class="table" style="height: 400px">
    <tbody>
    <tr>
        <td style="width: 15%"><b>İşveren Yetkili</b></td>
        <td>
            <select style="width: 100%" id="select2-demo-1" class="form-control"
                    data-plugin="select2"
                    name="isveren_yetkili">
                <option selected="selected" value="<?php echo isset($form_error) ? set_value("isveren_yetkili") : "$item->isveren_yetkili"; ?>"><?php echo isset($form_error) ? full_name(set_value("isveren_yetkili")) : full_name($item->isveren_yetkili); ?></option>
                <option value="">Atama Yok</option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>İşveren Sorumlusu</b></td>
        <td>
            <select style="width: 100%" id="select2-demo-1" class="form-control"
                    data-plugin="select2"
                    name="isveren_sorumlu">
                <option selected="selected" value="<?php echo isset($form_error) ? set_value("isveren_sorumlu") : "$item->isveren_sorumlu"; ?>"><?php echo isset($form_error) ? full_name(set_value("isveren_sorumlu")) : full_name($item->isveren_sorumlu); ?></option>
                <option value="">Atama Yok</option>

                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Yüklenici Yetkili</b></td>
        <td>
            <select style="width: 100%"  id="select2-demo-1" class="form-control"
                    data-plugin="select2"
                    name="yuklenici_yetkili">
                <option selected="selected" value="<?php echo isset($form_error) ? set_value("yuklenici_yetkili") : "$item->yuklenici_yetkili"; ?>"><?php echo isset($form_error) ? full_name(set_value("yuklenici_yetkili")) : full_name($item->yuklenici_yetkili); ?></option>
                <option value="">Atama Yok</option>

                <?php foreach ($yuklenici_users as $yuklenici_user) { ?>
                    <option value="<?php echo $yuklenici_user->id; ?>"><?php echo full_name($yuklenici_user->id); ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><b>İşveren Sorumlusu</b></td>
        <td>
            <select style="width: 100%" id="select2-demo-1" class="form-control"
                    data-plugin="select2"
                    name="yuklenici_sorumlu">
                <option selected="selected" value="<?php echo isset($form_error) ? set_value("yuklenici_sorumlu") : "$item->yuklenici_sorumlu"; ?>"><?php echo isset($form_error) ? full_name(set_value("yuklenici_sorumlu")) : full_name($item->yuklenici_sorumlu); ?></option>
                <option value="">Atama Yok</option>

                <?php foreach ($yuklenici_users as $yuklenici_user) { ?>
                    <option value="<?php echo $yuklenici_user->id; ?>"><?php echo full_name($yuklenici_user->id); ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    </tbody>
</table>
