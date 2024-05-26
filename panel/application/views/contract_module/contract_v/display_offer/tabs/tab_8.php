<div class="fade tab-pane <?php if ($active_tab == "costinc") {
    echo "active show";
} ?>" id="costinc" role="tabpanel"
     aria-labelledby="costinc-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Keşif Artışları</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("Costinc/new_form_contract/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Keşif Artışı Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/costinc"); ?>
        </div>
    </div>
</div>