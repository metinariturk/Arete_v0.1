
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
            $("." + divId).html(response); // Doğru div seçiciyi kullan
        });
    }
</script>

<script>
    function delete_sign(anchor) {
        var formId = anchor.getAttribute('form-id');
        var divId = $("#" + formId).attr("div");
        var formAction = $("#" + formId).attr("action");
        var formData = $("#" + formId).serialize();
        swal({
            title: "Dosyayı Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.post(formAction, formData, function (response) {
                        $("." + divId).html(response); // Doğru div seçiciyi kullan
                    });

                    swal("Dosya Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });

                } else {
                    swal("Dosya Güvende");
                }
            })
    }
</script>
