

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
});





