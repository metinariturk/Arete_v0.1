<div class="fade tab-pane <?php if ($active_tab == "report") {
    echo "active show";
} ?>" id="report" role="tabpanel" class="print"
     aria-labelledby="report-tab">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/graphs/header"); ?>

    <?php $modules = array("general", "cost", "condition", "offer_report", "explain"); ?>
    <?php foreach ($modules as $module) { ?>
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/graphs/$module"); ?>
        </div>
        <?php if ($module != "explain" and $module != "catalog_report") { ?>
            <div class="col-12 text-center">
                <button class="btn btn-pill btn-outline-info btn-xs d-print-none"
                        onclick="myFunction(this)"
                        data-id="<?php echo $module; ?>"
                >Sayfayı Ayır
                </button>
            </div>
            <div class="col-12" id="<?php echo $module; ?>" style="display: none; page-break-after: always;">
                <div class="d-print-none horizontal-line"></div>
            </div>
        <?php } ?>
    <?php } ?>

    <div class="row d-print-none d-flex">
        <input class="btn btn-gradient" type="button" onclick="printDiv('report')" value="Raporu Yazdır"/>
    </div>
</div>
