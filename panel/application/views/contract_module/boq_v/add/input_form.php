<div class="container-fluid">
    <div class="row product-page-main p-0">
        <div class="col-xl-5 xl-cs-65 box-col-12">
            <div class="card">
                <div class="card-body">
                    <div class="renderGroup">
                        <table>
                            <thead>
                            <tr>
                                <th>Grup Adı</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $active_boqs = json_decode($contract->active_boq, true); ?>

                            <?php foreach ($active_boqs as $boq_group => $boqs) { ?>
                                <tr>
                                    <td colspan="3">
                                        <a onclick="renderGroup(this)"
                                           class="btn btn-primary me-3" href="#" style="width: 250px;"
                                           data-bs-original-title=""
                                           title=""
                                           url="<?php echo base_url("$this->Module_Name/select_group/$contract->id/$payment_no/$boq_group"); ?>">
                                            <span style="text-align: left"><?php echo boq_name($boq_group); ?></span>
                                        </a>
                                    </td>
                                </tr>


                            <?php } ?>
                            </tbody>
                        </table>
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


