<div class="fade tab-pane <?php if ($active_tab == "cost") {
    echo "active show";
} ?>" id="yaklasik-maliyet" role="tabpanel" class="print"
     aria-labelledby="yaklasik-maliyet-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Yaklaşık Maliyet</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("cost/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
                        Yaklaşık Maliyet Grubu Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/cost"); ?>
        </div>
    </div>
</div>
