<div class="fade tab-pane <?php if ($active_tab == "offers"){echo "active show"; } ?>" id="offers" role="tabpanel"
     aria-labelledby="offers-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Teklifler</h6>
            <ul>
                <?php if (!isset($teklifler)) { ?>
                    <a class="pager-btn btn btn-success btn-outline"
                       href="<?php echo base_url("offer/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Teklif Formu Ekle
                    </a>
                <?php } else { ?>
                    <a class="btn btn-pill btn-success btn-air-success btn-lg"
                       href="<?php echo base_url("offer/file_form/$teklifler->id"); ?>" target="_blank">
                      Teklif Detayları
                    </a>
                <?php } ?>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/offer"); ?>
        </div>
    </div>
</div>
