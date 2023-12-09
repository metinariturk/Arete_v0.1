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
                                    <?php echo site_code_name($site->id); ?>
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
                    <div class="image_list_container">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="card">
            <div class="content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p style="text-align:center; font-size:14pt;">
                                <strong><?php echo $project->proje_ad; ?></strong>
                            </p>
                        </div>
                        <div class="col-12">
                            <p style="text-align:center; font-size:14pt;">
                                <strong>Günlük Rapor</strong>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <?php if (isset($weather)){ ?>
                                <p style="text-align:left; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                    <strong>Hava Durumu</strong>
                                </p>
                                <p style="text-align:left; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                    <strong>Max : <?php echo $weather->max; ?>°C</strong>
                                    | <strong>Min : <?php echo $weather->min; ?>°C</strong>
                                    | <strong>Olay : <?php echo $weather->event; ?></strong>
                                </p>
                            <?php } ?>
                            <p style="text-align:left; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                <strong><?php echo ($item->off_days == 1) ? 'Çalışma Yok' : ''; ?></strong>
                            </p>
                        </div>
                        <div class="col-6">
                        </div>
                        <div class="col-2">
                            <p style="text-align:right; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                <strong>Tarih : <?php echo dateFormat_dmy($item->report_date); ?></strong>
                            </p>
                        </div>
                    </div>
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
                                    <label class="form-check-label" for="radio55">Fotoğraf İle Birlikte (Max 4)</label>
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
