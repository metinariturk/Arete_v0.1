<form id="update_Catalog"
      action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
    </div>
</form>






