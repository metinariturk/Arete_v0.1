<div class="col-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
                <th>Rapor Gün</th>
                <th>Çalışan Sayı</th>
                <th class="d-none d-sm-table-cell">Mekine Sayı</th>
                <th class="d-none d-sm-table-cell">Oluşturan</th>
                <th class="d-none d-sm-table-cell">Dosyalar</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($reports)) { ?>
                <?php foreach ($reports as $report) { ?>
                    <tr id="center_row">
                        <td class="d-none d-sm-table-cell">
                            <?php echo $report->id; ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                <?php
                                echo dateFormat_dmy($report->report_date);
                                ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                <?php echo $this->Report_workgroup_model->sum_all(array("report_id" => $report->id), "number"); ?>
                            </a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                <?php echo $this->Report_workmachine_model->sum_all(array("report_id" => $report->id), "number"); ?>
                            </a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <?php if (!empty($report->createdBy)) { ?>
                                <span data-tooltip-location="top"
                                      data-tooltip="<?php echo full_name($report->createdBy); ?>">
                                            <a href="<?php echo base_url("user/file_form/$report->createdBy"); ?>">
                                                <img
                                                        class="img-50 rounded-circle" <?php echo get_avatar($report->createdBy); ?>
                                                        alt=""
                                                        data-original-title=""
                                                        title="<?php echo full_name($report->createdBy); ?>">
                                            </a>
                                            </span>
                            <?php } ?>
                            <?php echo full_name($report->createdBy); ?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <div>
                                <?php if (!empty($report->id)) {
                                    $report_files = get_module_files("report_files", "report_id", "$report->id");
                                    if (!empty($report_files)) { ?>
                                        <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                           href="<?php echo base_url("report/download_all/$report->id"); ?>"
                                           data-bs-original-title="<?php foreach ($report_files as $report_file) { ?>
                                            <?php echo filenamedisplay($report_file->img_url); ?> |
                                            <?php } ?>"
                                           data-original-title="btn btn-pill btn-info btn-air-info ">
                                            <i class="fa fa-download" aria-hidden="true"></i> Dosya
                                            (<?php echo count($report_files); ?>)
                                        </a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="div-table">
                                        <div class="div-table-row">
                                            <div class="div-table-col">
                                                Dosya Yok, Eklemek İçin Görüntüle Butonundan Şartname Sayfasına
                                                Gidiniz
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </td>
                        <td>
                            <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                <button class="btn btn-success m-r-10" type="button" title="" data-bs-original-title="">
                                    <i class="fa fa-arrow-right me-1"></i></button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>









