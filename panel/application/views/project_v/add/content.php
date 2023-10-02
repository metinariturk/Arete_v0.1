<form id="save_project" action="<?php echo base_url("$this->Module_Name/save"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <?php $this->load->view("{$viewFolder}/{$subViewFolder}/input_form"); ?>
        <?php $this->load->view("{$viewFolder}/{$subViewFolder}/input_form2"); ?>
    </div>
    <div class="row">
        <?php $this->load->view("{$viewFolder}/{$subViewFolder}/error_form"); ?>
    </div>
</form>