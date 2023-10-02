<?php if ("{$subViewFolder}" == "display") { ?>
<div class="row content-container">
    <div id="left" class="text-left">
        <a class="pager-btn btn btn-purple btn-outline"
           href="<?php echo base_url("safety/file_form/$item->safety_id"); ?>">
            <i class="fas fa-arrow-left"></i>
            İSG Ana Sayfa
        </a>
    </div>
    <div id="left" class="text-left">
        <a class="pager-btn btn btn-purple btn-outline"
           href="<?php echo base_url("site/file_form/$item->site_id"); ?>">
            <i class="fas fa-arrow-left"></i>
            Şantiye Ana Sayfa
        </a>
    </div>
    <div id="right" class="text-right">
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
               href="<?php echo base_url("safety/file_form/$id/7"); ?>">
                <i class="fas fa-home"></i>
                İSG Ana Sayfa
            </a>
        </div>
        <div id="left" class="text-left">
            <a class="pager-btn btn btn-purple btn-outline"
               href="<?php echo base_url("site/file_form/$sid"); ?>">
                <i class="fas fa-home"></i>
                Şantiye Ana Sayfa
            </a>
        </div>
        <div id="right" class="text-right">
            <button type="submit" class="pager-btn btn btn-info btn-outline"><i class="fa fa-floppy-o" aria-hidden="true"></i> Kaydet</button>
        </div>
    </div>
<?php } elseif ("{$subViewFolder}" == "update" ) { ?>
    <div class="row content-container">
        <div id="left" class="text-left">
            <a class="pager-btn btn btn-purple btn-outline"
               href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                <i class="fas fa-home"></i>
                Çalışan Ana Sayfa
            </a>
        </div>
        <div id="right" class="text-right">
            <button type="submit" class="pager-btn btn btn-info btn-outline"><i class="fa fa-floppy-o" aria-hidden="true"></i> Güncelle</button>
        </div>
    </div>
<?php } elseif ("{$subViewFolder}" == "list") { ?>
    <div class="row content-container">
        <div id="left" class="text-left">
            <a class="pager-btn btn btn-purple btn-outline"
               href="<?php echo base_url("$this->Module_Name/file_form"); ?>">
                <i class="fas fa-home"></i>
                Ana Sayfa
            </a>
        </div>

        <div id="right" class="text-right">
            <a class="pager-btn btn btn-info btn-outline"
               href="<?php echo base_url("$this->Module_Name/new_form"); ?>">
                <i class="fas fa-edit"></i> Düzenle
            </a>
        </div>
    </div>
<?php } ?>

