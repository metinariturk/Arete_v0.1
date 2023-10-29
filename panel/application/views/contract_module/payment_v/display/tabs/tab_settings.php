<div class="fade tab-pane <?php if ($active_tab == "settings") {
    echo "active show";
} ?>"
     id="settings" role="tabpanel"
     aria-labelledby="settings-tab">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/settings_content"); ?>
</div>


