<div class="col-md-12">
    <div class="widget">
        <div class="m-b-lg nav-tabs-horizontal">
            <!-- tabs list -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab-1" aria-controls="tab-1" role="tab" data-toggle="tab">Genel Bilgiler</a></li>
                <li role="presentation"><a href="#tab-2" aria-controls="tab-2" role="tab" data-toggle="tab">Teknik Döküman ve Metraj</a></li>
                <li role="presentation"><a href="#tab-3" aria-controls="tab-3" role="tab" data-toggle="tab">Yaklaşık Maliyet</a></li>
                <li role="presentation"><a href="#tab-4" aria-controls="tab-4" role="tab" data-toggle="tab">Şartnameler</a></li>
                <li role="presentation"><a href="#tab-5" aria-controls="tab-5" role="tab" data-toggle="tab">Teşvik/Hibe</a></li>
                <li role="presentation"><a href="#tab-6" aria-controls="tab-6" role="tab" data-toggle="tab">İhale Görsel</a></li>
                <li role="presentation"><a href="#tab-7" aria-controls="tab-7" role="tab" data-toggle="tab">İhale Yayılama</a></li>
                <li role="presentation"><a href="#tab-8" aria-controls="tab-8" role="tab" data-toggle="tab">İstekliler</a></li>
                <li role="presentation"><a href="#tab-9" aria-controls="tab-9" role="tab" data-toggle="tab">Teklifler</a></li>
            </ul><!-- .nav-tabs -->
            <!-- Tab panes -->
            <div class="tab-content p-md">
                <div role="tabpanel" class="tab-pane active in fade" id="tab-1">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_1"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-2">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_2"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-3">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_3"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-4">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_4"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-5">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_5"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-6">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_6"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-7">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_7"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-8">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_8"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-9">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_9"); ?>
                </div><!-- .tab-pane  -->
            </div><!-- .tab-content  -->
        </div><!-- .nav-tabs-horizontal -->
    </div><!-- .widget -->
</div><!-- END column -->
<div class="col-md-12">
    <div class="widget">
        <div class="widget-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/button_group"); ?>
        </div>
    </div>
</div>
