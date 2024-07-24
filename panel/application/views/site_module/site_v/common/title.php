<?php
if ($subViewFolder == "add") { ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>
                        <?php echo "Yeni $this->Module_Title Oluştur"; ?>
                    </h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li>
                            <button type="submit" form="save" class="btn btn-success">
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                            </button>
                            <a class="btn btn-primary" href="<?php echo base_url("$this->Module_Name/"); ?>">
                                <i class="fa fa-times"></i> İptal
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php } elseif ($subViewFolder == "display") { ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>
                        <?php echo "$this->Module_Title Görüntüle"; ?>
                    </h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li>
                            <a class="btn btn-success" type="button"
                               href="<?php echo base_url("$this->Module_Name/update_form/$item->id"); ?>">
                                <i class="menu-icon fa fa-edit fa-lg"></i> Düzenle
                            </a>
                            <button class="btn btn-danger" type="button" onclick="deleteConfirmationModule(this)"
                                    data-text="<?php echo $this->Module_Title; ?>"
                                    data-url="<?php echo base_url("$this->Module_Name/delete/$item->id"); ?>"
                                    url="<?php echo base_url("$this->Module_Name/delete/$item->id"); ?>">
                                <i class="menu-icon fa fa-trash fa-xl" aria-hidden="true"></i> Sil
                            </button>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

