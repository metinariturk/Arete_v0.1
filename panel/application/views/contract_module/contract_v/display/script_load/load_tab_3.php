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

        <div id="progress_payments">
            <div id="payment_table">
                <?php $this->load->view("contract_module/contract_v/display/payment/payment_table"); ?>
            </div>
            <div id="add_payment_modal">
                <?php $this->load->view("contract_module/contract_v/display/payment/add_payment_modal"); ?>
            </div>
            <div id="edit_payment_modal">
                <?php $this->load->view("contract_module/contract_v/display/payment/edit_payment_modal_form"); ?>
            </div>
        </div>
    </div>
</div>
