<div class="fade tab-pane" id="tesvik" role="tabpanel"
     aria-labelledby="tesvik-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Teşvik / Hibe </h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                   href="<?php echo base_url("incentive/new_form/$item->id"); ?>" target="_blank">
                    <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Teşvik / Hibe Ekle
                </a>

            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/incentive"); ?>
        </div>
    </div>
</div>

