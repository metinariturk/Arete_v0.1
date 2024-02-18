<div class="fade tab-pane <?php if ($active_tab == "puantaj") {
    echo "active show";
} ?>"
     id="puntaj" role="tabpanel"
     aria-labelledby="workgroup-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Puantaj</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("puntaj/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Personel Girişi
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/puantaj"); ?>


            <div class="personel_list">
                <form id="puantaj_form"
                      action="<?php echo base_url("$this->Module_Name/update_puantaj/$item->id"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/puantaj_liste"); ?>
                </form>
            </div>
        </div>
    </div>
</div>
