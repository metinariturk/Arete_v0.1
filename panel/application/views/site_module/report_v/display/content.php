<div class="row">

    <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="file-sidebar">
                    <ul>
                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("project/file_form/$project->id"); ?>">
                                    <i data-feather="home"></i>
                                    <?php echo project_code_name($project->id); ?>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="btn btn-light">
                                <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i data-feather="home"></i>
                                    <?php echo $site->dosya_no." ".$site->santiye_ad; ?>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="btn btn-light">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        <?php echo $item->dosya_no; ?> / <?php echo module_name($this->Module_Name); ?>
                                    </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="file-content">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="card">
            <div class="content">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php if ($previous_report !== null): ?>
                                            <a href="<?php echo base_url("report/file_form/$previous_report->id"); ?>"
                                               class="btn btn-pill btn-block btn-outline-primary btn-sm" type="button"
                                               title="Önceki Rapor">
                                                <i class="fa fa-arrow-left"></i> <?php echo dateFormat_dmy($previous_report->report_date); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h5>
                                            <strong><?php echo dateFormat_dmy($item->report_date); ?></strong>
                                        </h5>
                                        <h4><?php echo $project->project_name; ?></h4>
                                        <strong><h5>Günlük Rapor</h5></strong>
                                    </div>


                                    <div class="col-md-3" style="text-align: right">
                                        <?php if ($next_report !== null) { ?>
                                            <a href="<?php echo base_url("report/file_form/$next_report->id"); ?>"
                                               class="btn btn-pill btn-block btn-outline-primary btn-sm" type="button"
                                               title="Sonraki Rapor">
                                                <?php echo dateFormat_dmy($next_report->report_date); ?> <i
                                                        class="fa fa-arrow-right"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url("report/new_form/$item->site_id"); ?>"
                                               class="btn btn-pill btn-block btn-outline-primary btn-sm" type="button"
                                               title="Yeni Rapor">
                                                Yeni Rapor Oluştur <i
                                                        class="fa fa-plus-circle"></i>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php if (isset($weather)) { ?>
                                            <p style="text-align:left; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                                <strong>Max : <?php echo $weather->max; ?>°C</strong>
                                                | <strong>Min : <?php echo $weather->min; ?>°C</strong>
                                                | <strong>Olay : <?php echo $weather->event; ?></strong>
                                            </p>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Oluşturan : <?php echo full_name($item->createdBy); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>

                        <?php $this->load->view("{$viewModule}/{$viewFolder}/display/modules/workgroup"); ?>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/display/modules/workmachine"); ?>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/display/modules/supplies"); ?>
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/display/modules/foot"); ?>

                        <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                            <div class="h-100 checkbox-checked">
                                <h6 class="sub-title">Çıktı Al</h6>
                                <div style="height: 100px;">
                                    <div class="form-check radio radio-success">
                                        <input class="form-check-input" id="radio22"
                                               data-url="<?php echo base_url("report/print_report/$item->id/0"); ?>"
                                               type="radio" name="calculate" value="option1" checked="">
                                        <label class="form-check-label" for="radio22">Sadece Rapor</label>
                                    </div>
                                    <div class="form-check radio radio-success">
                                        <input class="form-check-input" id="radio55"
                                               data-url="<?php echo base_url("report/print_report/$item->id/1"); ?>"
                                               type="radio" name="calculate" value="option1">
                                        <label class="form-check-label" for="radio55">Fotoğraf İle Birlikte (Max
                                            4)</label>
                                    </div>
                                </div>
                                <div class="form-check radio radio-success">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <div class="btn-group btn-group-pill" role="group"
                                                 aria-label="Basic example">
                                                <button class="btn btn-outline-success" name="calculate"
                                                        onclick="handleButtonClick(1)" type="button"><i
                                                            class="fa fa-download"></i>
                                                    İndir
                                                </button>
                                                <button class="btn btn-outline-success" name="calculate"
                                                        onclick="handleButtonClick(0)" type="button"><i
                                                            class="fa fa-file-pdf-o"></i>Önizle
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
