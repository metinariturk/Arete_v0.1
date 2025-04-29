<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);"
                   id="tab5-1-link"
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
            <div class="tab-pane fade show active" id="tab5-1" role="tabpanel"
                 aria-labelledby="tab5-1-link">
                <div class="download_links mt-3">
                    <a href="<?php echo base_url("export/report_download_excel/$item->id"); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <div id="tab_contract_price_table">
                    <?php $this->load->view("contract_module/contract_v/display/pricegroup/tab_5_a_contract_price_table"); ?>
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
                    <?php $this->load->view("contract_module/contract_v/display/pricegroup/pricegroup_table"); ?>
                </div>

                <div id="edit_pricegroup_modal">
                    <?php $this->load->view("contract_module/contract_v/display/pricegroup/edit_pricegroup_modal_form"); ?>
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
                    <?php $this->load->view("contract_module/contract_v/display/pricegroup/tab_5_c_price_book"); ?>
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
                    <?php $this->load->view("contract_module/contract_v/display/pricegroup/tab_5_d_work_group"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
