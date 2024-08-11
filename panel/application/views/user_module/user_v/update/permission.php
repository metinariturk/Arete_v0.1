<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Kullanıcı Yetkileri</h4>
            <div class="card-options"><a class="card-options-collapse" href="#"
                                         data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a
                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                            class="fe fe-x"></i></a></div>
        </div>

        <?php $permission_groups = json_decode($item->permissions, true); ?>


        <div class="card-body col-xs-12">
            <?php
            foreach ($modules as $modul => $sub_modules) { ?>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h6><?php echo module_name($modul); ?></h6>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-2 text-center">Tümü</div>
                    <div class="col-2  text-center">Görüntüle</div>
                    <div class="col-2  text-center">Oluştur</div>
                    <div class="col-2  text-center">Düzenle</div>
                    <div class="col-2  text-center">Sil</div>
                </div>
                <?php foreach ($sub_modules as $sub_module) { ?>
                    <?php if (isset($permission_groups[$sub_module])) { ?>
                        <div class="row checkbox-group <?php echo $sub_module; ?>">
                            <div class="col-2">
                                <?php echo module_name($sub_module); ?>

                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input checked
                                               id="masterCheckbox_<?php echo $sub_module; ?>"
                                               type="checkbox"
                                               onclick="toggleAllCheckboxes('<?php echo $sub_module; ?>')">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input
                                            <?php echo (isset($permission_groups[$sub_module]["read"])) ? "checked" : ""; ?>
                                                id="read_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][read]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input
                                            <?php echo (isset($permission_groups[$sub_module]["write"])) ? "checked" : ""; ?>
                                                id="write_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][write]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input
                                            <?php echo (isset($permission_groups[$sub_module]["update"])) ? "checked" : ""; ?>
                                                id="update_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][update]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input
                                            <?php echo (isset($permission_groups[$sub_module]["delete"])) ? "checked" : ""; ?>
                                                id="delete_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][delete]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else { ?>
                        <div class="row checkbox-group <?php echo $sub_module; ?>">
                            <div class="col-2">
                                <?php echo module_name($sub_module); ?>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input checked
                                               id="masterCheckbox_<?php echo $sub_module; ?>"
                                               type="checkbox"
                                               onclick="toggleAllCheckboxes('<?php echo $sub_module; ?>')">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input

                                                id="read_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][read]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input

                                                id="write_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][write]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input

                                                id="update_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][update]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="media-body text-center icon-state switch-outline">
                                    <label class="switch">
                                        <input

                                                id="delete_<?php echo $sub_module; ?>"
                                                type="checkbox"
                                                name="permissions[<?php echo $sub_module; ?>][delete]">
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
