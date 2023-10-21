<div class="fade tab-pane <?php if ($active_tab == "works_done") {
    echo "active show";
} ?>"
     id="works_done" role="tabpanel"
     aria-labelledby="works_done-tab">

    <div class="col-sm-8 offset-sm-2">

        <div>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_sign"); ?>
        </div>
        <a class="btn btn-primary" target="_blank"
           href="<?php echo base_url("payment/print/$item->id/green"); ?>">Önizleme</a>
    </div>

</div>





