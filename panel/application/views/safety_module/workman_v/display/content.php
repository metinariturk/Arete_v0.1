<div class="col-md-12">
    <div class="widget">
        <div class="m-b-lg nav-tabs-horizontal">
            <!-- tabs list -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" <?php if ($active_tab == 1 or $active_tab == null) { echo "class='active'"; }?> ><a href="#tab-1" aria-controls="tab-1" role="tab" data-toggle="tab">Genel Bilgiler</a></li>
                <li role="presentation" <?php if ($active_tab == 2) { echo "class='active'"; }?>><a href="#tab-2" aria-controls="tab-2" role="tab" data-toggle="tab">Eğitim ve Zimmet</a></li>
                <li role="presentation" <?php if ($active_tab == 3) { echo "class='active'"; }?>><a href="#tab-3" aria-controls="tab-3" role="tab" data-toggle="tab">Kaza ve Sağlık Raporu</a></li>
            </ul><!-- .nav-tabs -->
            <!-- Tab panes -->
            <div class="tab-content p-md">
                <div role="tabpanel" <?php if ($active_tab == 1 or $active_tab == null) { echo "class='tab-pane active in fade'"; } else { echo "class='tab-pane fade'"; } ?> class='tab-pane active in fade' id="tab-1">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_1"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel"<?php if ($active_tab == 2) { echo "class='tab-pane active in fade'"; } else { echo "class='tab-pane fade'"; } ?> id="tab-2">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_2"); ?>
                </div><!-- .tab-pane  -->
                <div role="tabpanel"<?php if ($active_tab == 3) { echo "class='tab-pane active in fade'"; } else { echo "class='tab-pane fade'"; } ?> id="tab-3">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_3"); ?>
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
