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
        <a href="<?php echo base_url('export/sitewallet_download_excel'); ?>">
            <i class="fa fa-file-excel-o fa-2x"></i>
        </a>
        <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
            <i class="fa fa-file-pdf-o fa-2x"></i>
        </a>
    </div>
    <div id="tab_contract_price">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_5_b_contract_price"); ?>
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