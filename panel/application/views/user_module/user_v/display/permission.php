<?php
$permission_groups = json_decode($item->permissions, true);

// ✔️ ve ❌ ikonlarını döndüren yardımcı fonksiyon

?>

<div class="card-body">

    <!-- GÜNCELLE BUTONU -->
    <button
            class="btn btn-primary"
            data-url="<?php echo base_url('user/show_update_permission/' . $item->id); ?>"
            data-target="#permission-form"
            onclick="loadDynamicContent(this)">
        Güncelle
    </button>

    <!-- MODÜLLERİN TABLO GÖRÜNÜMÜ -->
    <div class="card-body col-xs-12">
        <?php foreach ($modules as $modul => $sub_modules): ?>
            <div class="card mb-4 shadow-sm border rounded-3">
                <div class="card-header text-center p-2">
                    <h6 class="mb-0"><?= module_name($modul); ?></h6>
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
                    <?php foreach ($sub_modules as $sub_module):
                        $perm_string = $permission_groups[$sub_module] ?? '';

                        $has_read = strpos($perm_string, 'r') !== false;
                        $has_write = strpos($perm_string, 'w') !== false;
                        $has_update = strpos($perm_string, 'u') !== false;
                        $has_delete = strpos($perm_string, 'd') !== false;
                        ?>
                        <tr>
                            <td class="text-start"><?= module_name($sub_module); ?></td>
                            <td><?= permissionIcon($has_read); ?></td>
                            <td><?= permissionIcon($has_write); ?></td>
                            <td><?= permissionIcon($has_update); ?></td>
                            <td><?= permissionIcon($has_delete); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</div>