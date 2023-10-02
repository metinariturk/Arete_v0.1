<?php foreach ($user_roles as $user_role) { ?>
    <div class="fade tab-pane" id="pills-<?php echo $user_role->id; ?>" role="tabpanel"
         aria-labelledby="pills-<?php echo $user_role->id; ?>">
        <div class="card mb-0">
            <div class="card-header d-flex">
                <h5><?php echo $user_role->title; ?></h5>
                <span class="f-14 pull-right mt-0">
                    <?php
                    $person_count = get_from_any_array("users", "user_role_id", "$user_role->id");
                    if (!is_null($person_count) && is_array($person_count)) {
                        $count = count($person_count);
                        echo $count;
                    } else { echo "0"; }?> Kişi
                </span>
            </div>
            <div class="card-body p-0">
                <div class="row list-persons">
                    <div class="col-xl-4 xl-50 col-md-5">
                        <div class="nav flex-column nav-pills" id="v-pills-tab<?php echo $user_role->id; ?>"
                             role="tablist" aria-orientation="vertical">
                            <?php $selected_person = 1; ?>
                            <?php foreach ($items as $item) { ?>
                                <?php if ($user_role->id == $item->user_role_id) { ?>
                                    <a class="nav-link <?php $is_true = $selected_person++;
                                    cms_if_echo($is_true, "1", "active", ""); ?>"
                                       id="v-pills-<?php echo $user_role->id; ?><?php echo $item->id; ?>-tab"
                                       data-bs-toggle="pill"
                                       href="#v-pills-<?php echo $user_role->id; ?><?php echo $item->id; ?>"
                                       role="tab"
                                       aria-controls="v-pills-<?php echo $user_role->id; ?><?php echo $item->id; ?>"
                                       aria-selected="<?php cms_if_echo($is_true, "1", "true", "false"); ?>">
                                        <div class="media"><img
                                                    class="img-50 img-fluid m-r-20 rounded-circle"
                                                <?php echo get_avatar($item->id); ?> alt="">
                                            <div class="media-body">
                                                <h6><?php echo $item->name; ?>
                                                    <?php echo $item->surname; ?></h6>
                                                <p><?php echo $item->unvan; ?></p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xl-8 xl-50 col-md-7">
                        <div class="tab-content" id="v-pills-tabContent1">
                            <?php $show_person = 1; ?>
                            <?php foreach ($items as $item) { ?>
                                <?php if ($user_role->id == $item->user_role_id) { ?>
                                    <div class="tab-pane fade <?php $is_show = $show_person++;
                                    cms_if_echo($is_show, "1", "show active", ""); ?>"
                                         id="v-pills-<?php echo $user_role->id; ?><?php echo $item->id; ?>"
                                         role="tabpanel"
                                         aria-labelledby="v-pills-<?php echo $user_role->id; ?><?php echo $item->id; ?>-tab">
                                        <div class="profile-mail">
                                            <div class="media"><img
                                                        class="img-100 img-fluid m-r-20 rounded-circle update_img_6"
                                                    <?php echo get_avatar($item->id); ?>
                                                        alt="">
                                                <div class="media-body mt-0">
                                                    <a href="<?php echo base_url("user/file_form/$item->id"); ?>">
                                                        <h5>
                                                            <span class="first_name_1"><?php echo $item->name; ?></span><span
                                                                    class="last_name_1"><?php echo $item->surname; ?></span>
                                                        </h5>
                                                    </a>
                                                    <p class="email_add_6">
                                                        <?php echo $item->email; ?></p>
                                                    <ul>
                                                        <li><a href="#"
                                                               onclick="editContact(1)">Düzenle</a>
                                                        </li>
                                                        <li><a href="#"
                                                               onclick="deleteContact(1)">Sil</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="email-general">
                                                <h6 class="mb-3">Genel</h6>
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td style="width: 15%">Mesleği</td>
                                                        <td class="font-primary"><?php echo $item->profession; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Unvanı</td>
                                                        <td class="font-primary"><?php echo $item->unvan; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Katılım Tarihi</td>
                                                        <td class="font-primary"><?php echo dateFormat_dmy($item->createdAt); ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <p>&nbsp;</p>
                                                <h6 class="mb-3">Görevli Oluğu Projeler</h6>
                                                <table class="table">
                                                    <tbody>
                                                    <?php foreach ($projects as $project) { ?>
                                                        <?php $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project->id"));
                                                        if (in_array($item->id, $yetkili)) { ?>
                                                            <tr>
                                                                <td style="width: 15%"><?php echo $project->proje_kodu; ?></td>
                                                                <td class="font-primary"><?php echo $project->proje_ad; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <p>&nbsp;</p>
                                                <h6 class="mb-3">Görevli Oluğu Sözleşmeler</h6>
                                                <table class="table">
                                                    <tbody>
                                                    <?php foreach ($contracts as $contract) { ?>
                                                        <?php $cont_auth = contract_auth($contract->id);
                                                        if (in_array($item->id, $cont_auth)) { ?>
                                                            <tr>
                                                                <td style="width: 15%"><?php echo $contract->dosya_no; ?></td>
                                                                <td class="font-primary"><?php echo $contract->sozlesme_ad; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <p>&nbsp;</p>
                                                <h6 class="mb-3">Görevli Oluğu Projeler</h6>
                                                <table class="table">
                                                    <tbody>
                                                    <?php foreach ($auctions as $auction) { ?>
                                                        <?php $auction_auth = auction_auth($auction->id);
                                                        if (in_array($item->id, $auction_auth)) { ?>
                                                            <tr>
                                                                <td style="width: 15%"><?php echo $auction->dosya_no; ?></td>
                                                                <td class="font-primary"><?php echo $auction->ihale_ad; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <p>&nbsp;</p>
                                                <h6 class="mb-3">Görevli Oluğu Şantiyeler</h6>
                                                <table class="table">
                                                    <tbody>
                                                    <?php foreach ($sites as $site) { ?>
                                                        <?php $site_auth = site_auth($site->id);
                                                        if (in_array($item->id, $site_auth)) { ?>
                                                            <tr>
                                                                <td style="width: 15%"><?php echo $site->dosya_no; ?></td>
                                                                <td class="font-primary"><?php echo $site->santiye_ad; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>