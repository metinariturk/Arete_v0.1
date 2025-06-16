
    <?php $this->load->view("contract_module/payment_v/common/page_style"); ?>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>
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
            <?php $this->load->view("contract_module/payment_v/display/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("contract_module/payment_v/common/page_script"); ?>
<?php $this->load->view("contract_module/payment_v/common/scenario1.php"); ?>
<script>
    const columns = document.querySelectorAll('td[class^="w-"]');
    // Her bir sütunu dolaşın ve genişliklerini ayarlayın
    columns.forEach((column) => {
        const className = column.classList[0]; // Sınıf adını alın, örneğin "w-3"
        const width = parseInt(className.split('-')[1]); // "w-3" sınıfından 3 rakamını alın
        column.style.width = width + '%'; // Genişliği ayarlayın
    });
</script>
<script>
    function submitForm() {
        // Formu gönder
        document.getElementById("myForm").submit();
    }
</script>

<script>
    function save_payment(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_payment").html(response);
        });
    }

</script>
<script>
    $(".sortable").sortable();
    $(".sortable").on("sortupdate", function (event, ui) {
        var $data = $(this).sortable("serialize");
        var $data_url = $(this).data("url");
        $.post($data_url, {data: $data}, function (response) {
        })
    })
</script>

</body>
</html>






