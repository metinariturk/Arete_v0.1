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
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>

<script>
    $(".sortable").sortable();
    $(".sortable").on("sortupdate", function(event, ui){
        var $data = $(this).sortable("serialize");
        var $data_url = $(this).data("url");
        $.post($data_url, {data : $data}, function(response){})
    })
</script>

<script>

    function show_main(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_addmain").html(response);

            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function(event, ui){
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data : $data}, function(response){})
            })
        })
    }

    function show_sub(anchor) {
        $(".refresh_addsub").show();

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_addsub").html(response);
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function(event, ui){
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data : $data}, function(response){})
            })

        })
    }

    function show_title(anchor) {
        $(".refresh_addtitle").show();

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_addtitle").html(response);
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function(event, ui){
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data : $data}, function(response){})
            })

        })
    }

    function show_item(anchor) {
        $(".refresh_additem").show();

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_additem").html(response);
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function(event, ui){
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data : $data}, function(response){})
            })

        })
    }

    function show_detail(anchor) {
        $(".detail").show();

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".detail").html(response);
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function(event, ui){
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data : $data}, function(response){})
            })

        })
    }

    function add_main(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        alert(formAction);
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

    function add_item(anchor) {
        var $form = anchor.getAttribute('form-id');
        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_additem").html(response);

            // Formun işlemi tamamlanıp sunucudan yanıt alındığında formu temizle
            var form = document.getElementById($form);
            form.reset();
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
                        $(".refresh_addsub").hide();
                        $(".refresh_addtitle").hide();
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
                        $(".refresh_addtitle").hide();
                    })

                    swal("Dosya Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });

                } else {
                    swal("Dosya Güvende");
                }
            })
    }

    function deletetitle(btn) {
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
                        $(".refresh_addtitle").html(response);
                        $(".refresh_additem").hide();
                    })

                    swal("Dosya Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });

                } else {
                    swal("Dosya Güvende");
                }
            })
    }

    function deleteitem(btn) {
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
                        $(".refresh_additem").html(response);
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


