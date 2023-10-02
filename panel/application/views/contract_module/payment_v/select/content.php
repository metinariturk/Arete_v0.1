<form action="<?php echo base_url("$this->Module_Name/new_form"); ?>" method="post" enctype="multipart">
    <div class="widget">
        <div class="widget-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
        </div>
    </div>
    <div class="widget">
        <div class="widget-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/button_group"); ?>
        </div>
    </div>
</form>