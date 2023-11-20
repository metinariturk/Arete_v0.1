<div class="fade tab-pane <?php if ($active_tab == "collection") {
    echo "active show";
} ?>"
     id="collection" role="tabpanel"
     aria-labelledby="collection-tab">

    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Avans Ödemesi</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("collection/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Tahsilat Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/collection"); ?>
        </div>
    </div>
</div>