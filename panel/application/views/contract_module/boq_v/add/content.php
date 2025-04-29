<form id="save_boq"
      action="<?php echo base_url("Boq/save/$contract_id/$payment->id/exit"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <?php $this->load->view("contract_module/boq_v/add/input_form"); ?>
</form>
