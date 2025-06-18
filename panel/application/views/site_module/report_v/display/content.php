<div class="row justify-content-center">
    <div class="col-lg-8 col-md-12">
        <div class="card shadow-lg mb-4">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-muted mb-1">Günlük Rapor</h3>
                    <span class="h4"><?php echo $project->project_name; ?></span>
                    <p class="text-muted lead mb-0">
                        <a href="<?php echo base_url("project/file_form/$project->id"); ?>"
                           class="text-decoration-none text-muted me-2">
                            Proje : <?php echo $project->dosya_no; ?>
                        </a>
                    </p>
                    <p class="text-muted lead mb-0">
                        <a href="<?php echo base_url("site/file_form/$site->id"); ?>"
                           class="text-decoration-none text-muted">
                            Şantiye : <?php echo $site->dosya_no; ?>
                        </a>
                    </p>
                </div>
                <div id="refresh_report">
                    <?php $this->load->view("site_module/report_v/display/modules/report_body"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="wrapper">
            <header>
                <p class="current-date"></p>
                <div class="icons">
                    <span id="prev">&#8249;</span>
                    <span id="next">&#8250;</span>
                </div>
            </header>
            <div class="calendar">
                <ul class="weeks">
                    <li>Pzt</li>
                    <li>Sal</li>
                    <li>Çar</li>
                    <li>Per</li>
                    <li>Cum</li>
                    <li>Cmt</li>
                    <li>Paz</li>
                </ul>
                <ul class="days"></ul>
            </div
        </div>
    </div>
</div>
