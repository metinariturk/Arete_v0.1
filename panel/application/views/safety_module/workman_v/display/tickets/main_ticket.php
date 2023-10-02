
<div class="bg-color-op-green">
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>Proje</strong></div>
        <div class="col-md-6">
            <a href="<?php echo base_url("project/file_form/$project->id"); ?>">
                <?php echo $project->proje_kodu." / ".$project->proje_ad; ?>
            </a>
        </div>
    </div>
    <?php if (isset($contract)) { ?>
        <div class="clearfix m-b-sm">
            <div class="col-md-4"><strong>Sözleşme</strong></div>
            <div class="col-md-6">
                <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                    <?php echo $contract->dosya_no." / ".$contract->sozlesme_ad; ?>
                </a>
            </div>
        </div>
    <?php } ?>
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>Şantiye</strong></div>
        <div class="col-md-6">
            <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                <?php echo $site->dosya_no. " / " . $site->santiye_ad; ?>
            </a>
        </div>
    </div>

    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>İş Yeri</strong></div>
        <div class="col-md-6">
            <a href="<?php echo base_url("safety/file_form/$safety->id"); ?>">
                <?php echo $safety->dosya_no . " / " . $site->santiye_ad; ?>
            </a>
        </div>
    </div>
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>İş Yeri Sicili</strong></div>
        <div class="col-md-6"><?php echo $safety->sicil_no; ?></div>
    </div>
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>Ad Soyad</strong></div>
        <div class="col-md-6"><?php echo $item->name . " " . $item->surname; ?></div>
    </div>
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>İşe Giriş</strong></div>
        <div class="col-md-6"><?php echo dateFormat_dmy($item->start_date); ?></div>
    </div>
    <div class="clearfix m-b-sm">
        <div class="col-md-4 pull-left"><strong>Çalıştığı Süre</strong></div>
        <div class="col-md-6"><?php echo calistigi_gun($item->start_date); ?></div>
    </div>
    <div class="clearfix m-b-sm">
        <div class="col-md-4 pull-left"><strong>Mesleği</strong></div>
        <div class="col-md-6"><?php echo group_name($item->group); ?></div>
    </div>
    <?php if (!empty($item->end_date)) { ?>
        <div class="clearfix m-b-sm">
            <div class="col-md-4"><strong>Çıkış Tarih</strong></div>
            <div class="col-md-6"><?php echo dateFormat_dmy($item->end_date); ?></div>
        </div>
    <?php } ?>
</div>
