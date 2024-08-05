<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>
    <style>
        @media print {
            .apexcharts-legend-marker {
                -webkit-print-color-adjust: exact;
            }
        }

        @page {
            size: A3 portrait;
            margin-left: 75px;
            margin-bottom: 60px;
            margin-right: 75px;
            margin-top: 75px;
        }
    </style>

    <?php $this->load->view("includes/head"); ?>
    <!-- Plugins css start-->

    <!-- Plugins css Ends-->
</head>
<body onload="startTime()" class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
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
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/title"); ?>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/file_upload_script.php"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>

<script>
    function delete_sign(btn) {
        var $url = btn.getAttribute('url');
        var $div = btn.getAttribute('div');

        swal({
            title: "Tüm isimler silinecek?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.post($url, {}, function (response) {
                        $("." + $div).html(response);
                        $(".sortable").sortable();
                        $(".sortable").on("sortupdate", function (event, ui) {
                            var $data = $(this).sortable("serialize");
                            var $data_url = $(this).data("url");
                            $.post($data_url, {data: $data}, function (response) {
                            })
                        })
                    })
                    swal("Dosya Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });
                } else {
                    swal("Dosya Güvende");
                }
            })
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

<script>
    function add_sign(anchor) {
        var formId = anchor.getAttribute('form-id');
        var divId = $("#" + formId).attr("div");
        var formAction = $("#" + formId).attr("action");
        var formData = $("#" + formId).serialize();

        $.post(formAction, formData, function (response) {
            $("." + divId).html(response);
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function (event, ui) {
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data: $data}, function (response) {
                })
            })
        });
    }
</script>

<script>
    $(document).ready(function () {
        $('#report_table').DataTable({
            "initComplete": function (settings, json) {
                // Sıra numaralarını güncelle
                $('#report_table').DataTable().column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }
        });
    });
</script>

</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





