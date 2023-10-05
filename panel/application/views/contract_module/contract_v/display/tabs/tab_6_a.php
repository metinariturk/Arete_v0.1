<div class="fade tab-pane <?php if ($active_tab == "boq") {
    echo "active show";
} ?>" id="payment" role="tabpanel"
     aria-labelledby="payment-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Hakediş</h6>
            <ul>


                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("payment/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Hakediş
                    </a>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("contract/update_payment_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-edit" aria-hidden="true"></i>Hakediş Ayarları
                    </a>
                </li>

            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/payment"); ?>
        </div>
    </div>
</div>

