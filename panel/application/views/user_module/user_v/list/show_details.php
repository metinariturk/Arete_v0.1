<div class="tab-pane contact-tab-2 tab-content-child fade active show" id="v-pills-messages" role="tabpanel"
     aria-labelledby="v-pills-messages-tab">
    <div class="card-body">
        <!-- Resim ve Bilgiler -->
        <div class="d-flex align-items-center">
            <img class="img-100 img-fluid rounded-circle me-3" <?php echo get_avatar($item->id); ?> alt="">
            <div>
                <a href="<?php echo base_url("user/file_form/$item->id"); ?>">
                    <h5>
                        <span class="first_name_2"><?php echo $item->name; ?> </span>
                        <span class="last_name_2"><?php echo $item->surname; ?></span>
                    </h5>
                    <span class="user_name"><?php echo $item->user_name; ?></span>
                </a>
                <p class="email_add_2"><?php echo $item->email; ?></p>
            </div>
        </div>
        <hr>
        <h6 class="mb-3">Genel Bilgiler</h6>

        <div class="d-flex justify-content-between mb-2">
            <span>Meslek:</span>
            <span class="font-primary"><?php echo $item->profession; ?></span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span>Unvan:</span>
            <span class="font-primary personality_2"><?php echo $item->unvan; ?></span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span>Katılım Tarihi:</span>
            <span class="font-primary city_2"><?php echo dateFormat_dmy($item->createdAt); ?></span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span>Firma:</span>
            <span class="font-primary mobile_num_2"><?php echo company_name($item->company); ?></span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span>Telefon:</span>
            <span class="font-primary email_add_2"><?php echo formatPhoneNumber($item->phone); ?></span>
        </div>
    </div>

    <?php if (isUser($item->id)) { ?>
        <?php
        $permission_groups = json_decode($item->permissions, true);
        ?>

        <!-- MODÜLLERİN TABLO GÖRÜNÜMÜ -->
        <div class="card-body col-xs-12">
            <?php foreach ($modules as $modul => $sub_modules) { ?>
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
                        <?php foreach ($sub_modules as $sub_module) {
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
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
