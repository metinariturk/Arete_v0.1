<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row list-persons">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                         aria-orientation="vertical">
                        <?php foreach ($items as $item) { ?>
                            <a class="contact-tab-0 nav-link" data-bs-toggle="pill"
                               onclick="show_user_detail(<?php echo $item->id; ?>)"
                               role="tab" aria-controls="v-pills-user" aria-selected="false" tabindex="-1">
                                <div class="media"> <?php if ($item->is_Admin == 1) {
                                        echo "<i class='fa fa-star' style='color: gold'></i>";
                                    } ?>
                                    <img class="img-50 img-fluid m-r-20 rounded-circle update_img_0"
                                        <?php echo get_avatar($item->id); ?> alt="">
                                    <div class="media-body">
                                        <h6>
                                            <span class="first_name_0"><?php echo $item->name; ?> </span><span
                                                    class="last_name_0">   <?php echo $item->surname; ?><br></span>
                                        </h6>
                                        <p class="email_add_0"><?php echo $item->unvan; ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body user_details">
                <div class="tab-pane contact-tab-2 tab-content-child fade active show" id="v-pills-messages"
                     role="tabpanel"
                     aria-labelledby="v-pills-messages-tab">
                    <div class="card-body">
                        <!-- Resim ve Bilgiler -->
                        <div class="d-flex align-items-center">
                            <img class="img-100 img-fluid rounded-circle me-3" <?php echo get_avatar($active_user->id); ?>
                                 alt="">

                            <!-- İsim, Soyisim ve Kullanıcı Adı -->
                            <div>
                                <a href="<?php echo base_url("user/file_form/$active_user->id"); ?>">
                                    <h5 class="mb-0">
                                        <span class="first_name_2"><?php echo $active_user->name; ?> </span>
                                        <span class="last_name_2"><?php echo $active_user->surname; ?></span>
                                    </h5>
                                    <span class="user_name"><?php echo $active_user->user_name; ?></span>
                                </a>
                                <p class="email_add_2"><?php echo $active_user->email; ?></p>
                            </div>
                        </div>

                        <h6 class="mb-3">Genel Bilgiler</h6>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Meslek:</span>
                            <span class="font-primary"><?php echo $active_user->profession; ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Unvan:</span>
                            <span class="font-primary personality_2"><?php echo $active_user->unvan; ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Katılım Tarihi:</span>
                            <span class="font-primary city_2"><?php echo dateFormat_dmy($active_user->createdAt); ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Firma:</span>
                            <span class="font-primary mobile_num_2"><?php echo company_name($active_user->company); ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Telefon:</span>
                            <span class="font-primary email_add_2"><?php echo formatPhoneNumber($active_user->phone); ?></span>
                        </div>
                    </div>

                    <?php if (isUser($item->id)) { ?>
                        <?php
                        $permission_groups = json_decode($active_user->permissions, true);
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
            </div>
        </div>
    </div>
</div>
