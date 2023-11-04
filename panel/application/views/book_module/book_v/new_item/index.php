<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
</head>
<body onload="startTime()" class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
            <?php $this->load->view("includes/navbar_right"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<script>
    function show_main(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_addmain").html(response);

            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");
                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        })
    }

    function show_sub(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_addsub").html(response);

            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");
                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        })
    }

    function show_title(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_addtitle").html(response);

            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");
                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        })
    }

    function add_main(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_addmain").html(response);
        });
    }

    function add_sub(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_addsub").html(response);
        });
    }

    function add_title(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_addtitle").html(response);
        });
    }

    function deletemain(btn) {
        var $url = btn.getAttribute('url');
        var $warning = btn.getAttribute('warning');

        swal({
            title: $warning,
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.post($url, {}, function (response) {
                        $(".refresh_addmain").html(response);
                    })

                    swal("Dosya Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });

                } else {
                    swal("Dosya Güvende");
                }
            })
    }

    function deletesub(btn) {
        var $url = btn.getAttribute('url');
        var $warning = btn.getAttribute('warning');

        swal({
            title: $warning,
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.post($url, {}, function (response) {
                        $(".refresh_addsub").html(response);
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


</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>


