<div class="fade tab-pane <?php if ($active_tab == "sitewallet") {
    echo "active show";
} ?>"
     id="sitewallet" role="tabpanel"
     aria-labelledby="workgroup-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Cüzdan Hareketleri</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("sitewallet/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Harcama Girişi
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/sitewallet"); ?>
        </div>
    </div>
</div>
