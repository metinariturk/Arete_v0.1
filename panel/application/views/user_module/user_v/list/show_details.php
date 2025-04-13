<div class="tab-pane contact-tab-2 tab-content-child fade active show" id="v-pills-messages" role="tabpanel"
     aria-labelledby="v-pills-messages-tab">
    <div class="card-body">
        <!-- Burger Menü Butonu -->
        <div class="d-flex justify-content-end">
            <button class="btn btn-link p-0" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bars"></i> <!-- Burger Menü İkonu -->
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item text-primary"
                       href="<?php echo base_url("user/update_form/$item->id"); ?>">
                        <i class="fa fa-edit fa-lg me-2"></i> Düzenle
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-danger"
                       href="javascript:void(0);"
                       onclick="confirmDelete('<?php echo base_url("User/delete_user/$item->id"); ?>', '#user_table','userTable')"
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

    <?php $permissions = json_decode($item->permissions, true); ?>
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
