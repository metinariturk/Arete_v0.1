<div class="fade tab-pane  <?php if ($active_tab == "catalog"){echo "active show"; } ?>" id="catalog" role="tabpanel"
     aria-labelledby="catalog-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Katalog</h6>
            <ul>

            </ul>
        </div>
        <div class="card-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/catalog"); ?>
        </div>
    </div>
</div>
