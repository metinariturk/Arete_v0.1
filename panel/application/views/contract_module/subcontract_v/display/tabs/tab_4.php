<div class="fade tab-pane <?php if ($active_tab == "advance") {
    echo "active show";} ?>" id="avans" role="tabpanel"  aria-labelledby="avans-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Avans Ödemesi</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("advance/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
                        Avans Ödemesi Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/advance"); ?>
        </div>
    </div>
</div>
