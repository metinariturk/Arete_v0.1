<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
</head>

<div class="page-body-wrapper">
    <div class="page-body">
        <?php $this->load->view("{$viewFolder}/common/title"); ?>
        <?php $this->load->view("{$viewFolder}/{$subViewFolder}/content"); ?>
    </div>
    <?php $this->load->view("includes/include_script"); ?>
</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>


