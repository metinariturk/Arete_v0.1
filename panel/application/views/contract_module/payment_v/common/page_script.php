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
    function handleButtonClick(action) {
        // Get the button element
        var clickedButton = document.activeElement;

        // Get the name attribute of the clicked button
        var buttonName = clickedButton.name;

        // Get the selected radio button based on the button's name attribute
        var selectedRadio = document.querySelector('input[name="' + buttonName + '"]:checked');

        // Get the URL from the selected radio button
        var url = selectedRadio ? selectedRadio.getAttribute('data-url') : '';

        // Append the action value to the URL
        url = url + '/' + action;

        window.open(url, '_blank');
    }
</script>
<script>
    function asd(action) {
        // Get the button element
        var form = document.forms["print_all"];
        form.action = "<?php echo base_url("payment/print_all/$item->id") ?>/" + action;
        form.submit();
    }
</script>

<script>
    function wd_toggleCheckbox(checkbox) {
        var otherCheckboxName = checkbox.name === "wd_hide_zero" ? "wd_all" : "wd_hide_zero";
        var otherCheckbox = document.querySelector('input[name="' + otherCheckboxName + '"]');

        if (checkbox.checked) {
            otherCheckbox.checked = false;
        }
    }
</script>

<script>
    function green_toggleCheckbox(checkbox) {
        var otherCheckboxName = checkbox.name === "green_hide_zero" ? "green_all" : "green_hide_zero";
        var otherCheckbox = document.querySelector('input[name="' + otherCheckboxName + '"]');

        if (checkbox.checked) {
            otherCheckbox.checked = false;
        }
    }
</script>

<script>
    function calculate_toggleCheckbox(checkbox) {
        var otherCheckboxName = checkbox.name === "calculate_all" ? "calculate_seperate_sub" : "calculate_all";
        var otherCheckbox = document.querySelector('input[name="' + otherCheckboxName + '"]');

        if (checkbox.checked) {
            otherCheckbox.checked = false;
        }
    }
</script>