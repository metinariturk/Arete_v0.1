<div class="fade tab-pane <?php if ($active_tab == "bond") {
    echo "active show";
} ?>"
     id="teminat" role="tabpanel"
     aria-labelledby="bond-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Teminatlar</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("bond/new_form_contract/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Sözleşme Teminatı Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/bond"); ?>
        </div>
    </div>
</div>
