
<!-- END column -->
<div class="container-fluid">
    <div class="row">
        <form action="<?php echo base_url("site/active_group/$site->id/2"); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-12">
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Modal -->

        </form>
    </div>
</div>





