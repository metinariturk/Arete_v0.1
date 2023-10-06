<div class="fade tab-pane <?php if ($active_tab == "price") {
    echo "active show";
} ?>" id="price" role="tabpanel"
     aria-labelledby="payment-tab">
    <div class="card mb-0">
        <div class="card-body">
            <?php if (!empty($item->price)) { ?>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/price"); ?>
            <?php } else { ?>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/price_update"); ?>
            <?php } ?>
        </div>
    </div>
</div>

