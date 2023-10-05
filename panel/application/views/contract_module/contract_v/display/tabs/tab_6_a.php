<div class="fade tab-pane <?php if ($active_tab == "boq") {
    echo "active show";
} ?>" id="boq" role="tabpanel"
     aria-labelledby="payment-tab">
    <div class="card mb-0">
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/boq"); ?>
        </div>
    </div>
</div>

