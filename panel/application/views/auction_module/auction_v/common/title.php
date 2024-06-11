<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <?php if ($subViewFolder == "list"): ?>
                    <h3><?php echo "$this->Module_Title Listesi"; ?></h3>
                <?php elseif ($subViewFolder == "add"): ?>
                    <h3><?php echo "Yeni $this->Module_Title Oluştur"; ?></h3>
                <?php elseif ($subViewFolder == "update"): ?>
                    <h3><?php echo "$this->Module_Title Güncelle"; ?></h3>
                <?php elseif ($subViewFolder == "display"): ?>
                    <h3>İhale / <?php echo "$item->ihale_ad"; ?></h3>
                <?php elseif ($subViewFolder == "delete_form"): ?>
                    <h3><?php echo "$this->Module_Title Sil"; ?></h3>
                <?php endif; ?>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li>
                        <?php if ($subViewFolder == "list"): ?>
                            <button class="btn btn-primary"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalgetbootstrap"
                                    data-whatever="@getbootstrap">
                                <i class="menu-icon fa fa-edit fa-lg"></i> Yeni <?php echo $this->Module_Title; ?>
                                Oluştur
                            </button>
                            <!-- Modal -->
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
                                                  action="<?php echo base_url("$this->Module_Name/new_form/auction_newform"); ?>"
                                                  method="post"
                                                  enctype="multipart">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Proje
                                                        Seçiniz</label>
                                                    <select class="form-control" name="proje_id">
                                                        <?php foreach ($projects as $project): ?>
                                                            <option value="<?php echo $project->id; ?>">
                                                                <?php echo $project->project_name; ?>
                                                            </option>
                                                        <?php endforeach; ?>
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
                        <?php elseif ($subViewFolder == "add"): ?>
                            <button type="submit" form="save_<?php echo $this->Module_Name; ?>" class="btn btn-success">
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                            </button>
                            <a class="btn btn-primary" href="<?php echo base_url("$this->Module_Name/"); ?>">
                                <i class="fa fa-times"></i> İptal
                            </a>
                        <?php elseif ($subViewFolder == "update"): ?>
                            <button class="btn btn-danger" type="button" onclick="cancelConfirmationModule(this)"
                                    url="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                <i class="menu-icon fa fa-close fa-lg" aria-hidden="true"></i> İptal
                            </button>
                            <button type="submit" form="update_<?php echo $this->Module_Name; ?>"
                                    class="btn btn-success">
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                            </button>
                        <?php elseif ($subViewFolder == "display"): ?>
                            <div class="card-body dropdown-basic">
                                <div class="dropdown">
                                    <button class="dropbtn btn-primary" type="button">Dropdown Button <span><i class="icofont icofont-arrow-down"></i></span></button>
                                    <div class="dropdown-content"><a href="#">Link 1</a><a href="#">Link 2</a><a href="#">Link 3</a><a href="#">Another Link</a></div>
                                </div>
                            </div>
                        <?php elseif ($subViewFolder == "delete_form"): ?>
                            <button class="btn btn-danger" type="button"
                                    onclick="window.history.go(-1); return false;">
                                <i class="menu-icon fa fa-trash fa-xl" aria-hidden="true"></i> Geri
                            </button>
                        <?php endif; ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
