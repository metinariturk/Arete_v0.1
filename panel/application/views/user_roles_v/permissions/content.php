<form id="update_user_roles" action="<?php echo base_url("$this->Module_Name/update_permissions/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body chat-body">
                    <div class="chat-box">
                        <!-- Chat left side Start-->
                        <div class="chat-left-aside">
                            <div class="media"><img class="rounded-circle user-image"
                                                    src="<?php echo base_url("assets"); ?>/images/logo/logo-icon.png"
                                                    alt="">
                                <div class="about">
                                    <div class="name f-w-600"><?php echo $item->title; ?></div>
                                    <div class="status">Yetki Düzenleme"</div>
                                </div>
                            </div>
                            <hr>
                            <div class="people-list" id="people-list">
                                <ul class="list">
                                    <?php $current_users = (get_from_any_array("users", "user_role_id", "$item->id"));
                                    foreach ($current_users as $current_user) { ?>
                                        <li class="clearfix"><img
                                                    class="rounded-circle user-image" <?php echo get_avatar($current_user->id); ?>
                                                    alt="">
                                            <div class="status-circle online"></div>
                                            <div class="about">
                                                <div class="name"><a href="<?php echo base_url("user/file_form/$current_user->id");?>"><?php echo "<p>" . full_name($current_user->id) . "</p>"; ?></a></div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <!-- Chat left side Ends-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-8 xl-100">
            <div class="card">
                <div class="card-header">
                    <h5>Tabs Vertical</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                <?php
                                $isFirstItem = true; // İlk elemanı kontrol etmek için bir bayrak

                                foreach ($modules as $main_module => $sub_modules) { ?>
                                    <a class="nav-link <?= $isFirstItem ? "active" : "" ?>"
                                       id="v-pills-<?php echo $main_module; ?>-tab"
                                       data-bs-toggle="pill"
                                       href="#v-pills-<?php echo $main_module; ?>"
                                       role="tab"
                                       aria-controls="v-pills-<?php echo $main_module; ?>"
                                       aria-selected="<?= $isFirstItem ? "true" : "false" ?>">
                                        <?php echo module_name($main_module); ?></a>
                                    <?php $isFirstItem = false; ?>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="row">
                                    <div class="col-2"><h6>Modül Adı</h6></div>
                                    <div class="col-2 text-center"><h6>Tümü</h6></div>
                                    <div class="col-2 text-center"><h6>Oluştur</h6></div>
                                    <div class="col-2 text-center"><h6>Görüntüle</h6></div>
                                    <div class="col-2 text-center"><h6>Düzenle</h6></div>
                                    <div class="col-2 text-center"><h6>Sil</h6></div>
                                </div>
                                <hr>
                                <?php
                                $isFirstModule = true;
                                foreach ($modules as $main_module => $sub_modules) { ?>
                                    <div class="tab-pane fade <?= $isFirstModule ? "show active" : "" ?>"
                                         id="v-pills-<?php echo $main_module; ?>" role="tabpanel"
                                         aria-labelledby="v-pills-<?php echo $main_module; ?>-tab">
                                        <?php foreach ($sub_modules as $sub_module) { ?>
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
                                                                <?php echo (isset($permissions->$sub_module) && isset($permissions->$sub_module->read)) ? "checked" : ""; ?>
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
                                                                <?php echo (isset($permissions->$sub_module) && isset($permissions->$sub_module->write)) ? "checked" : ""; ?>
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
                                                                <?php echo (isset($permissions->$sub_module) && isset($permissions->$sub_module->update)) ? "checked" : ""; ?>
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
                                                                <?php echo (isset($permissions->$sub_module) && isset($permissions->$sub_module->delete)) ? "checked" : ""; ?>
                                                                    id="delete_<?php echo $sub_module; ?>"
                                                                    type="checkbox"
                                                                    name="permissions[<?php echo $sub_module; ?>][delete]">
                                                            <span class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php $isFirstModule = false; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>