<div class="row">
    <div class="col-8">
        <div class="text-center">
            <table class="table" id="report_table">
                <thead>
                <tr>
                    <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
                    <th>Rapor Gün</th>
                    <th>Çalışan Sayı</th>
                    <th class="d-none d-sm-table-cell">Mekine Sayı</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($reports)) { ?>
                    <?php foreach ($reports as $report) { ?>
                        <tr id="center_row">
                            <td></td>

                            <td>
                                <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                    <?php
                                    $formatter = new IntlDateFormatter(
                                        'tr_TR', // Locale
                                        IntlDateFormatter::LONG, // Date format
                                        IntlDateFormatter::NONE, // Time format
                                        'Europe/Istanbul', // Timezone
                                        IntlDateFormatter::GREGORIAN, // Calendar
                                        'd MMMM yyyy EEEE' // Custom format: day month year weekday
                                    );

                                    echo $formatter->format(strtotime($report->report_date));
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
    <div class="col-4">
        <div class="container mt-5">
            <h1 class="mb-4">Raporlar Özeti</h1>
            <div class="list-group">
                <?php foreach ($all_workgroups as $subgroup) { ?>
                    <a href="#"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars(group_name($subgroup['workgroup'])); ?>
                        <span class="badge bg-primary rounded-pill">
                        <?php echo sum_anything_and("report_workgroup", "number", "site_id", $item->id, "workgroup", $subgroup['workgroup']); ?>
                    </span>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>










