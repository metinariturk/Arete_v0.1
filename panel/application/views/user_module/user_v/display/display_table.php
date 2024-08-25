<div class="container-fluid">
    <div class="user-profile">
        <div class="row">
            <div class="col-sm-12">
                <div class="card hovercard text-center">
                    <div class="cardheader" style="display: flex;
    justify-content: center; /* Yatayda ortalama */
    align-items: center;     /* Düşeyde ortalama (opsiyonel, öğe yüksekliği varsa) */
    height: 100%;         ">
                        <?php
                        $enabled = true;
                        $file = 'assets/images/user/user.png';

                        // Klasörde dosyayı bulma
                        $path = "$this->File_Dir_Prefix/$item->id/";

                        // Eğer dizin mevcut değilse
                        if (is_dir($path)) {
                            // Dizindeki dosyaları al
                            $files = glob($path . '*');

                            // Klasördeki dosyaları kontrol et
                            foreach ($files as $file) {
                                // Dosya olup olmadığını kontrol et ve avatar olup olmadığını kontrol et
                                if (is_file($file) && strpos($file, '_avatar') !== false) {
                                    // Dosya bulunduğunda varsayılan avatar olarak ayarla
                                    $default_avatar = $file;
                                    break; // Dosya bulunduğunda döngüyü sonlandır
                                }
                            }
                        }
                        ?>
                        <input type="file" name="files" data-fileuploader-default="<?php echo base_url($file); ?>"
                               data-fileuploader-files='<?php echo isset($avatar) ? json_encode(array($avatar)) : ''; ?>'
                            <?php echo !$enabled ? ' disabled' : ''; ?>>
                    </div>
                    <div class="info">
                        <div class="row">
                            <div class="col-sm-3 col-lg-4 order-sm-1 order-xl-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ttl-info text-start">
                                            <h6><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Email</h6>
                                            <a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ttl-info text-start">
                                            <h6><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;Katılma Tarihi</h6>
                                            <span><?php echo dateFormat_dmy($item->createdAt); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                <div class="user-designation">
                                    <div class="title"><?php echo full_name($item->id); ?></div>
                                    <div class="desc"><?php echo $item->profession; ?></div>
                                    <p><?php echo $item->unvan; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-3 col-lg-4 order-sm-2 order-xl-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ttl-info text-start">
                                            <a href="https://wa.me/+90<?php echo $item->phone; ?>" target="_blank">
                                                <h6>
                                                    <i class="fa fa-whatsapp fa-2xl"></i>&nbsp;Whatsapp
                                                </h6>
                                            </a>
                                            <a href="tel:+90<?php echo $item->phone; ?>"><i
                                                        class="fa fa-phone fa-lg"></i>
                                                +90 <?php echo formatPhoneNumber($item->phone); ?></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ttl-info text-start">
                                            <h6><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;Firma</h6>
                                            <a href="<?php echo base_url("company/file_form/$item->company"); ?>"><?php echo company_name($item->company); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        YETKİLER
                        <?php $permissions = json_decode($item->permissions, true); ?>
                        <table class="table">
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
            </div>
        </div>
    </div>
</div>
