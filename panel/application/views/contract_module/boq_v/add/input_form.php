<div class="container-fluid">
    <div class="row product-page-main p-0">
        <div class="col-xl-4 xl-cs-65 box-col-12">
            <div class="card">
                <div class="card-body">
                    <div class="renderGroup">
                        <?php $this->load->view("contract_module/boq_v/add/renderList"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 xl-100 box-col-8">
            <div class="dynamic">
                <?php if (!empty($payment->A)) { ?>
                    <?php $this->load->view("contract_module/boq_v/add/show_calculate"); ?>
                <?php } else { ?>
                    <?php $this->load->view("contract_module/boq_v/add/calculate"); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


