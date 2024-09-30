<div class="row">
    <div class="col-12 col-md-6"> <!-- Orta ve büyük ekranlarda 6, küçük ekranlarda 12 -->
        <div class="text-center">
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <h5>Rapor Listesi</h5>
                </div>
            </div>
            <hr>

            <table id="report_table">
                <thead>
                <tr>
                    <th>Rapor Gün</th>
                    <th>Çalışan/Makine Sayı</th>
                    <th>İndir</th>
                    <th>Gör</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($reports)) { ?>
                    <?php foreach ($reports

                                   as $report) { ?>
                        <tr id="center_row">
                            <td>
                                <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                    <?php echo dateFormat_dmy($report->report_date); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                    <i class="fa fa-hard-hat"></i>
                                    <?php echo $this->Report_workgroup_model->sum_all(array("report_id" => $report->id), "number"); ?>
                                    /
                                    <?php echo $this->Report_workmachine_model->sum_all(array("report_id" => $report->id), "number"); ?>
                                    <i class="fas fa-snowplow"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("report/print_report/$report->id/1/1"); ?>"
                                   class="btn-download">
                                    <i class="fa fa-download"></i>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" href="<?php echo base_url("report/print_report/$report->id/1/0"); ?>"
                                   class="btn-display">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 col-md-6"> <!-- Orta ve büyük ekranlarda 6, küçük ekranlarda 12 -->
        <div class="container">
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <h5>Çalışma Özeti</h5>
                </div>
            </div>
            <hr>

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
                <?php foreach ($all_workmachines as $submachine) { ?>
                    <a href="#"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars(machine_name($submachine['workmachine'])); ?>
                        <span class="badge bg-primary rounded-pill">
                            <?php echo sum_anything_and("report_workmachine", "number", "site_id", $item->id, "workmachine", $submachine['workmachine']); ?>
                        </span>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
