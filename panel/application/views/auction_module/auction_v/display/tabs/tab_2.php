<div class="fade tab-pane" id="teknik" role="tabpanel"
     aria-labelledby="teknik-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Teknik Dökümanlar</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("aucdraw/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
                        Teknik Doküman Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/aucdraw"); ?>
        </div>
    </div>
</div>
