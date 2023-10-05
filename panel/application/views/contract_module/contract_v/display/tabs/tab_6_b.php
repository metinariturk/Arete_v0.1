<div class="fade tab-pane <?php if ($active_tab == "price") {
    echo "active show";
} ?>" id="price" role="tabpanel"
     aria-labelledby="payment-tab">
    <div class="card mb-0">
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/price"); ?>
        </div>
    </div>
</div>

