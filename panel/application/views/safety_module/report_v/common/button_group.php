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
        <a class="pager-btn btn btn-purple btn-outline"
           href="<?php echo base_url("$this->Module_Depended_Dir/file_form/$item->site_id"); ?>">
            <i class="fas fa-arrow-left"></i>
            Şaniteyeye Geri Dön
        </a>
    </div>
    <div id="right" class="text-right">
        <a class="pager-btn btn btn-danger btn-outline" onclick="deleteConfirmationFile(this)" data-text="Bu Projeyi"
           data-note="Bağlı Fotoğraflar ve Tüm Alt Dosyaları Silinecek, Bu İşlem Geri Alınamaz"
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
               href="<?php echo base_url("$this->Module_Depended_Dir/file_form/$pid"); ?>">
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

