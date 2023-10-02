<div class="fade tab-pane <?php if ($active_tab == "workmachine") {
    echo "active show";
} ?>"
     id="workmachine" role="tabpanel"
     aria-labelledby="workmachine-tab">
        <div class="refresh_list_machine">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/display/modules/workmachine"); ?>
        </div>
</div>
