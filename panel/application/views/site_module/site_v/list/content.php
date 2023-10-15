<?php $i = 1; ?>
<?php foreach ($items as $item) { ?>
    <div class="col-xxl-4 col-lg-6">
        <div class="project-box">
            <a href="<?php echo base_url("site/file_form/$item->id"); ?>"><h4><?php echo $i++." - ".$item->santiye_ad; ?></h4>
            </a>
            <div class="media"><img class="img-20 me-1 rounded-circle" src="../assets/images/user/3.jpg" alt=""
                                    data-original-title="" title="">
                <div class="media-body">
                    <p><?php echo $item->dosya_no; ?></p>
                </div>
            </div>
            <p><h6><?php echo project_name($item->proje_id); ?> Projesine Bağlı Şantiye</h6></p>
            <div class="row details">
                <div class="col-6"><span>Şantiye Şefi</span></div>
                <div class="col-6 text-primary">
                    <a href="<?php echo base_url("user/file_form/$item->santiye_sefi"); ?>">
                        <img class="img-60 d-inline-block rounded-circle" <?php echo get_avatar($item->santiye_sefi); ?>
                             alt="" data-original-title="" title="asd">
                    </a>
                </div>
                <hr>
                <div class="col-6"><span>Günlük Rapor Sayısı</span></div>
                <div class="col-6 text-primary"><?php echo count(get_from_any_array("report","site_id","$item->id")); ?></div>
                <hr>
                <div class="col-6"><span>Teknik Personeller</span></div>
                <div class="col-6 text-primary">  <?php if (!empty($item->teknik_personel)) { ?>
                        <?php foreach (get_as_array($item->teknik_personel) as $personel) { ?>
                            <a href="<?php echo base_url("user/file_form/$personel"); ?>">
                                <img class="img-60 d-inline-block rounded-circle" <?php echo get_avatar($personel); ?>
                                     alt="" data-original-title="" title="asd">
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>








