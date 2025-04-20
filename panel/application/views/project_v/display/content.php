<div class="text-center">
    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active"
               id="tab1-link" data-bs-toggle="tab" href="#tab1" role="tab"
               tabindex="active"
               aria-selected="true">
                Genel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               id="tab2-link" data-bs-toggle="tab" href="#tab2" role="tab"
               tabindex="-1"
               aria-selected="false">
                Sözleşmeler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               id="tab3-link" data-bs-toggle="tab" href="#tab3" role="tab"
               tabindex="-1"
               aria-selected="false">
                Şantiyeler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               id="tab4-link" data-bs-toggle="tab" href="#tab4" role="tab"
               tabindex="-1"
               aria-selected="false">
                Finansal Durum
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               id="tab6-link" data-bs-toggle="tab" href="#tab6" role="tab"
               tabindex="-1"
               aria-selected="false">
                Dosya Yöneticisi
            </a>
        </li>
    </ul>
</div>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-link">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- Başlık -->

                <a data-bs-toggle="modal" class="text-primary"
                   id="open_edit_contract_modal "
                   onclick="edit_modal_form('<?php echo base_url("Project/open_edit_project_modal/$item->id"); ?>','edit_project_modal','EditProjectModal')">
                    <i class="fa fa-edit fa-lg"></i>
                </a>

                <!-- Dropdown Menüsü -->
                <div class="dropdown">
                    <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-h fa-2x"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                        <li>
                            <a class="dropdown-item" onclick="changeIcon(this)" style="cursor: pointer;"
                               url="<?php echo base_url("Project/favorite/$item->id"); ?>">
                                <i class="fa <?php echo $fav ? 'fa-times' : 'fa-star'; ?>"
                                   style="<?php echo $fav ? 'color: tomato;' : 'color: gold;'; ?>"></i>
                                <span><?php echo $fav ? 'Favori Çıkart' : 'Favori Ekle'; ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('export/'); ?>">
                                <i class="fa fa-file-excel-o"></i> Excel'e Aktar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('export/'); ?>">
                                <i class="fa fa-file-pdf-o"></i> PDF'e Aktar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="<?php echo base_url("Project/delete_form/$item->id"); ?>">
                                <i class="fa fa-trash"></i> Sil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="change_Status(this)"
                               url="<?php echo base_url("Project/changestatus/$item->id"); ?>"
                               style="cursor: pointer;">
                                <i class="fa <?php echo ($item->isActive == 1) ? 'fa-check' : 'fa-circle-o-notch'; ?>"
                                   style="<?php echo ($item->isActive == 1) ? 'color: green;' : 'color: blue;'; ?>"></i>
                                <span>
                                   <?php echo ($item->isActive == 1) ? 'Tamamlandı Olarak İşaretle' : 'Devam Ediyor Olarak İşaretle'; ?>
                               </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="tab_Contract">
                    <?php $this->load->view("project_v/display/tabs/tab_1_info"); ?>
                    <div id="add_contract_modal">
                        <?php $this->load->view("project_v/display/contract/add_contract_modal_form"); ?>
                    </div>
                    <div id="add_site_modal">
                        <?php $this->load->view("project_v/display/site/add_site_modal_form"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab2" role="tabpanel"
         aria-labelledby="tab2-link">
        <div class="card">
            <div class="card-body">
                <?php $this->load->view("project_v/display/tabs/tab_2_contracts_info"); ?>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab3" role="tabpanel"
         aria-labelledby="tab3-link">
        <div class="card">
            <div class="card-body">
                <?php $this->load->view("project_v/display/tabs/tab_3_sites_info"); ?>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab4" role="tabpanel"
         aria-labelledby="tab4-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab4-1-link"
                           data-bs-toggle="tab" href="#tab4-1" role="tab">
                            <h5>Alınan Ödemeler</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab4-2-link"
                           data-bs-toggle="tab" href="#tab4-2" role="tab">
                            <h5>Yapılan Ödemeler</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab4-3-link"
                           data-bs-toggle="tab" href="#tab4-3" role="tab">
                            <h5>Teminatlar</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab4-1" role="tabpanel" aria-labelledby="tab4-1-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;"
                               id="openCollectionModal"
                               onclick="open_modal('AddCollectionModal')"></i>
                            <a href="<?php echo base_url('export/collection_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/collection_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="collection_table">
                        </div>
                        <div id="add_collection_modal">
                        </div>
                        <div id="edit_collection_modal">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab4-2" role="tabpanel" aria-labelledby="tab4-2-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               id="openAdvanceModal"
                               data-bs-target="#AddAdvanceModal"></i>
                            <a href="<?php echo base_url('export/advance_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/advance_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="advance_table">
                        </div>
                        <div id="add_advance_modal">
                        </div>
                        <div id="edit_advance_modal">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab4-3" role="tabpanel" aria-labelledby="tab4-3-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               id="openBondModal"
                               data-bs-target="#AddBondModal"></i>
                            <a href="<?php echo base_url('export/bond_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/bond_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="bond_table">
                        </div>
                        <div id="add_bond_modal">
                        </div>
                        <div id="edit_bond_modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab5" role="tabpanel"
         aria-labelledby="tab5-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab5-1-link"
                           data-bs-toggle="tab" href="#tab5-1" role="tab">
                            <h5>Birim Fiyat Tablo</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);"
                           id="tab5-2-link"
                           data-bs-toggle="tab" href="#tab5-2" role="tab">
                            <h5>Poz Grupları</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab5-3-link"
                           data-bs-toggle="tab" href="#tab5-3" role="tab">
                            <h5>Poz Kitabı</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab5-4-link"
                           data-bs-toggle="tab" href="#tab5-4" role="tab">
                            <h5>Sözleşme İş Grupları</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab5-1" role="tabpanel" aria-labelledby="tab5-1-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url("export/report_download_excel/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_contract_price_table">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab5-2" role="tabpanel" aria-labelledby="tab5-2-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url('export/'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url("export/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="pricegroup_table">
                        </div>

                        <div id="edit_pricegroup_modal">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab5-3" role="tabpanel" aria-labelledby="tab5-3-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url("export/book_download_excel/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_price_book">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab5-4" role="tabpanel" aria-labelledby="tab5-4-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url("export/book_download_excel/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div class="refresh_tab_5" name="refresh_tab_5" id="refresh_tab_5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab6" role="tabpanel"
         aria-labelledby="tab6-link">
        <div class="card">
            <div class="card-body">
                <h5>Dosya Yöneticisi</h5>
                <div class="download_links mt-3">
                    <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;"
                       id="openCollectionModal"
                       onclick="open_modal('AddFolderModal')"></i>
                </div>
                <div id="folder_table">
                    <div class="file-content">
                        <div class="fileuploader fileuploader-theme-dragdrop">
                            <form method="post" enctype="multipart/form-data">
                                <?php
                                $uploadDir = $path;
                                $preloadedFiles = array();
                                $uploadsFiles = array_diff(scandir($uploadDir), array('.', '..'));
                                foreach ($uploadsFiles as $file) {
                                    if (is_dir($uploadDir . $file))
                                        continue;
                                    $preloadedFiles[] = array(
                                        "name" => $file,
                                        "auc_id" => $item->id,
                                        "type" => FileUploader::mime_content_type($uploadDir . $file),
                                        "size" => filesize($uploadDir . $file),
                                        "file" => base_url($path) . $file,
                                        "local" => base_url($path) . $file,
                                    );
                                }
                                $preloadedFiles = json_encode($preloadedFiles);
                                ?>
                                <input type="file" name="files"
                                       data-fileuploader-files='<?php echo $preloadedFiles; ?>'>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

