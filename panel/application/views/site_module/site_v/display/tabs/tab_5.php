<div class="fade tab-pane <?php if ($active_tab == "puantaj") {
    echo "active show";
} ?>"
     id="puntaj" role="tabpanel"
     aria-labelledby="puantaj-tab">
    <div class="card mb-0">
        <div class="card-body">
            <div class="puantaj_list">
                <form id="puantaj_form"
                      action="<?php echo base_url("$this->Module_Name/update_puantaj"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/puantaj_liste"); ?>
                </form>
            </div>
        </div>
    </div>
</div>


