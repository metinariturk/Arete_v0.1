
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("site_module/report_v/common/page_style"); ?>
    <?php $this->load->view("site_module/report_v/common/page_script"); ?>

    <?php $this->load->view("includes/drag_drop_style"); ?>
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
            <?php $this->load->view("site_module/report_v/display/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<script>
    const reportLinks = <?php
        $links = [];
        foreach ($reports as $r) {
            $date = date('Y-m-d', strtotime($r->report_date));
            $links[$date] = $r->id;  // sadece id
        }
        echo json_encode($links);
        ?>;
</script>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/file_upload_script.php"); ?>
<?php $this->load->view("site_module/report_v/common/page_script"); ?>
<script>
    const BASE_URL = "<?php echo base_url(); ?>";
</script>
<script>
    document.querySelector('.days').addEventListener('click', e => {
        if (e.target.classList.contains('report-link')) {
            e.preventDefault();
            const reportId = e.target.getAttribute('data-id');

            fetch(`${BASE_URL}report/refresh_day/${reportId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById('refresh_report').innerHTML = data.form_html;
                        initFileUploader();
                    } else {
                        console.error('Veri yüklenemedi.');
                    }
                })
                .catch(error => console.error('Fetch error:', error));
        }
    });
</script>

</body>
</html>



