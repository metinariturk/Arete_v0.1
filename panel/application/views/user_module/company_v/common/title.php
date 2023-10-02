<?php
if ($subViewFolder == "list") { ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>
                        <?php echo "$this->Module_Title Listesi"; ?>
                    </h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        <li>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" data-bs-original-title="" title="">+ Yeni Firma
                            </button>
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Yeni <?php echo $this->Module_Title; ?></h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/new_form"); ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                                Kapat
                                            </button>
                                            <button class="btn btn-primary" form="new_company" type="submit">Kaydet
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<?php } elseif ($subViewFolder == "update") { ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>
                        <?php echo "$this->Module_Title Güncelle"; ?>
                    </h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li>
                            <button class="btn btn-danger" type="button" onclick="cancelConfirmationModule(this)"
                                    url="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                <i class="menu-icon fa fa-close fa-lg" aria-hidden="true"></i> İptal
                            </button>
                            <button type="submit" form="update_<?php echo $this->Module_Name; ?>"
                                    class="btn btn-success">
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                            </button>
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
<?php }  elseif ($subViewFolder == "delete_form") { ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>
                        <?php echo "$this->Module_Title Sil"; ?>
                    </h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li>
                            <button class="btn btn-danger" type="button"
                                    onclick="window.history.go(-1); return false;"
                            <i class="menu-icon fa fa-trash fa-xl" aria-hidden="true"></i> Geri
                            </button>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

