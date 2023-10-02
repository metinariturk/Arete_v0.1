<div class="fade tab-pane <?php if ($active_tab == "workgroup") {
    echo "active show";
} ?>"
     id="workgroup" role="tabpanel"
     aria-labelledby="workgroup-tab">
        <div class="refresh_list">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/display/modules/workgroup"); ?>
        </div>
</div>
