<div class="container-fluid">
    <div class="row product-page-main p-0">
        <div class="col-xl-3 xl-cs-65 box-col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="main-list">
                        <?php $active_boqs = json_decode($contract->active_boq, true); ?>
                        <?php $mainCounter = 1; ?>
                        <?php foreach ($active_boqs as $boq_group => $boqs) { ?>
                            <li class="boq-group">
                                <a href="#"
                                   class="boq-link"><?php echo $mainCounter . ". " . boq_name($boq_group); ?></a>
                                <ul class="sub-list">
                                    <?php $subCounter = 'a'; ?>
                                    <?php foreach ($boqs as $boq_id) { ?>
                                        <a onclick="renderCalculate(this)"
                                           class="btn me-3" href="#"
                                           data-bs-original-title=""
                                           title=""
                                           url="<?php echo base_url("$this->Module_Name/calculate_render/$contract->id/$payment_no/$boq_id"); ?>">
                                            <?php echo boq_name($boq_id); ?>
                                        </a>
                                        <?php $subCounter++; ?>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php $mainCounter++; ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-9 xl-100 box-col-8">
            <div class="dynamic">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/calculate"); ?>
            </div>
        </div>
    </div>
</div>


