<?php
$permission_groups = json_decode($item->permissions, true);

// Yardımcı fonksiyon
function renderSwitch($type, $sub_module, $permissions)
{
    // İzin harflerini eşleştir
    $type_map = [
        "read" => "r",
        "write" => "w",
        "update" => "u",
        "delete" => "d"
    ];

    $perm_letter = $type_map[$type] ?? '';
    $checked = (isset($permissions[$sub_module]) && strpos($permissions[$sub_module], $perm_letter) !== false) ? 'checked' : '';

    return <<<HTML
        <div class="col-2 text-center">
            <div class="media-body text-center icon-state switch-outline">
                <label class="switch">
                    <input {$checked}
                           id="{$type}_{$sub_module}"
                           type="checkbox"
                           name="permissions[{$sub_module}][]"
                           value="{$perm_letter}">
                    <span class="switch-state bg-primary"></span>
                </label>
            </div>
        </div>
    HTML;
}

?>

<div class="mb-2">
    <div class="row">
        <div class="col-12">
            <div class="col-form-label">&nbsp;</div>
            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-danger" type="button" onclick="cancelConfirmationModule(this)"
                        url="<?php echo base_url("User/file_form/$item->id"); ?>">
                    <i class="menu-icon fa fa-close fa-lg" aria-hidden="true"></i> İptal
                </button>
                <button type="button" class="btn btn-success"
                        onclick="submit_modal_form('update_permission', null, 'update-permission', 'update-permission')">
                    <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                </button>
            </div>
        </div>
    </div>
</div>
<form id="update_permission" method="post" data-form-url="<?php echo base_url("User/update_permissions/$item->id"); ?>"
      enctype="multipart/form-data" autocomplete="off">

    <div class="card-body col-xs-12">
        <?php foreach ($modules as $module => $sub_modules): ?>
            <div class="row">
                <div class="col-12 text-center">
                    <h6><?= module_name($module) ?></h6>
                </div>
            </div>
            <div class="row fw-bold text-center">
                <div class="col-2"></div>
                <div class="col-2">Tümü</div>
                <div class="col-2">Görüntüle</div>
                <div class="col-2">Oluştur</div>
                <div class="col-2">Düzenle</div>
                <div class="col-2">Sil</div>
            </div>

            <?php foreach ($sub_modules as $sub_module): ?>
                <div class="row checkbox-group <?= $sub_module ?>">
                    <div class="col-2">
                        <?= module_name($sub_module) ?>
                    </div>

                    <!-- Master checkbox -->
                    <div class="col-2 text-center">
                        <div class="media-body text-center icon-state switch-outline">
                            <label class="switch">
                                <input checked
                                       id="masterCheckbox_<?= $sub_module ?>"
                                       type="checkbox"
                                       onclick="toggleAllCheckboxes('<?= $sub_module ?>')">
                                <span class="switch-state bg-primary"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Permission switches -->
                    <?= renderSwitch("read", $sub_module, $permission_groups) ?>
                    <?= renderSwitch("write", $sub_module, $permission_groups) ?>
                    <?= renderSwitch("update", $sub_module, $permission_groups) ?>
                    <?= renderSwitch("delete", $sub_module, $permission_groups) ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</form>
