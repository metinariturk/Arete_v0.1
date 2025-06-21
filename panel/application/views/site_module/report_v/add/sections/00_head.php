<div class="row g-3 align-items-start">
    <div class="col-md-6 col-lg-5">
        <div class="info-sections">
            <?php
            // Proje Bilgisi
            if ($project) {
                $project_status_text = '';
                $project_status_class = '';
                if ($project->isActive == 1) {
                    $project_status_text = 'Devam Ediyor';
                    $project_status_class = 'bg-warning';
                } elseif ($project->isActive == 2) {
                    $project_status_text = 'Tamamlandı';
                    $project_status_class = 'bg-success';
                }
                ?>
                <div class="mb-2">
                    <a href="<?php echo base_url('project/file_form/' . $project->id); ?>"
                       class="info-link">
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.9em;">Proje
                            Adı:</small>
                        <strong class="d-flex align-items-center">
                            <span class="badge bg-info text-dark me-2"><?php echo mb_strtoupper($project->dosya_no); ?></span>
                            <span><?php echo $project->project_name; ?></span>
                            <?php if ($project_status_text) : ?>
                                <span class='badge <?php echo $project_status_class; ?> ms-2'><?php echo $project_status_text; ?></span>
                            <?php endif; ?>
                        </strong>
                    </a>
                </div>
                <?php
            }

            // Sözleşme Bilgisi
            if ($contract) {
                $contract_status_text = '';
                $contract_status_class = '';
                if ($contract->isActive == 1) {
                    $contract_status_text = 'Devam Ediyor';
                    $contract_status_class = 'bg-warning';
                } elseif ($contract->isActive == 2) {
                    $contract_status_text = 'Tamamlandı';
                    $contract_status_class = 'bg-success';
                }
                ?>
                <div class="mb-2">
                    <a href="<?php echo base_url('contract/file_form/' . $contract->id); ?>"
                       class="info-link">
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.9em;">Sözleşme
                            Adı:</small>
                        <strong class="d-flex align-items-center">
                            <span class="badge bg-primary text-white me-2"><?php echo mb_strtoupper($contract->dosya_no); ?></span>
                            <span><?php echo $contract->contract_name; ?></span>
                            <?php if ($contract_status_text) : ?>
                                <span class='badge <?php echo $contract_status_class; ?> ms-2'><?php echo $contract_status_text; ?></span>
                            <?php endif; ?>
                        </strong>
                    </a>
                </div>
                <?php
            }

            // Şantiye Bilgisi
            if ($site) {
                ?>
                <div>
                    <a href="<?php echo base_url('site/file_form/' . $site->id); ?>" class="info-link">
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.9em;">Şantiye
                            Adı:</small>
                        <strong class="d-flex align-items-center">
                            <span class="badge bg-dark text-white me-2"><?php echo mb_strtoupper($site->dosya_no); ?></span>
                            <span><?php echo $site->santiye_ad; ?></span>
                        </strong>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="col-md-3 col-lg-3">
        <div class="mb-2">
            <div class="col-form-label">Rapor Tarihi</div>
            <input class="flatpickr form-control <?php echo form_error("report_date") ? "is-invalid" : ""; ?>"
                   type="text" id="reportDatePicker" name="report_date"
                   value="<?php
                   // Eğer $report_date dolu ve geçerliyse onu kullan (örneğin "2025-06-12" formatında)
                   if (isset($report_date) && !empty($report_date)) {
                       echo htmlspecialchars($report_date);
                   } else {
                       // Aksi takdirde, form validasyondan gelen değeri kullan
                       echo set_value("report_date");
                   }
                   ?>">
            <?php if (form_error("report_date")) { ?>
                <div class="invalid-feedback"><?php echo form_error("report_date"); ?></div>
            <?php } ?>
        </div>
    </div>

    <div class="col-md-3 col-lg-4 d-flex justify-content-end align-items-start">
        <div class="d-flex align-items-center">
            <span class="mb-0 me-2">Çalışma Yok</span>
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="off_days" id="off_days" value="1"
                       checked>
            </div>
            <span class="mb-0 ms-2">Çalışma Var</span>
        </div>
    </div>
</div>
