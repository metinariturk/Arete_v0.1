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
                        <!-- Burger Menü Butonu -->
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-link p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <button class="btn btn-link p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bars"></i> <!-- Burger Menü İkonu -->
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item text-primary"
                                       href="<?php echo base_url("user/update_form/$active_user->id"); ?>">
                                        <i class="fa fa-edit fa-lg me-2"></i> Düzenle
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger"
                                       href="javascript:void(0);"
                                       onclick="confirmDelete('<?php echo base_url("User/delete_user/$active_user->id"); ?>', '#user_table','userTable')"
                                       title="Sil">
                                        <i class="fa fa-trash-o fa-lg me-2"></i> Sil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                       href="#"
                                       title="Görüntüle">
                                        <i class="fa fa-eye fa-lg me-2"></i> Görüntüle
                                    </a>
                                </li>
                            </ul>
                        </div>

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
                    <?php $permissions = json_decode($active_user->permissions, true); ?>
                    <?php if (isset($permissions)) { ?>
                        <div class="card-body">
                            <h3>Yetkiler</h3>
                            <div class="table-responsive">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Modül</th>
                                        <th>Görüntüleme</th>
                                        <th>Oluşturma</th>
                                        <th>Düzenleme</th>
                                        <th>Silme</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($permissions as $module => $permission) { ?>
                                        <tr>
                                            <td><?php echo module_name($module); ?></td>
                                            <td class="w20c"><?php echo isset($permission['read']) ? '✔' : ''; ?></td>
                                            <td class="w20c"><?php echo isset($permission['write']) ? '✔' : ''; ?></td>
                                            <td class="w20c"><?php echo isset($permission['update']) ? '✔' : ''; ?></td>
                                            <td class="w20c"><?php echo isset($permission['delete']) ? '✔' : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
