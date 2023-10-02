<script>
    function toggleAllCheckboxes(group) {
        var checkboxes = document.querySelectorAll("." + group + " input[type='checkbox']");
        var masterCheckbox = document.getElementById("masterCheckbox_" + group);

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = masterCheckbox.checked;
        }
    }
</script>
<script>
    function formatPhoneNumber(phoneNumber) {
        // Telefon numarasını 3-3-2-2 şeklinde formatla
        return phoneNumber.replace(/(\d{3})(\d{3})(\d{2})(\d{2})/, "($1) $2-$3-$4");
    }

    function formatAndDisplayPhoneNumber() {
        const input = document.getElementById("phoneInput");
        const value = input.value.replace(/\D/g, ""); // Sadece sayıları al

        // Telefon numarasını 3-3-2-2 şeklinde formatla
        const formattedNumber = formatPhoneNumber(value);

        // Görüntüleme
        const spanElement = document.getElementById("formattedPhoneNumber");
        spanElement.textContent = formattedNumber;
    }
</script>