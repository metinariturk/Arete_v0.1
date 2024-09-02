<div class="fade tab-pane <?php if ($active_tab == "reports") {
    echo "active show";
} ?>"
     id="reports" role="tabpanel"
     aria-labelledby="report-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Günlük Raporlar</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("report/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Günlük Rapor Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/reports"); ?>
        </div>
    </div>
</div>
