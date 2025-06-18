<div class="row align-items-center mb-4">
    <div class="col-md-6 text-center">
        <div class="weather-display card mb-3 shadow-sm mx-auto" style="max-width: 350px;">
            <div class="card-body p-3">
                <?php if (!empty($weather) && is_object($weather)) { ?>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0 text-muted">
                            <?php echo $weather->location; ?> Hava Durumu
                        </h6>
                        <span class="badge bg-info text-white fs-6 py-2 px-3">
                                            <?php echo date('d.m.Y', strtotime($weather->date)); ?>
                                        </span>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="me-3 fs-3 d-flex align-items-center">
                            <?php echo get_weather_icon($weather->event); ?>
                        </div>
                        <p class="mb-0 fs-5 fw-bold me-3 text-muted">
                            <?php echo $weather->event; ?>
                        </p>
                        <p class="mb-0 text-muted ms-auto">
                            <span class="text-danger fw-bold"><?php echo $weather->max; ?>°C</span>
                            /
                            <span class="text-primary"><?php echo $weather->min; ?>°C</span>
                        </p>
                    </div>
                <?php } else { ?>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0 text-muted">
                            Hava durumu bilgisi bulunamadı.
                        </h6>
                        <span class="badge bg-info text-white fs-6 py-2 px-3">
                                           <?php echo dateFormat_dmy($item->report_date); ?>
                                        </span>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="me-3 fs-3 d-flex align-items-center">
                        </div>
                        <p class="mb-0 fs-5 fw-bold me-3 text-muted">
                        </p>
                        <p class="mb-0 text-muted ms-auto">
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-3">
            <span class="fw-bold text-muted fs-6">Oluşturan:</span>
            <span class="text-muted ms-2 fs-6"><?php echo full_name($item->createdBy); ?></span>
        </div>
    </div>
</div>

<hr class="my-4">
<div class="row">
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/workgroup"); ?>
    </div>
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/workmachine"); ?>
    </div>
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/supplies"); ?>
    </div>
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/foot"); ?> </div>
</div>

<div class="row mt-4">
    <div class="col-xl-6 col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body p-4 text-center">
                <p class="card-text text-muted mb-3">Raporunuzu PDF olarak hazırlayıp yazdırmak veya
                    indirmek için aşağıdaki butonu kullanın.</p>
                <a href="<?php echo base_url("report/print_report/$item->id/1"); ?>"
                   class="btn btn-success w-75 rounded-pill py-2" target="_blank">
                    <span class="me-2">&#x1F5B6;</span> Yazdır
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <?php $this->load->view("site_module/report_v/common/add_document"); ?>
    </div>
</div>