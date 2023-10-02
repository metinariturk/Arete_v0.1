<form id="save"
      action="<?php echo base_url("$this->Module_Name/save"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form_2"); ?>
    </div>
    <div class="row">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/common/error_form"); ?>
    </div>
</form>
