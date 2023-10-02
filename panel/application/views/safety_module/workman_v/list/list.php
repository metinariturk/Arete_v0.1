<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="m-b-lg nav-tabs-horizontal">
                <!-- tabs list -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab-1" aria-controls="tab-1" role="tab"
                                                              data-toggle="tab">Aktif
                            Çalışanlar<br> <?php echo count($activeworkers); ?></a></li>
                    <li role="presentation"><a href="#tab-2" aria-controls="tab-2" role="tab" data-toggle="tab">Pasif
                            Çalışanlar<br> <?php echo count($passiveworkers); ?></a></li>
                    <li role="presentation"><a href="#tab-3" aria-controls="tab-3" role="tab" data-toggle="tab">Tüm
                            Çalışanlar<br> <?php echo count($allworkers); ?></a></li>
                </ul><!-- .nav-tabs -->
                <!-- Tab panes -->
                <div class="tab-content p-md">
                    <div role="tabpanel" class="tab-pane active in fade" id="tab-1">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/active_list"); ?>
                    </div><!-- .tab-pane  -->
                    <div role="tabpanel" class="tab-pane fade" id="tab-2">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/passive_list"); ?>
                    </div><!-- .tab-pane  -->
                    <div role="tabpanel" class="tab-pane fade" id="tab-3">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/all_list"); ?>
                    </div><!-- .tab-pane  -->
                </div><!-- .tab-content  -->
            </div><!-- .nav-tabs-horizontal -->
        </div><!-- END column -->
    </div><!-- END column -->
