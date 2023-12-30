<div class="col-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
                <th>Rapor Gün</th>
                <th>Çalışan Sayı</th>
                <th class="d-none d-sm-table-cell">Mekine Sayı</th>
                <th class="d-none d-sm-table-cell">Görsel</th>
                <th class="d-none d-sm-table-cell">Oluşturan</th>
                <th>İşlem</th>
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
                            <?php if (!empty($report->id)) {
                                $report_files = get_module_files("report_files", "report_id", "$report->id");
                                if (!empty($report_files)) { ?>
                                    (<?php echo count($report_files); ?>)
                                <?php } ?>
                            <?php } ?>

                        </td>
                        <td class="d-none d-sm-table-cell">
                            <?php echo full_name($report->createdBy); ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-pill" role="group"
                                 aria-label="Basic example">
                                <a href="<?php echo base_url("report/print_report/$report->id/1/1"); ?>"
                                   class="btn btn-outline-success">

                                    <i class="fa fa-download"></i>
                                </a>
                                <a href="<?php echo base_url("report/print_report/$report->id/1/0"); ?>"
                                   class="btn btn-outline-success">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>









