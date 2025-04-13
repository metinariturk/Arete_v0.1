<div class="container-fluid">
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
                            <div class="row align-items-center text-center">
                                <!-- Sol - Telefon -->
                                <div class="col-12 col-md-4 text-md-start mb-3 mb-md-0">
                                    <div class="ttl-info">
                                        <a href="https://wa.me/+90<?php echo $item->phone; ?>" target="_blank">
                                            <h6><i class="fa fa-whatsapp fa-lg"></i>&nbsp;Whatsapp</h6>
                                        </a>
                                        <a href="tel:+90<?php echo $item->phone; ?>">
                                            <i class="fa fa-phone fa-lg"></i> +90 <?php echo formatPhoneNumber($item->phone); ?>
                                        </a>
                                    </div>
                                </div>

                                <!-- Orta - Kişi bilgileri -->
                                <div class="col-12 col-md-4">
                                    <div class="user-designation">
                                        <div class="title"><?php echo full_name($item->id); ?></div>
                                        <div class="desc"><?php echo $item->profession; ?></div>
                                        <a href="<?php echo base_url("company/file_form/$item->company"); ?>"><?php echo company_name($item->company); ?></a>
                                        <p><?php echo $item->unvan; ?></p>
                                    </div>
                                </div>

                                <!-- Sağ - E-posta -->
                                <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
                                    <div class="ttl-info">
                                        <h6><i class="fa fa-envelope"></i>&nbsp;Email</h6>
                                        <a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card mb-3">
            <div class="card-body">
                <div id="update-form">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/info"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card mb-3">
                <div id="permission-form">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/permission"); ?>
                </div>
        </div>
    </div>
</div>