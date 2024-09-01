<div class="fade tab-pane <?php if ($active_tab == "sitestock") {
    echo "active show";
} ?>"
     id="sitestock" role="tabpanel"
     aria-labelledby="workgroup-tab">
    <div class="card mb-0">
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/sitestock"); ?>
        </div>
    </div>
</div>