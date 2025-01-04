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
                            <button class="btn btn-primary"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalgetbootstrap"
                                    data-whatever="@getbootstrap">
                                <i class="menu-icon fa fa-edit fa-lg"></i> Yeni <?php echo $this->Module_Title; ?>
                                Oluştur
                            </button>
                            <div class="modal fade" id="exampleModalgetbootstrap" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Yeni <?php echo $this->Module_Title; ?></h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="proje_id"
                                                  action="<?php echo base_url("$this->Module_Name/new_form_project"); ?>"
                                                  method="post"
                                                  enctype="multipart">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Proje
                                                        Seçiniz</label>
                                                    <select class="form-control" name="proje_id">
                                                        <?php foreach ($projects as $project) { ?>
                                                            <option value="<?php echo "$project->id"; ?>">
                                                                <?php echo "$project->project_name"; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                                Kapat
                                            </button>
                                            <button class="btn btn-primary" form="proje_id" type="submit">Yeni Teklif
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
<?php } elseif ($subViewFolder == "add_main") { ?>
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
                            <button type="submit" form="save_main" class="btn btn-success">
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
<?php } elseif ($subViewFolder == "add_offer") { ?>
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
                            <button type="submit" form="save_offer" class="btn btn-success">
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
<?php } elseif ($subViewFolder == "add_sub") { ?>
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
                            <button type="submit" form="save_sub" class="btn btn-success">
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
<?php } elseif ($subViewFolder == "update_payment") { ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>
                        <?php echo "$this->Module_Title Hakediş Ayarları Güncelle"; ?>
                    </h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li>
                            <button class="btn btn-danger" type="button" onclick="cancelConfirmationModule(this)"
                                    url="<?php echo base_url("$this->Module_Name/file_form/$item->id/payment"); ?>">
                                <i class="menu-icon fa fa-close fa-lg" aria-hidden="true"></i> İptal
                            </button>
                            <button type="submit" form="update_payment"
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

<?php } elseif ($subViewFolder == "delete_form") { ?>
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
