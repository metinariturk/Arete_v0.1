<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <div class="weather-display card mb-3 shadow-sm me-auto" style="max-width: 350px;">
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
    </div>

    <div class="col-md-6 text-md-end">
        <div class="d-flex flex-column justify-content-center h-100">
            <div class="text-muted fs-6">
                <span class="fw-bold">Oluşturan:</span>
            </div>
            <div class="text-muted fs-6 mt-1"> <span><?php echo full_name($item->createdBy); ?></span>
            </div>
        </div>
    </div>
</div>