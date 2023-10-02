<div class="row">
    <div class="col-md-3">
        <div class="widget bg-color-op-green">
            <header class="widget-header">
                <h4 class="widget-title pull-left">Genel Durum</h4>
            </header><!-- .widget-header -->
            <div class="widget-body clearfix">
                <div class="pull-left">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>Ekip Adı</th>
                            <th>Toplam Yevmiye</th>
                        </tr>
                        <?php $all_workgroups = get_from_any_array("workgroup", "sub_category", "1"); ?>
                        <?php $array_counter = array(); ?>
                        <?php $k = 0; ?>
                        <?php foreach ($all_workgroups as $all_workgroup) { ?>
                            <?php $i = 0; ?>

                            <?php foreach ($reports as $report) { ?>
                                <?php $report_workgroups = json_decode($report->workgroup); ?>
                                <?php foreach ($report_workgroups as $report_workgroup) { ?>
                                    <?php if ($report_workgroup->workgroup == $all_workgroup->id) { ?>
                                        <?php $report_workgroup->worker_count; ?>
                                        <?php $i = $i + $report_workgroup->worker_count; ?>
                                        <?php group_name($all_workgroup->id); ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($i > 0) { ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo $k = $k + 1; ?>
                                    </td>

                                    <td> <?php echo group_name($all_workgroup->id); ?></td>
                                    <td>
                                        <?php echo $i; ?>
                                        <?php $array_counter[] = $i; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-center" colspan="2">
                                <strong>TOPLAM</strong>
                            </td>
                            <td>
                                <strong><?php echo array_sum($array_counter); ?></strong>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- .widget-body -->
            <hr class="widget-separator">
        </div><!-- .widget -->
    </div><!-- Durum -->
    <div class="col-md-2">
        <div class="col-md-12">
            <div class="widget bg-color-op-blue">
                <header class="widget-header">
                    <h4 class="widget-title pull-left">İş Grupları</h4>
                    <small class="pull-right text-muted"> <a
                                href="<?php echo base_url("Workgroup/select/$item->id"); ?>"
                                target=”_blank”>
                            <i class="far fa-edit"></i>
                        </a></small>
                </header><!-- .widget-header -->
                <hr class="widget-separator">
                <div class="widget-body clearfix">
                    <div class="pull-left">

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>#</th>
                                <th>Ekip Adı</th>
                            </tr>

                            <?php $list_group = json_decode($item->active_group); ?>
                            <?php if (!empty($list_group)) { ?>
                                <?php $i = 1; ?>
                                <?php foreach ($list_group as $list) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo group_name($list); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- .widget-body -->
            </div><!-- .widget -->
        </div><!-- END cloumn -->
        <div class="col-md-12">
            <div class="widget bg-color-op-purple">
                <header class="widget-header">
                    <h4 class="widget-title pull-left">İş Makineleri</h4>
                    <small class="pull-right text-muted"> <a
                                href="<?php echo base_url("Workmachine/select/$item->id"); ?>"
                                target=”_blank”>
                            <i class="far fa-edit"></i>
                        </a></small>
                </header><!-- .widget-header -->
                <hr class="widget-separator">
                <div class="widget-body clearfix">
                    <div class="pull-left">

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>#</th>
                                <th>Makine Adı</th>
                            </tr>

                            <?php $list_group = json_decode($item->active_machine); ?>
                            <?php if (!empty($list_group)) { ?>
                                <?php $i = 1; ?>
                                <?php foreach ($list_group as $list) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo machine_name($list); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div><!-- .widget-body -->
            </div><!-- .widget -->
        </div><!-- END cloumn -->
    </div>
    <div class="col-md-7">
        <div class="widget bg-color-op-grey">
            <header class="widget-header">
                <h4 class="widget-title pull-left">Günlük Puantaj</h4>
                <h4 class="pull-right text-success"><a
                            href="<?php echo base_url("report/new_form/$item->id"); ?>"
                            target=”_blank”>
                        <i class="far fa-plus-square"></i>
                    </a></h4>
            </header><!-- .widget-header -->
            <hr class="widget-separator">
            <div class="widget-body clearfix">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped tablecenter"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rapor Tarihi</th>
                        <th>Çalışan Sayısı</th>
                        <th>Makine Sayısı</th>
                        <th>Hava Durumu</th>
                        <th>Oluşturan</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reports as $report) { ?>
                        <?php $workgroups = json_decode($report->workgroup); ?>
                        <?php $weathers = json_decode($report->weather); ?>
                        <?php $workmachines = json_decode($report->workmachine); ?>
                        <tr>
                            <td><?php echo $report->id; ?></td>
                            <td><?php echo $report->report_date; ?></td>
                            <td><span data-tooltip-location="top"
                                      data-tooltip="<?php foreach ($workgroups as $workgroup) { ?><?php echo group_name($workgroup->workgroup); ?>(<?php echo $workgroup->worker_count; ?>) -<?php } ?>">

                            <?php echo $sum = array_sum(array_column($workgroups, "worker_count")); ?>
                        </span>
                            </td>
                            <td>
                                <?php echo $sum = array_sum(array_column($workmachines, "machine_count")); ?>
                            </td>
                            <td>
                                <i class="fa-sharp fa-solid fa-temperature-arrow-down"></i> <?php echo $weathers->min_temp; ?>
                                °
                                |
                                <i class="fa-sharp fa-solid fa-temperature-arrow-up"></i> <?php echo $weathers->max_temp; ?>
                                ° |
                                <span data-tooltip-location="top"
                                      data-tooltip="<?php echo $weathers->event; ?>"><?php echo weather($weathers->event); ?></span>
                            </td>
                            <td><?php echo $report->createdBy; ?>Ahmet PEKMEZCİ</td>
                            <td class="text-center"><a class="btn btn-info pager-btn"
                                                       href="<?php echo base_url("report/file_form/$report->id"); ?>"
                                <span class="m-r-xs"><i class="fas fa-ellipsis-h"></i></span>
                                <span>Görüntüle</span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div>
</div><!-- .row -->




