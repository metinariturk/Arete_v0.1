<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Şantiye Günlük Raporları</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid basic_table">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col">#</th>
                                <th scope="col">Görüntülenebilir İçerik</th>
                                <th class="d-none d-sm-table-cell" scope="col" style="text-align: center">Şantiye Adı</th>
                                <th scope="col" style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sites as $site) { ?>
                                <?php $reports = $this->Report_model->get_all(array("site_id" => $site->id), "report_date DESC"); ?>
                                <?php $i = 1; ?>
                                <?php foreach ($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo tarihFormatla($report->report_date); ?></td>
                                        <td class="d-none d-sm-table-cell" style="text-align: center"><?php echo $site->santiye_ad; ?></td>
                                        <td style="text-align: center">
                                            <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                                <a href="<?php echo base_url("guest/print_report/$report->id/1/1"); ?>"
                                                   class="btn btn-outline-success">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <a href="<?php echo base_url("guest/print_report/$report->id/1/0"); ?>"
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
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
