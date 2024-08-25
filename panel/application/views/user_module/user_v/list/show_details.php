<div class="tab-pane contact-tab-2 tab-content-child fade active show" id="v-pills-messages" role="tabpanel"
     aria-labelledby="v-pills-messages-tab">
    <div class="profile-mail">
        <div class="media"><img
                    class="img-100 img-fluid m-r-20 rounded-circle update_img_2" <?php echo get_avatar($item->id); ?>
                    alt="">
            <input class="updateimg" type="file" name="img" onchange="readURL(this,2)">
            <div class="media-body mt-0">
                <a href="<?php echo base_url("user/file_form/$item->id"); ?>">
                    <h5>
                        <span class="first_name_2"><?php echo $item->name; ?> </span><span
                                class="last_name_2"><?php echo $item->surname; ?></span></h5>
                </a>
                <p class="email_add_2"><?php echo $item->email; ?></p>
                <ul>
                    <li><a href="<?php echo base_url("user/update_form/$item->id"); ?>">Düzenle</a></li>
                </ul>
            </div>
        </div>
        <div class="email-general">
            <h6 class="mb-3">Genel Bilgiler</h6>
            <ul>
                <li>Meslek : <span class="font-primary"><?php echo $item->profession; ?></span></li>
                <li>Unvan : <span class="font-primary personality_2"><?php echo $item->unvan; ?></span></li>
                <li>Katılım Tarihi : <span
                            class="font-primary city_2"><?php echo dateFormat_dmy($item->createdAt); ?></span></li>
                <li>Firma : <span class="font-primary mobile_num_2"><?php echo company_name($item->company); ?></span>
                </li>
                <li>Telefon : <span
                            class="font-primary email_add_2"><?php echo formatPhoneNumber($item->phone); ?></span></li>
                <?php $permissions = json_decode($item->permissions, true); ?>
                <li>Yekiler :
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
                </li>
            </ul>
        </div>
    </div>
</div>