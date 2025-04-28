<div class="card">
    <div class="card-body">
        <div class="project-info">
            <?php if ($contract) { ?>
                <div class="info-header">
                    <h5 class="mb-0">
                        <?php echo mb_strtoupper($contract->dosya_no . " / " . $contract->contract_name); ?>
                        <small class="status" style="font-size: 14px;">
                            <?php
                            if ($contract->isActive == 1) {
                                echo "<span class='badge bg-warning'>Devam eden sözleşme</span>";
                            } elseif ($contract->isActive == 2) {
                                echo "<span class='badge bg-success'>Tamamlanan sözleşme</span>";
                            }
                            ?>
                        </small>
                    </h5>
                </div>
            <?php } elseif ($project) { ?>
                <div class="info-header">
                    <h5 class="mb-0">
                        <?php echo mb_strtoupper($project->dosya_no . " / " . $project->project_name); ?>
                        <small class="status" style="font-size: 14px;">
                            <?php
                            if ($project->isActive == 1) {
                                echo "<span class='badge bg-warning'>Devam eden proje</span>";
                            } elseif ($project->isActive == 2) {
                                echo "<span class='badge bg-success'>Tamamlanan proje</span>";
                            }
                            ?>
                        </small>
                    </h5>
                </div>
            <?php } ?>
            <div class="site-info">
                <span><?php echo $site->santiye_ad; ?></span>
                <span><?php echo $site->dosya_no; ?></span>
            </div>
        </div>
    </div>
</div>

<div id="formContainer">

        <?php $this->load->view("site_module/report_v/add/input_form"); ?>

</div>