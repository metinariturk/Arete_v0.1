<div class="text-center">
    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-link" data-bs-toggle="tab" href="#tab1" role="tab" aria-selected="true">
                Kapak
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2-link" data-bs-toggle="tab" href="#tab2" role="tab" aria-selected="false">
                Hakediş Özeti
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab3-link" data-bs-toggle="tab" href="#tab3" role="tab" aria-selected="false">
                Metrajlar
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab4-link" data-bs-toggle="tab" href="#tab4" role="tab" aria-selected="false">
                Finansal Ayarlar
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab5-link" data-bs-toggle="tab" href="#tab5" role="tab" aria-selected="false">
                Sözleşme Fiyatları
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab6-link" data-bs-toggle="tab" href="#tab6" role="tab" aria-selected="false">
                Dosya Yöneticisi
            </a>
        </li>
    </ul>
</div>


<div class="tab-content">
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-link">
        <div class="card">

            <div class="card-body">
                <div class="download_links mt-3">
                    <a href="#">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a target="_blank" href="<?php echo base_url("payment/print_report/$item->id"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                    <div class="dropdown">
                        <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-h fa-2x"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                            <li>

                                <a class="dropdown-item" target="_blank"
                                   href="<?php echo base_url("payment/print_report/$item->id"); ?>">
                                    <i class="fa fa-file-excel-o"></i> Excel'e Aktar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" target="_blank"
                                   href="<?php echo base_url("payment/print_report/$item->id"); ?>">
                                    <i class="fa fa-file-pdf-o"></i> Tüm Hakedişi İndir
                                </a>
                            </li>
                            <li>

                            </li>
                            <li>
                                <a class="dropdown-item"
                                   href="<?php echo base_url("$this->Module_Name/delete/$item->id"); ?>">
                                    <i class="fa fa-trash"></i> Sil
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/06_tab_report"); ?>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab2" role="tabpanel"
         aria-labelledby="tab2-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab2-1-link"
                           data-bs-toggle="tab" href="#tab2-1" role="tab">
                            <h5>Pozlar İcmali</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab2-2-link"
                           data-bs-toggle="tab" href="#tab2-2" role="tab">
                            <h5>Yapılan İşler</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab2-3-link"
                           data-bs-toggle="tab" href="#tab2-3" role="tab">
                            <h5>Grup İcmali</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab2-4-link"
                           data-bs-toggle="tab" href="#tab2-4" role="tab">
                            <h5>Genel İcmal</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab2-1" role="tabpanel" aria-labelledby="tab2-1-link">
                        <div class="download_links mt-3">
                            <i class="my-icon">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                    <use xlink:href="<?php echo base_url('assets/images/pdf_not_zero.svg'); ?>"></use>
                                </svg>
                            </i>

                            <a target="_blank" href=" <?php echo base_url("payment/lead_hide_zero/$item->id"); ?>">
                                <i class="svg-icon"></i>
                            </a>
                            <a target="_blank" href="<?php echo base_url("payment/lead_all/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/03A_leaders"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2-2" role="tabpanel" aria-labelledby="tab2-2-link">
                        <div class="download_links mt-3">
                            <a target="_blank" href="<?php echo base_url("payment/print_group_total/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a target="_blank" href="<?php echo base_url("payment/print_group_total/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/03_tab_works_done"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2-3" role="tabpanel" aria-labelledby="tab2-3-link">
                        <div class="download_links mt-3">
                            <i class="my-icon">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                    <use xlink:href="<?php echo base_url('assets/images/pdf_not_zero.svg'); ?>"></use>
                                </svg>
                            </i>

                            <a target="_blank" href=" <?php echo base_url("payment/lead_hide_zero/$item->id"); ?>">
                                <i class="svg-icon"></i>
                            </a>
                            <a target="_blank" href="<?php echo base_url("payment/lead_all/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/04_tab_group_total"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2-4" role="tabpanel" aria-labelledby="tab2-4-link">
                        <div class="download_links mt-3">
                            <a target="_blank" href="<?php echo base_url("payment/print_main_total/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a target="_blank" href="<?php echo base_url("payment/print_main_total/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/05_tab_main_total"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab3" role="tabpanel"
         aria-labelledby="tab3-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab3-1-link"
                           data-bs-toggle="tab" href="#tab3-1" role="tab">
                            <h5>Metraj İcmali</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab3-2-link"
                           data-bs-toggle="tab" href="#tab3-2" role="tab">
                            <h5>Metraj Cetveli</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab3-3-link"
                           data-bs-toggle="tab" href="#tab3-3" role="tab">
                            <h5>Metraj İşlemleri</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab3-1" role="tabpanel" aria-labelledby="tab3-1-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url('export/collection_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/collection_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        6. olay
                    </div>
                    <div class="tab-pane fade" id="tab3-2" role="tabpanel" aria-labelledby="tab3-2-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url('export/advance_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/advance_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        7. olay
                    </div>
                    <div class="tab-pane fade" id="tab3-3" role="tabpanel" aria-labelledby="tab3-3-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url('export/advance_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/advance_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        8. olay
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab4" role="tabpanel"
         aria-labelledby="tab4-link">
        <div class="card">
            <div class="card-body">
                <h5>Finansal Ayarlar</h5>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab5" role="tabpanel"
         aria-labelledby="tab5-link">
        <div class="card">
            <div class="card-body">
                <h5>Birim Fiyatlar</h5>

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
                </div>
                <div id="add_folder_modal">
                </div>
                <div id="edit_folder_modal">
                </div>
            </div>
        </div>
    </div>
</div>

