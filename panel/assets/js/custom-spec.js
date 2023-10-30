function deleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".image_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function sitedeldeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".sitedel_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function technicaldeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".technical_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function conditiondeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".condition_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function safetydeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".safety_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function workplandeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".workplan_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function provisiondeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".provision_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function finaldeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".final_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function deleteConfirmationCatalog(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".image_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function deleteConfirmationModule(btn) {
    var $data_url = $(this).data("url");
    var url = btn.getAttribute('data-url');
    var text = btn.getAttribute('data-text');
    var note = btn.getAttribute('data-note');

    swal({
        title: "Bu " + text + "'Kalıcı Olarak Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });
                window.location.href = url;
            } else {
                swal("Dosya Güvende");
            }
        })
}

function disabled_module(btn) {
    var text = btn.getAttribute('data-text');
    var note = btn.getAttribute('data-note');

    swal({
        title: note,
        text: text,
        icon: "warning",
        buttons: ["İptal"],
        dangerMode: true,
    })

}

function cancelConfirmationModule(btn) {
    var url = btn.getAttribute('url');

    swal({
        title: "Değişiklik yapılmadan çıkılacak",
        text: "Emin Misiniz!",
        icon: "warning",
        buttons: ["Düzenlemeye Devam Et", "Değişiklikleri Uygulamadan Çık"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Değişiklik Yapılmadı", {
                    icon: "success",
                });
                window.location.href = url;
            }
        })
}

function deleteCatalogFiles(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.post($url, {}, function (response) {
                    $(".catalog_container").html(response);
                })
                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });
            } else {
                swal("Dosya Güvende");
            }
        })
}

function deleteCompanyavatar(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.post($url, {}, function (response) {
                    $(".avatar_list_container").html(response);
                })
                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });
            } else {
                swal("Dosya Güvende");
            }
        })
}

$(document).ready(function () {
    $('select[name="adress_city"]').on('change', function () {
        var cityID = $(this).val();
        var adress_cityOption = document.getElementById("adress_cityOption");
        var url = adress_cityOption.getAttribute('data-url');
        console.log(url);

        if (cityID) {
            $.ajax({
                url: url + cityID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="adress_district"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="adress_district"]').append('<option value="' + value.id + '">' + value.district + '</option>');
                    });
                }
            });
        } else {
            $('select[name="adress_district"]').empty();
        }
    });
});

$(document).ready(function () {
    $('select[name="tax_city"]').on('change', function () {
        var cityID = $(this).val();
        var tax_cityOption = document.getElementById("tax_cityOption");
        var url = tax_cityOption.getAttribute('data-url');
        console.log(url);

        if (cityID) {
            $.ajax({
                url: url + cityID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="tax_office"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="tax_office"]').append('<option value="' + value.id + '">' + value.tax_office + '</option>');
                    });
                }
            });
        } else {
            $('select[name="tax_office"]').empty();
        }
    });
});
$(document).ready(function () {
    $('.isActive').change(function () {
        var $data = $(this).prop("checked");
        var $data_url = $(this).data("url");

        if (typeof $data !== "undefined" && typeof $data_url !== "undefined") {

            $.post($data_url, {data: $data}, function (response) {
            });
        }
    });

    var uploadSection = Dropzone.forElement("#dropzone");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone").data("url");
        $.post($data_url, {}, function (response) {
            $(".image_list_container").html(response);
        })
    })

    var uploadSection = Dropzone.forElement("#dropzone_workplan");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_workplan").data("url");
        $.post($data_url, {}, function (response) {
            $(".workplan_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_sitedel");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_sitedel").data("url");
        $.post($data_url, {}, function (response) {
            $(".sitedel_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_avatar");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_avatar").data("url");
        $.post($data_url, {}, function (response) {
            $(".avatar_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_technical");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_technical").data("url");
        $.post($data_url, {}, function (response) {
            $(".technical_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_condition");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_condition").data("url");
        $.post($data_url, {}, function (response) {
            $(".condition_list_container").html(response);
        })
    })
});

function qualifydeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".qualify_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

function avatardeleteConfirmationFile(btn) {
    var $url = btn.getAttribute('url');

    swal({
        title: "Dosyayı Silmek İstediğine Emin Misin?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        buttons: ["İptal", "Sil"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.post($url, {}, function (response) {
                    $(".qualify_list_container").html(response);
                })

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                swal("Dosya Güvende");
            }
        })
}

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_qualify");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_qualify").data("url");
        $.post($data_url, {}, function (response) {
            $(".qualify_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_safety");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_safety").data("url");
        $.post($data_url, {}, function (response) {
            $(".safety_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_catalog");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_catalog").data("url");
        $.post($data_url, {}, function (response) {
            $(".catalog_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_provision");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_provision").data("url");
        $.post($data_url, {}, function (response) {
            $(".provision_list_container").html(response);
        })
    })
});

$(document).ready(function () {
    var uploadSection = Dropzone.forElement("#dropzone_final");
    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone_final").data("url");
        $.post($data_url, {}, function (response) {
            $(".final_list_container").html(response);
        })
    })
});






