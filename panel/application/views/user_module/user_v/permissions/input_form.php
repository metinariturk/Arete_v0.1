<table class="table table-bordered table-striped table-hover">
    <thead>
    <th>Modül Adı</th>
    <th>Görüntüleme</th>
    <th>Ekleme</th>
    <th>Düzenleme</th>
    <th>Silme</th>
    </thead>
    <tbody>
    <?php $permition_modules = array("project", "contract","offer","payment","site"); ?>
    <?php foreach ($permition_modules as $permition_module) { ?>
        <tr>
            <td><?php echo $permition_module; ?></td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $permition_module; ?>][read]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $permition_module; ?>][write]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $permition_module; ?>][update]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
            <td class="w5 text-center">
                <input name="permissions[<?php echo $permition_module; ?>][delete]" type="checkbox" data-switchery data-color="#10c469"/>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
