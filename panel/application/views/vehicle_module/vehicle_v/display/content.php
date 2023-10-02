<div class="col-md-12">
    <div class="widget">
        <div class="m-b-lg nav-tabs-horizontal">
            <!-- tabs list -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab-1" aria-controls="tab-1" role="tab" data-toggle="tab">Genel Bilgiler</a></li>
                <li role="presentation"><a href="#tab-2" aria-controls="tab-2" role="tab" data-toggle="tab">Ruhsat Bilgileri</a></li>
                <?php if  ($item->kiralik != 0 ) { ?>
                <li role="presentation"><a href="#tab-3" aria-controls="tab-3" role="tab" data-toggle="tab">Kiralama Bilgileri</a></li>
                <?php } ?>
                <li role="presentation"><a href="#tab-4" aria-controls="tab-4" role="tab" data-toggle="tab">Servis Bilgileri</a></li>
                <li role="presentation"><a href="#tab-5" aria-controls="tab-5" role="tab" data-toggle="tab">Sigorta/Kasko Bilgileri</a></li>
                <li role="presentation"><a href="#tab-6" aria-controls="tab-6" role="tab" data-toggle="tab">Yakıt Bilgileri</a></li>
            </ul><!-- .nav-tabs -->
            <!-- Tab panes -->
            <div class="tab-content p-md">
                <div role="tabpanel" class="tab-pane active in fade" id="tab-1">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/general"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-2">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/ruhsat"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-3">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/rent"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-4">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/service"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-5">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/sigorta"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel" class="tab-pane fade" id="tab-6">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/sections/fuel"); ?>
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
