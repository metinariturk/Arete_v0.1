<div class="fade tab-pane <?php if ($active_tab == "extime"){echo "active show"; } ?>" id="extime" role="tabpanel"
     aria-labelledby="extime-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Süre Uzatımı</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("Extime/new_form_contract/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Süre Uzatımı
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/extime"); ?>
        </div>
    </div>
</div>

