<div class="fade tab-pane" id="yayin" role="tabpanel"
     aria-labelledby="yayin-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">İhale İlanı</h6>
            <ul>
                <?php if (empty($ilanlar)) { ?>
                    <a class="pager-btn btn btn-success btn-outline"
                       href="<?php echo base_url("notice/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>İhale Yayınla
                    </a>
                <?php } elseif (!empty($ihale_ilan)) { ?>
                    <a class="pager-btn btn btn-success btn-outline"
                       href="<?php echo base_url("notice/new_form/$item->id/$ihale_ilan->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Zeyilname Yayınla
                    </a>
                <?php } ?>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/notice"); ?>
        </div>
    </div>
</div>

