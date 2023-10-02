<div class="fade tab-pane" id="metraj" role="tabpanel"
     aria-labelledby="metraj-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Metrajlar</h6>
            <ul>
                <li>

                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("compute/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Metraj Grubu Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/compute"); ?>
        </div>
    </div>
</div>
