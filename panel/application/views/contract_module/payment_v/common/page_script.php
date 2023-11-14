<script>
    function deletePaymentModule(btn) {
        var $data_url = $(btn).data("url");
        var url = btn.getAttribute('data-url');
        var text = btn.getAttribute('data-text');
        var note = btn.getAttribute('data-note');

        swal({
            title: "Bu " + text + "'Kalıcı Olarak Silmek İstediğinize Emin Misiniz?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "İptal",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Hakedişi Sil",
                    value: true,
                    visible: true,
                    className: "bg-danger",
                    closeModal: false,
                },
            },
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    swal({
                        title: "Metrajı da Silmek İstiyor musunuz?",
                        text: "Bu işlem geri alınamaz!",
                        icon: "warning",
                        buttons: {
                            close: {
                                text: "İptal",
                                value: null,
                                visible: true,
                                className: "",
                                closeModal: true,
                            },
                            cancel: {
                                text: "Hayır, Metrajı Silme",
                                value: false,
                                visible: true,
                                className: "",
                                closeModal: true,
                            },
                            confirm: {
                                text: "Evet, Metrajı da Sil",
                                value: true,
                                visible: true,
                                className: "bg-danger",
                                closeModal: true,
                            },
                        },
                        dangerMode: true,
                    })
                        .then((willDeleteMetraj) => {
                            if (willDeleteMetraj) {
                                swal("Dosya ve Metraj Başarılı Bir Şekilde Silindi", {
                                    icon: "success",
                                });
                                // Boq'u silmeyi onayladı, boq URL'sine yönlendir.
                                window.location.href = url;
                            } else if (willDeleteMetraj === false) {
                                swal("Dosya Başarılı Bir Şekilde Silindi", {
                                    icon: "success",
                                });
                                // Sadece dosyayı silmeyi onayladı, dosya URL'sine yönlendir.
                                window.location.href = url;
                            } else {
                                swal("Dosya Güvende");
                                // Kullanıcı "Vazgeç"e tıkladığında herhangi bir işlem yapma.
                            }
                        });
                } else {
                    swal("Dosya Güvende");
                    // Kullanıcı "Vazgeç"e tıkladığında herhangi bir işlem yapma.
                }
            });
    }
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
            $(".sortable").on("sortupdate", function(event, ui){
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data : $data}, function(response){})
            })
        });
    }
</script>

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
                        $(".sortable").on("sortupdate", function(event, ui){
                            var $data = $(this).sortable("serialize");
                            var $data_url = $(this).data("url");
                            $.post($data_url, {data : $data}, function(response){})
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
    function handleButtonClick(mode) {
        var selectedOption = document.querySelector('input[name="options"]:checked');

        // Hiçbir radyo düğmesi seçili değilse işlem yapma
        if (!selectedOption) {
            console.log("Lütfen bir seçenek seçin.");
            return;
        }
        var dataUrl = selectedOption.getAttribute("data-url")+"/"+mode;
        // Yeni sekmede aç
        window.open(dataUrl, '_blank');
    }
</script>