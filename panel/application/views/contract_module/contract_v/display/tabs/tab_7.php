<div class="fade tab-pane <?php if ($active_tab == "newprice") {
    echo "active show";
} ?>" id="newprice" role="tabpanel"
     aria-labelledby="newprice-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Yeni Birim Fiyat</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                   href="<?php echo base_url("newprice/new_form/$item->id"); ?>" target="_blank">
                    <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Birim Fiyat Ekle
                </a>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/newprice"); ?>
        </div>
    </div>
</div>

