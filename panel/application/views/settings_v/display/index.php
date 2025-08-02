
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewFolder}/common/page_style.php"); ?>

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
            <?php $this->load->view("{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>


<script>
    function update_group(anchor) {
        var $form = anchor.getAttribute('form-id');
        var form = $("#" + $form);
        var formAction = form.attr("action");
        var formData = form.serialize();

        $.ajax({
            url: formAction,
            type: "POST",
            data: formData,
            dataType: "json", // JSON olarak beklediğimizi belirtiyoruz
            success: function(response) {
                alert("Gelen Yanıt: " + JSON.stringify(response)); // Gelen veriyi JSON formatında göster

                if (response.status === "success") {
                    Swal.fire(
                        'Başarılı!',
                        response.message,
                        'success'
                    );
                    $("#refresh_group").html(response.refresh_group);
                } else {
                    Swal.fire(
                        'Hata!',
                        response.message,
                        'error'
                    );
                }
            },
            error: function(xhr, status, error) {
                alert("Hata Yanıtı: " + xhr.responseText); // HTML çıktısını görmek için
                Swal.fire(
                    'Hata!',
                    'Bir hata oluştu: ' + error,
                    'error'
                );
            }
        });
    }

</script>
<script>


    function delete_group(element, groupType) {
        var itemId = element.id; // Silinecek öğenin ID'sini alır
        var formAction = '<?php echo base_url("settings/delete_group/"); ?>' + itemId; // Silme için API URL'si
        var title, text;

        // Silme türüne göre başlık ve metin belirler
        if (groupType === 'main') {
            title = 'Silmek Üzeresiniz!';
            text = 'Bu grubu silerseniz, alt gruplar ve alt gruplara bağlı pozların hakedişlerdeki yaptığınız tüm metrajları da silinecektir? Emin misiniz?';
        } else if (groupType === 'sub') {
            title = 'Silmek Üzeresiniz!';
            text = 'Bu alt grubu silerseniz, hakedişlerdeki bu alt gruba dair yaptığınız tüm metrajlar da silinecektir? Emin misiniz?';
        }

        // SweetAlert ile onay penceresi
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'Hayır, iptal et'
        }).then((result) => {
            if (result.isConfirmed) {
                // Onay verildiyse silme işlemi yapılır
                $.post(formAction, function (response) {
                    var data = JSON.parse(response); // Backend'den gelen JSON verisini ayrıştır

                    // Sadece #refresh_group div'ini günceller
                    $("#refresh_group").html(data.refresh_group);

                    // Silme işlemi başarılı olduğunda bilgilendirme mesajı göster
                    Swal.fire(
                        'Silindi!',
                        'Grup başarıyla silindi.',
                        'success'
                    );
                }).fail(function () {
                    // Silme işleminde bir hata oluşursa kullanıcıyı bilgilendir
                    Swal.fire(
                        'Hata!',
                        'Silme işlemi sırasında bir hata oluştu.',
                        'error'
                    );
                });
            }
        });
    }

</script>

</body>
</html>



