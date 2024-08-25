<?php
if ($subViewFolder == "list") {
    $title = "$this->Module_Title Listesi";
    $base_url = base_url("$this->Module_Name/new_form");
    $button_group = '
                    <a class="btn btn-primary" href="'.$base_url.'"> 
                   <i class="menu-icon fa fa-edit fa-lg"></i> Yeni '.$this->Module_Title.' Oluştur
                    </a>';
} elseif ($subViewFolder == "add") {
    $title = "Yeni $this->Module_Title Oluştur";
    $module_url = base_url("$this->Module_Name/");
    $button_group = '
                    <button type="submit" form="save_'.$this->Module_Name.'" class="btn btn-success">
                        <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                    </button>
                    <a class="btn btn-primary" href="'.$module_url.'"> 
                   <i class="fa fa-times"></i> İptal
                    </a>
                    ';
} elseif ($subViewFolder == "update") {
    $title = "$this->Module_Title Güncelle";
    $display_url = base_url("$this->Module_Name/file_form/$item->id");
    $button_group = '
                    <button class="btn btn-danger" type="button" onclick="cancelConfirmationModule(this)" 
                        url="' . $display_url . '">
                    <i class="menu-icon fa fa-close fa-lg" aria-hidden="true"></i> İptal
                    </button>
                     <button type="submit" form="update_'.$this->Module_Name.'" class="btn btn-success">
                            <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                     </button>
                     ';
}
?>