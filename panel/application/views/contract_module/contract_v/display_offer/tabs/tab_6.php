<div class="fade tab-pane <?php if ($active_tab == "payment") {
    echo "active show";
} ?>"
     id="payment" role="tabpanel"
     aria-labelledby="payment-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6>Hakediş</h6>
            <ul>
                <li>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <a class="btn btn-primary"
                                   href="<?php echo base_url("payment/create/$item->id"); ?>"
                                        type="button">
                                    <i class="menu-icon fa fa-plus fa-lg"></i>
                                    Yaklaşık Maliyet/Metraj
                                </a>
                            </div>
                        </div>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/payment"); ?>
        </div>
    </div>
</div>