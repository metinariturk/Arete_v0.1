<?php if ("{$subViewFolder}" == "update" ) { ?>
    <div class="row content-container">
        <div id="left" class="text-left">
            <a class="pager-btn btn btn-purple btn-outline"
               href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                <i class="fas fa-arrow-left"></i>
                Geri
            </a>
        </div>
        <div id="right" class="text-right">
            <button type="submit"class="pager-btn btn btn-info btn-outline"><i class="fa fa-floppy-o" aria-hidden="true"></i> Kaydet</button>
        </div>
    </div>
<?php } elseif ("{$subViewFolder}" == "display" ) { ?>
<div class="row content-container">
    <div id="left" class="text-left">
        <?php if ($item->contract_id > 0) { ?>
        <a class="pager-btn btn btn-purple btn-outline"
           href="<?php echo base_url("$this->Module_Parent_Name/file_form/$item->contract_id"); ?>">
            <i class="fas fa-arrow-left"></i>
            Sözleşmeye Git
        </a>
        <?php } ?>
        <?php if (isset($item->site_id)) { ?>
            <a class="pager-btn btn btn-purple btn-outline"
               href="<?php echo base_url("site/file_form/$item->site_id"); ?>">
                <i class="fas fa-arrow-left"></i>
                Şantiyeye Git
            </a>
        <?php } ?>
    </div>
    <div id="right" class="text-right">
        <a class="pager-btn btn btn-danger btn-outline" onclick="deleteConfirmationFile(this)" data-text="Bu İşyerini"
           data-note="Bağlı Tüm Alt Dosyaları Silinecek, Bu İşlem Geri Alınamaz"
           data-url="<?php echo base_url("$this->Module_Name/delete/$item->id"); ?>">
            <i class="fa fa-trash"></i> Herşeyi Sil
        </a>
    </div>
    <div class="text-center">
        <a class="pager-btn btn btn-info btn-outline"
           href="<?php echo base_url("$this->Module_Name/update_form/$item->id"); ?>">
            <i class="fas fa-edit"></i> Düzenle
        </a>
    </div>
</div>
<?php } elseif ("{$subViewFolder}" == "add" ) { ?>
    <div class="row content-container">
        <div id="left" class="text-left">
            <a class="pager-btn btn btn-purple btn-outline"
               <?php if (isset($from)) { ?>
               href="<?php echo base_url("$from/file_form/$sid"); ?>">
                <?php } else { ?>
               href="<?php echo base_url("$this->Module_Name/file_form/$sid"); ?>">
                <?php } ?>
                <i class="fas fa-arrow-left"></i>
                Şantiyeyi Görüntüle
            </a>
        </div>
        <div id="right" class="text-right">
            <button type="submit"class="pager-btn btn btn-info btn-outline"><i class="fa fa-floppy-o" aria-hidden="true"></i> Kaydet</button>
        </div>
    </div>
<?php } elseif ("{$subViewFolder}" == "select" ) { ?>
    <div class="row content-container">
        <div id="left" class="text-left">
            <a class="pager-btn btn btn-purple btn-outline"
               href="<?php echo base_url("$this->Module_Name"); ?>">
                <i class="fas fa-arrow-left"></i>
                Listeye Geri Dön
            </a>
        </div>
        <div id="right" class="text-right">
            <button type="submit"class="pager-btn btn btn-info btn-outline"><i class="fa fa-floppy-o" aria-hidden="true"></i> Oluştur</button>
        </div>
    </div>
<?php } ?>

