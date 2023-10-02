<div class="col-md-12">
    <div class="widget">
        <div class="m-b-lg nav-tabs-horizontal">
            <!-- tabs list -->
            <ul class="nav nav-tabs" role="tablist">
                <?php
                display_tab($tab_index, $active_tab);
                ?>
            </ul><!-- .nav-tabs -->
            <!-- Tab panes -->
            <div class="tab-content p-md">
                <?php $tab_count = count($tab_index);
                $tab_range = range(1, $tab_count);
                ?>
                <?php foreach ($tab_range as $range) { ?>
                    <?php if ($range == $active_tab) { ?>
                        <div role="tabpanel" class="tab-pane active in fade" class="tab-pane active in fade"
                             id="tab-<?php echo "$range"; ?>">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_" . $range) ?>
                        </div>
                    <?php } else { ?>
                        <div role="tabpanel" class="tab-pane fade" class="tab-pane active in fade"
                             id="tab-<?php echo "$range"; ?>">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/table/tab_" . $range) ?>
                        </div>
                    <?php } ?>
                <?php } ?>
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
