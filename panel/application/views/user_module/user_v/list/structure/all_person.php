<div class="tab-pane fade active show" id="pills-personal" role="tabpanel"
     aria-labelledby="pills-personal-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h5>Tüm Kişiler</h5><span class="f-14 pull-right mt-0"><?php echo count($items); ?> Kişi</span>
        </div>
        <div class="card-body p-0">
            <div class="row list-persons" id="addcon">
                <div class="col-xl-4 xl-50 col-md-5">
                    <div class="nav flex-column nav-pills" id="v-pills-tab"
                         role="tablist" aria-orientation="vertical">
                        <a class="contact-tab-0 nav-link active" id="v-pills-user-tab"
                           data-bs-toggle="pill"
                           href="#v-pills-user" role="tab" aria-controls="v-pills-user"
                           aria-selected="true">
                            <div class="media"><img
                                        class="img-50 img-fluid m-r-20 rounded-circle update_img_0"
                                    <?php echo get_avatar(active_user_id()); ?> alt="">
                                <div class="media-body">
                                    <h6><span class="first_name_0"><?php echo $user->name; ?></span><span
                                                class="last_name_0"><?php echo $user->surname; ?></span></h6>
                                    <p class="email_add_0"><?php echo $user->email; ?></p>
                                </div>
                            </div>
                        </a>
                        <?php foreach ($items as $item) { ?>
                            <?php if ($item->id != active_user_id()) { ?>
                                <a class="contact-tab-<?php echo $item->id; ?> nav-link"
                                   id="v-pills-contact-tab"
                                   data-bs-toggle="pill" onclick="activeDiv(1)"
                                   href="#v-pills-<?php echo $item->id; ?>" role="tab"
                                   aria-controls="v-pills-<?php echo $item->id; ?>"
                                   aria-selected="false">
                                    <div class="media"><img
                                                class="img-50 img-fluid m-r-20 rounded-circle update_img_1"
                                            <?php echo get_avatar($item->id); ?> alt="">
                                        <div class="media-body">
                                            <h6>
                                                <span class="first_name_1"><?php echo $item->name; ?></span><span
                                                        class="last_name_1"><?php echo $item->surname; ?></span>
                                            </h6>
                                            <p class="email_add_1"><?php echo $item->email; ?></p>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xl-8 xl-50 col-md-7">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane contact-tab-0 tab-content-child fade show active"
                             id="v-pills-user" role="tabpanel"
                             aria-labelledby="v-pills-user-tab">
                            <div class="profile-mail">
                                <div class="media"><img
                                            class="img-100 img-fluid m-r-20 rounded-circle update_img_0"
                                        <?php echo get_avatar($user->id); ?> alt="">
                                    <input class="updateimg" type="file" name="img"
                                           onchange="readURL(this,0)">
                                    <div class="media-body mt-0">
                                        <a href="<?php echo base_url("user/file_form/$user->id"); ?>">
                                            <h5>
                                                <span class="first_name_1"><?php echo $user->name; ?></span><span
                                                        class="last_name_1"><?php echo $user->surname; ?></span>
                                            </h5>
                                        </a>
                                        <p class="email_add_0"><?php echo $user->email; ?></p>
                                        <ul>
                                            <li><a href="<?php echo base_url("user/update_form/$user->id"); ?>" onclick="editContact(0)">Düzenle</a>
                                            </li>
                                            <li><a href="#" onclick="deleteContact(0)">Sil</a>
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
                                            <td class="font-primary"><?php echo $user->profession; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Unvanı</td>
                                            <td class="font-primary"><?php echo $user->unvan; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Katılım Tarihi</td>
                                            <td class="font-primary"><?php echo dateFormat_dmy($user->createdAt); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p>&nbsp;</p>
                                    <h6 class="mb-3">Görevli Oluğu Projeler</h6>
                                    <table class="table">
                                        <tbody>
                                        <?php foreach ($projects as $project) { ?>
                                            <?php $yetkili = get_as_array(get_from_id("projects", "yetkili_personeller", "$project->id"));
                                            if (in_array($user->id, $yetkili)) { ?>
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
                                            if (in_array($user->id, $cont_auth)) { ?>
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
                                            if (in_array($user->id, $auction_auth)) { ?>
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
                                            if (in_array($user->id, $site_auth)) { ?>
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

                        <?php foreach ($items as $item) { ?>
                            <div class="tab-pane contact-tab-<?php echo $item->id; ?> tab-content-child fade"
                                 id="v-pills-<?php echo $item->id; ?>" role="tabpanel"
                                 aria-labelledby="v-pills-<?php echo $item->id; ?>-tab">
                                <div class="profile-mail">
                                    <div class="media"><img
                                                class="img-100 img-fluid m-r-20 rounded-circle update_img_1"
                                            <?php echo get_avatar($item->id); ?> alt="">
                                        <input class="updateimg" type="file" name="img"
                                               onchange="readURL(this,1)">
                                        <div class="media-body mt-0">
                                            <a href="<?php echo base_url("user/file_form/$item->id"); ?>">
                                                <h5>
                                                    <span class="first_name_1"><?php echo $item->name; ?></span><span
                                                            class="last_name_1"><?php echo $item->surname; ?></span>
                                                </h5>
                                            </a>
                                            <p class="email_add_1"><?php echo $item->email; ?></p>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
