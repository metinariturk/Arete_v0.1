<div class="fade tab-pane <?php if ($active_tab == "report") {
    echo "active show";
} ?>" id="report" role="tabpanel" class="print"
     aria-labelledby="report-tab">
    <div class="row d-print-none d-flex">
        <a target="_blank" href="<?php echo base_url("contract/print_report/$item->id/0"); ?>" class="btn btn-gradient" type="button" ><i class="fa fa-file-pdf-o"></i> PDF Çıktı</a>
    </div>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/graphs/header"); ?>
    <?php $modules = array("time", "finance", "payments", "progress_payments", "advance", "bond"); ?>
    <?php foreach ($modules as $module) { ?>
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/graphs/$module"); ?>
        </div>
    <?php } ?>
    <div class="row d-print-none d-flex">
        <a target="_blank" href="<?php echo base_url("contract/print_report/$item->id/0"); ?>" class="btn btn-gradient" type="button" ><i class="fa fa-file-pdf-o"></i> PDF Çıktı</a>
    </div>
</div>
