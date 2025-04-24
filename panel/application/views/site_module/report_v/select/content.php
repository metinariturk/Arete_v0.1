<form action="<?php echo base_url("site_module/new_form/report_newform"); ?>" method="post" enctype="multipart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("site_module/report_v/select/input_form"); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="widget">
                        <div class="widget-body">
                            <?php $this->load->view("site_module/report_v/common/button_group"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


