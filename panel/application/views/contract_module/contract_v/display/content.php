<div class="text-center">
    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-link" data-bs-toggle="tab" href="#tab1" role="tab" aria-selected="true">
                Genel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2-link" data-bs-toggle="tab" href="#tab2" onclick="loadTabContent('tab2')" role="tab" aria-selected="false">
                Sözleşme Raporu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab3-link" data-bs-toggle="tab" href="#tab3" onclick="loadTabContent('tab3')" role="tab" aria-selected="false">
                Hakedişler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab4-link" data-bs-toggle="tab" href="#tab4" onclick="loadTabContent('tab4')" role="tab" aria-selected="false">
                Ödemeler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab5-link" data-bs-toggle="tab" href="#tab5" onclick="loadTabContent('tab5')" role="tab" aria-selected="false">
                Sözleşme Fiyatları
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab6-link" data-bs-toggle="tab" href="#tab6" onclick="loadTabContent('tab6')" role="tab" aria-selected="false">
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
                               url="<?php echo base_url("Contract/favorite/$item->id"); ?>">
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
                               href="<?php echo base_url("Contract/delete_form/$item->id"); ?>">
                                <i class="fa fa-trash"></i> Sil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="change_Status(this)"
                               url="<?php echo base_url("Contract/change_status/$item->id"); ?>"
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
                    <?php $this->load->view("contract_module/contract_v/display/script_load/load_tab_1"); ?>
                    <div id="edit_contract_modal">
                        <?php $this->load->view("contract_module/contract_v/display/contract/edit_contract_modal_form"); ?>
                    </div>
                    <div id="add_sub_contract_modal">
                        <?php $this->load->view("contract_module/contract_v/display/sub_contract/add_sub_contract_modal_form"); ?>
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
                <div id="tab2-content">
                    <?php /*$this->load->view("contract_module/contract_v/display/tabs/tab_2_report"); */ ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab3" role="tabpanel"
         aria-labelledby="tab3-link">
        <div id="tab3-content">
            <!--            --><?php /*$this->load->view("contract_module/contract_v/display/payment/load_tab_3"); */?>
        </div>
    </div>

    <div class="tab-pane fade" id="tab4" role="tabpanel"
         aria-labelledby="tab4-link">
        <div id="tab4-content">
            <!--            --><?php /*$this->load->view("contract_module/contract_v/display/collection/load_tab_4"); */?>
        </div>
    </div>

    <div class="tab-pane fade" id="tab5" role="tabpanel"
         aria-labelledby="tab5-link">
        <div id="tab5-content">
        </div>
    </div>

    <div class="tab-pane fade" id="tab6" role="tabpanel"
         aria-labelledby="tab6-link">
        <div id="tab6-content">
<!--            --><?php /*$this->load->view("contract_module/contract_v/display/folder/load_tab_6"); */?>
        </div>
    </div>
</div>

