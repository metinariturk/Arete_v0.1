
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/include_datatable_css"); ?>
</head>
<body class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
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
            <?php $this->load->view("contract_module/contract_v/list/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>
<script>
    $(document).ready(function () {
        // Tüm sözleşme tablolarını başlat
        $('.contract-table').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
            }
        });

        // Sekme değiştirildiğinde tablodaki responsive kırılmaların önüne geç
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
    });
</script>

</body>
</html>





