<div class="fade tab-pane <?php if ($active_tab == "offer") {
    echo "active show";
} ?>"
     id="offer" role="tabpanel"
     aria-labelledby="offer-tab">
    <div class="card mb-0">
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/drawings"); ?>
        </div>
    </div>
</div>
