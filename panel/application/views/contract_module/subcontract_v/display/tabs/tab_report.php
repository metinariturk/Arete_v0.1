<div class="fade tab-pane <?php if ($active_tab == "report") {
    echo "active show";
} ?>" id="report" role="tabpanel" class="print"
     aria-labelledby="report-tab">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/graphs/header"); ?>
    <?php $modules = array("time", "finance", "payments", "progress_payments", "advance", "bond", "explain","catalog_report"); ?>
    <?php foreach ($modules as $module) { ?>
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/graphs/$module"); ?>
        </div>
    <?php } ?>
    <div class="row d-print-none d-flex">
        <input class="btn btn-gradient" type="button" onclick="printDiv('report')" value="Raporu Yazdır"/>
    </div>
</div>
