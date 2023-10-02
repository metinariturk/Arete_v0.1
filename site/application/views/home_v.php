<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
</head>
<body>
<!-- HEADER START -->
<?php $this->load->view("includes/header"); ?>
<!-- HEADER END -->

<!-- CONTENT START -->
<div class="page-content">

    <?php $this->load->view("blank_v/content"); ?>

    <?php $this->load->view("includes/about_main"); ?>
    <?php $this->load->view("includes/quick_contact"); ?>

</div>
<!-- CONTENT END -->

<!-- FOOTER START -->
<?php $this->load->view("includes/footer"); ?>
<!-- FOOTER END -->

<?php $this->load->view("includes/include_script"); ?>


</body>
</html>