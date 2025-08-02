
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("contract_module/boq_v/common/page_style"); ?>
</head>
<body  class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <?php $this->load->view("includes/navbar_left"); ?>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("contract_module/boq_v/add/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("contract_module/boq_v/common/page_script"); ?>
<script>
    function open_contract_group(anchor) {
        $(".renderGroup").show();
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            $(".renderGroup").html(response);
        })
    }
</script>
<script>
    function back_main(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".renderGroup").html(response);
        })
    }
</script>
</body>
</html>



