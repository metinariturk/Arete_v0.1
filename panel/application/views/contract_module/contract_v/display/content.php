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
                Sözleşme Raporu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               id="tab3-link" data-bs-toggle="tab" href="#tab3" role="tab"
               tabindex="-1"
               aria-selected="false">
                Hakedişler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               id="tab4-link" data-bs-toggle="tab" href="#tab4" role="tab"
               tabindex="-1"
               aria-selected="false">
                Ödemeler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               id="tab5-link" data-bs-toggle="tab" href="#tab5" role="tab"
               tabindex="-1"
               aria-selected="false">
                Sözleşme Fiyatları
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
                   onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_contract_modal/$item->id"); ?>','edit_contract_modal','EditContractModal')">
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
                               url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>">
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

                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="<?php echo base_url("$this->Module_Name/delete_form/$item->id"); ?>">
                                <i class="fa fa-trash"></i> Sil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="change_Status(this)"
                               url="<?php echo base_url("$this->Module_Name/changeStatus/$item->id"); ?>"
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
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_1_info"); ?>
                    <div id="edit_contract_modal">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/contract/edit_contract_modal_form"); ?>
                    </div>
                    <div id="add_sub_contract_modal">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sub_contract/add_sub_contract_modal_form"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab2" role="tabpanel"
         aria-labelledby="tab2-link">
        <div class="card">
            <div class="card-body">
                <h5>Sözleşme Rapor</h5>
                <div class="download_links mt-3">
                    <a href="<?php echo base_url("export/contract_report_excel/$item->id"); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url("export/contract_report_pdf/$item->id/1"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_2_report"); ?>

            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab3" role="tabpanel"
         aria-labelledby="tab3-link">
        <div class="card">
            <div class="card-body">
                <h5>Hakediş Listesi</h5>
                <div class="download_links mt-3">
                    <i class="fa fa-plus fa-2x text-primary" id="openPaymentModal"
                       style="cursor: pointer;" data-bs-toggle="modal"
                       data-bs-target="#AddPaymentModal" title="Yeni Hakediş Oluştur"
                       aria-hidden="true">
                    </i>

                    <a href="<?php echo base_url("export/sitestock_download_excel/$item->id"); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url("export/sitestock_download_pdf/$item->id"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>

                <div id="payment_table">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/payment/payment_table"); ?>
                </div>
                <div id="add_payment_modal">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/payment/add_payment_modal"); ?>
                </div>
                <div id="edit_payment_modal">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/payment/edit_payment_modal_form"); ?>
                </div>
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
                            <h5>Ödemeler</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab4-2-link"
                           data-bs-toggle="tab" href="#tab4-2" role="tab">
                            <h5>Avanslar</h5>
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
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/collection/collection_table"); ?>
                        </div>
                        <div id="add_collection_modal">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/collection/add_collection_modal"); ?>
                        </div>
                        <div id="edit_collection_modal">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/collection/edit_collection_modal_form"); ?>
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
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/advance/advance_table"); ?>
                        </div>
                        <div id="add_advance_modal">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/advance/add_advance_modal"); ?>
                        </div>
                        <div id="edit_advance_modal">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/advance/edit_advance_modal_form"); ?>
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
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/bond/bond_table"); ?>
                        </div>
                        <div id="add_bond_modal">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/bond/add_bond_modal"); ?>
                        </div>
                        <div id="edit_bond_modal">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/bond/edit_bond_modal_form"); ?>
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
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_5_a_contract_price_table"); ?>
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
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/pricegroup/pricegroup_table"); ?>
                        </div>

                        <div id="edit_pricegroup_modal">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/pricegroup/edit_pricegroup_modal_form"); ?>
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
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_5_c_price_book"); ?>
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
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_5_d_work_group"); ?>
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
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/folder/folder_table"); ?>
                </div>
                <div id="add_folder_modal">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/folder/add_folder_modal"); ?>
                </div>
                <div id="edit_folder_modal">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/folder/edit_folder_modal_form"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

