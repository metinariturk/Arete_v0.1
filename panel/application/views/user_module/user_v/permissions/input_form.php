<table class="table table-bordered table-striped table-hover">
    <thead>
    <th>Modül Adı</th>
    <th>Görüntüleme</th>
    <th>Ekleme</th>
    <th>Düzenleme</th>
    <th>Silme</th>
    </thead>
    <tbody>
    <?php foreach (getControllerList() as $controllerName) { ?>
        <tr>
            <td><?php echo $controllerName; ?></td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $controllerName; ?>][read]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $controllerName; ?>][write]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $controllerName; ?>][update]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $controllerName; ?>][delete]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
