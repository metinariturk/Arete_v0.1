<div class="container-fluid">
    <div class="row product-page-main p-0">
        <div class="col-xl-5 xl-cs-65 box-col-12">
            <div class="card">
                <div class="card-body">
                    <div class="renderGroup">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/renderList"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 xl-100 box-col-8">
            <div class="dynamic">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/calculate"); ?>
            </div>
        </div>
    </div>
</div>


