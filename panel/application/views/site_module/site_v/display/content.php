<div class="text-center">
    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-link" data-bs-toggle="tab" href="#tab1" role="tab" aria-selected="true">
                Genel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2-link" data-bs-toggle="tab" href="#tab2" role="tab" aria-selected="false">
                Günlük Rapor
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab3-link" data-bs-toggle="tab" href="#tab3" role="tab" aria-selected="false">
                Depo / Stok
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab4-link" data-bs-toggle="tab" href="#tab4" role="tab" aria-selected="false">
                Kasa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab5-link" data-bs-toggle="tab" href="#tab5" role="tab" aria-selected="false">
                Personel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab6-link" data-bs-toggle="tab" href="#tab6" role="tab" aria-selected="false">
                Rapor Ayarları
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab7-link" data-bs-toggle="tab" href="#tab7" role="tab" aria-selected="false">
                Tutanaklar
            </a>
        </li>
    </ul>
    <br>
    <h5><?php echo $item->santiye_ad; ?> Şantiyesi </h5>

</div>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-link">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- Başlık -->

                <a data-bs-toggle="modal" class="text-primary"
                   id="open_edit_contract_modal "
                   onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_site_modal/$item->id"); ?>','edit_site_modal','EditSiteModal')">
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
                               url="<?php echo base_url("Site/favorite/$item->id"); ?>">
                                <i class="fa <?php echo $fav ? 'fa-times' : 'fa-star'; ?>"
                                   style="<?php echo $fav ? 'color: tomato;' : 'color: gold;'; ?>"></i>
                                <span><?php echo $fav ? 'Favori Çıkart' : 'Favori Ekle'; ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="<?php echo base_url("Site/delete_form/$item->id"); ?>">
                                <i class="fa fa-trash"></i> Sil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="change_Status(this)"
                               url="<?php echo base_url("Site/changestatus/$item->id"); ?>"
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
                <?php $this->load->view("site_module/site_v/display/tabs/tab_1_info"); ?>

            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-link">
        <div class="card">
            <div class="card-body">
                <h5>Günlük Rapor</h5>
                <div class="download_links mt-3">
                    <a href="<?php echo base_url("Report/new_form/$item->id"); ?>">
                        <i class="fa fa-plus fa-2x me-0"
                           style="cursor: pointer;"></i>
                    </a>
                    <a href="<?php echo base_url("export/report_download_excel/$item->id"); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <?php $this->load->view("site_module/site_v/display/tabs/tab_2_report"); ?>

            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-link">
        <div class="card">
            <div class="card-body">
                <h5>Depo / Stok</h5>
                <div class="download_links mt-3">
                    <i class="fa fa-plus fa-2x me-0"
                       style="cursor: pointer;"
                       data-bs-toggle="modal"
                       data-bs-target="#AddStockModal"></i>
                    <a href="<?php echo base_url("export/sitestock_download_excel/$item->id"); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url("export/sitestock_download_pdf/$item->id"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <div id="tab_sitestock">
                    <?php $this->load->view("site_module/site_v/display/tabs/tab_3_sitestock"); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab4-1-link"
                           data-bs-toggle="tab" href="#tab4-1" role="tab">
                            <h5>Harcamalar</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab4-2-link"
                           data-bs-toggle="tab" href="#tab4-2" role="tab">
                            <h5>Avanslar</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab4-1" role="tabpanel" aria-labelledby="tab4-1-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddExpenseModal"></i>
                            <a href="<?php echo base_url('export/sitewallet_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/sitewallet_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_expenses">
                            <?php $this->load->view("site_module/site_v/display/tabs/tab_4_1_expenses"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab4-2" role="tabpanel" aria-labelledby="tab4-2-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddDepositModal"></i>
                            <a href="<?php echo base_url('export/sitewallet_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/sitewallet_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_deposits">
                            <?php $this->load->view("site_module/site_v/display/tabs/tab_4_2_deposits"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab5-1-link"
                           data-bs-toggle="tab" href="#tab5-1" role="tab">
                            <h5>Personel Liste</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab5-2-link"
                           data-bs-toggle="tab" href="#tab5-2" role="tab">
                            <h5>Puantaj</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab5-1" role="tabpanel" aria-labelledby="tab5-1-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddPersonelModal"></i>
                            <a href="<?php echo base_url("export/report_download_excel/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_personel">
                            <?php $this->load->view("site_module/site_v/display/tabs/tab_5_1_personel"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab5-2" role="tabpanel" aria-labelledby="tab5-2-link">
                        <div class="download_links mt-3">
                            <a href="#" onclick="sendPuantajDate('excel')">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="#" onclick="sendPuantajDate('pdf')">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_puantaj">
                            <?php $this->load->view("site_module/site_v/display/tabs/tab_5_2_puantaj"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab6-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab6-1-link"
                           data-bs-toggle="tab" href="#tab6-1" role="tab">
                            <h5>İş Grupları</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab6-2-link"
                           data-bs-toggle="tab" href="#tab6-2" role="tab">
                            <h5>İş Makineleri</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab6-3-link"
                           data-bs-toggle="tab" href="#tab6-3" role="tab">
                            <h5>İmalat Takip</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab6-4-link"
                           data-bs-toggle="tab" href="#tab6-4" role="tab">
                            <h5>İmzalar</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab6-1" role="tabpanel" aria-labelledby="tab6-1-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddWorker"></i>
                            <a href="<?php echo base_url('export/active_worker_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/active_worker_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <?php $this->load->view("site_module/site_v/display/tabs/tab_6_1_workgroup"); ?>
                    </div>
                    <div class="tab-pane fade" id="tab6-2" role="tabpanel" aria-labelledby="tab6-2-link">
                        <?php $this->load->view("site_module/site_v/display/tabs/tab_6_2_workmachine"); ?>
                    </div>
                    <div class="tab-pane fade" id="tab6-3" role="tabpanel" aria-labelledby="tab6-3-link">
                        <div class="mt-3">
                            <!-- 6-3 tab content -->
                            <?php $this->load->view("site_module/site_v/display/tabs/tab_6_3_follow"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab6-4" role="tabpanel" aria-labelledby="tab6-4-link">
                        <div class="mt-3">
                            <!-- 6-4 tab content -->
                            <?php $this->load->view("site_module/site_v/display/tabs/tab_6_4_sign"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>