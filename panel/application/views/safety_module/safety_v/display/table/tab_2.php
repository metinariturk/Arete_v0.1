<div class="row">
    <div class="col-md-7">
        <div class="widget bg-color-op-grey">
            <header class="widget-header">
                <h4 class="widget-title pull-left">Günlük Puantaj</h4>
                <h4 class="pull-right text-success">
                    <a href="<?php echo base_url("score/update_form/$item->id"); ?>"
                       target=”_blank”>
                        <i class="far fa-plus-square fa-xl"></i>
                    </a>
                </h4>
            </header><!-- .widget-header -->
            <hr class="widget-separator">
            <div class="widget-body clearfix">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped tablecenter"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>Puantaj Tablosu</th>
                        <th>Çalışan Sayısı</th>
                        <th>Toplam Puantaj</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($scores as $score) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("score/update_form/$item->id/$score->month"); ?>"
                                   target=”_blank”>
                                    <?php $ay = date_parse_from_format('m-Y', $score->month)['month']; ?>
                                    <?php echo ay_isimleri($ay); ?>
                                </a>
                            </td>
                            <td>
                                <?php $score_array = json_decode($score->score, true) ; ?>
                                <?php echo count($score_array) ; ?>
                            </td>
                            <td>
                                <?php $score_array = json_decode($score->score, true) ; ?>
                                <?php
                                $i = 0;
                                foreach ($score_array as $score_worker){ ?>
                                       <?php $i = $i + count($score_worker); ?>
                                <?php } ?>
                                <?php echo $i ; ?>
                            </td>
                            <td>
                                <a class="btn btn-info pager-btn" href="<?php echo base_url("score/file_form/$score->id"); ?>" <span=""><i class="fas fa-ellipsis-h" aria-hidden="true"></i>
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




