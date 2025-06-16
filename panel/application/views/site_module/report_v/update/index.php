
    <?php $this->load->view("includes/head"); ?>
</head>
<body  class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>"> 
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("site_module/report_v/update/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("site_module/report_v/common/page_script"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<script>
    $(document).ready(function() {
        $('.delete-old-btn').click(function() {
            var confirmDelete = confirm("Bu satırı silmek istediğinize emin misiniz?");
            if (confirmDelete) {
                $(this).closest('.row').remove();
            }
        });
    });
</script>

</body>
</html>
