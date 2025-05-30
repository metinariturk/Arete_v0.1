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
                Hakediş İmza Ayarları
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab6-link" data-bs-toggle="tab" href="#tab6" role="tab" aria-selected="false">
               Sözleşme Fiyatları
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab7-link" data-bs-toggle="tab" href="#tab7" role="tab" aria-selected="false">
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
                                   href="<?php echo base_url("payment/print_all/$item->id"); ?>">
                                    <i class="fa fa-file-pdf-o"></i> Tüm Hakedişi İndir
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" target="_blank" href="<?php echo base_url("payment/print_report/$item->id"); ?>"
                                   href="<?php echo base_url("payment/print_all/$item->id"); ?>">
                                    <i class="fa fa-file-pdf-o"></i> Sayfayı İndir
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                   href="<?php echo base_url("Payment/delete/$item->id"); ?>">
                                    <i class="fa fa-trash"></i> Sil
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $this->load->view("contract_module/payment_v/display/tabs/06_tab_report"); ?>
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
                            <div class="dropdown">
                                <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h fa-2x"></i>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_lead_report/$item->id"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Sıfır Olanları Yazdırma
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_lead_report/$item->id/1"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Tümünü Yazdır
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("contract_module/payment_v/display/tabs/03A_leaders"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2-2" role="tabpanel" aria-labelledby="tab2-2-link">
                        <div class="download_links mt-3">
                            <div class="dropdown">
                                <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h fa-2x"></i>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_works_done/$item->id"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Sıfır Olanları Yazdırma
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_works_done/$item->id/1"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Tümünü Yazdır
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("contract_module/payment_v/display/tabs/03_tab_works_done"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2-3" role="tabpanel" aria-labelledby="tab2-3-link">
                        <div class="download_links mt-3">
                            <div class="dropdown">
                                <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h fa-2x"></i>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_group_total/$item->id"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> PDF İndir
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("contract_module/payment_v/display/tabs/04_tab_group_total"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2-4" role="tabpanel" aria-labelledby="tab2-4-link">
                        <div class="download_links mt-3">
                            <div class="dropdown">
                                <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h fa-2x"></i>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_main_total/$item->id"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> PDF İndir
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php $this->load->view("contract_module/payment_v/display/tabs/05_tab_main_total"); ?>
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
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);"
                           id="tab3-1-link"
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
                        <a class="nav-link" href="javascript:void(0);"
                           onclick="window.location.href='<?php echo base_url('boq/new_form/' . $item->contract_id . '/' . $item->hakedis_no); ?>';"
                           style="background-color: rgba(233,231,247,0.38);">
                            <h5>Metraj İşlemleri</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab3-1" role="tabpanel"
                         aria-labelledby="tab3-1-link">
                        <div class="download_links mt-3">
                            <div class="dropdown">
                                <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h fa-2x"></i>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Sıfır Olanları Yazdırma
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_green/$item->id"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Tümünü Yazdır
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php $this->load->view("contract_module/payment_v/display/tabs/02_tab_green"); ?>
                    </div>
                    <div class="tab-pane fade" id="tab3-2" role="tabpanel" aria-labelledby="tab3-2-link">
                        <div class="download_links mt-3">
                            <div class="dropdown">
                                <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h fa-2x"></i>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_calculate/$item->id/0"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Tüm Metrajlar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank"
                                           href="<?php echo base_url("payment/print_calculate/$item->id/2"); ?>">
                                            <i class="fa fa-file-pdf-o"></i> Alt Gruplardan Ayır
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php $this->load->view("contract_module/payment_v/display/tabs/01_tab_calculate"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab4" role="tabpanel"
         aria-labelledby="tab4-link">
        <div class="card">
            <?php $this->load->view("contract_module/payment_v/display/tabs/settings_content"); ?>
        </div>
    </div>

    <div class="tab-pane fade" id="tab5" role="tabpanel"
         aria-labelledby="tab5-link">
        <div class="card">
            <div class="card-body">
                <?php $this->load->view("contract_module/payment_v/display/tabs/tab_sign"); ?>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab6" role="tabpanel"
         aria-labelledby="tab5-link">
        <div class="card">
            <div class="card-body">
                <?php $this->load->view("contract_module/payment_v/display/tabs/tab_contract_price"); ?>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab7" role="tabpanel"
         aria-labelledby="tab7-link">
        <div class="card">
            <div class="card-body">
                <h5>Dosya Yöneticisi</h5>
                <?php $this->load->view("contract_module/payment_v/display/tabs/tab_uploads"); ?>
            </div>
        </div>
    </div>
</div>