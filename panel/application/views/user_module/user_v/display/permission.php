<?php
$permission_groups = json_decode($item->permissions, true);

// ✔️ ve ❌ göstermek için yardımcı fonksiyon
function permissionIcon($has)
{
    return $has ? '<span class="text-success fw-bold">&#10004;</span>' : '<span class="text-danger fw-bold">&#10006;</span>';
}

?>
<button
        class="btn btn-primary"
        data-url="<?php echo base_url('user/show_update_permission/' . $item->id); ?>"
        data-target="#permission-form"
        onclick="loadDynamicContent(this)">
    Güncelle
</button>

<div class="card-body col-xs-12">
    <?php foreach ($modules as $modul => $sub_modules) { ?>
        <div class="card mb-4 shadow-sm border rounded-3">
            <div class="card-header text-center p-2">
                <h6 class="mb-0"><?php echo module_name($modul); ?></h6>
            </div>
            <table class="table table-bordered text-center align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="text-start w-20">Alt Modül</th>
                    <th class="w20">Görüntüle</th>
                    <th class="w20">Ekle</th>
                    <th class="w20">Düzenle</th>
                    <th class="w20">Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sub_modules as $sub_module) {
                    $perms = ['read', 'write', 'update', 'delete'];
                    ?>
                    <tr>
                        <td class="text-start"><?php echo module_name($sub_module); ?></td>
                        <?php foreach ($perms as $perm) {
                            $has = isset($permission_groups[$sub_module][$perm]);
                            ?>
                            <td><?php echo permissionIcon($has); ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>
