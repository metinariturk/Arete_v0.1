<div class="card">
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <h3 class="text-center">
                Aktif Poz Kitapları
            </h3>
        </div>
        <div class="row">
            <div class="col-3">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/common/books"); ?>
            </div>
            <div class="col-4">
                <div class="refresh_list">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/list"); ?>
                </div>
            </div>
            <div class="col-5">
                <div class="refresh_poz">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/poz"); ?>
                </div>
            </div>
            <div class="col-12">
                <div class="refresh_explain">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/explain"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

