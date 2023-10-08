<script src="<?php echo base_url("assets"); ?>/js/datatable/datatables/datatable.custom.js"></script>


<script>
    function deletePaymentModule(btn) {
        var $data_url = $(btn).data("url");
        var url = btn.getAttribute('data-url');
        var boq = btn.getAttribute('data-boq');
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
                                window.location.href = boq;
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
    function calcular(){
        var valorA = parseFloat(document.getElementById('calA').value, 10); //A Hücresi Veri Giriş
        var valorB = parseFloat(document.getElementById('calB').value, 10); //B Hücresi Veri Giriş
        var valorC = valorA/valorB*100; //C Hücresi Hesaplama
        var valorD = valorA/valorB*100; //C Hücresi Hesaplama
        if (valorB > 0 ) {
            document.getElementById('calC').innerHTML= valorC.toFixed(2);
            document.getElementById('calD').value = valorD.toFixed(2);
        } else {
            document.getElementById('calC').innerHTML= 0;
            document.getElementById('calD').value = 0;
        }
    }

    function myFunction(e) {
        e.value=e.value.replace(/,/g, '.')
    }

</script>
