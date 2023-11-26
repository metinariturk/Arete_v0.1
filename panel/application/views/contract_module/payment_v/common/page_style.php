<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">

<script>
    function toggleSectionVisibility($cb,$1,$2,$3,$4,$5,$6) {
        var checkbox = document.getElementById($cb);
        var section1 = document.getElementById($1); // Section 1'nin ID'sini belirlemelisiniz
        var section2 = document.getElementById($2); // Section 2'nin ID'sini belirlemelisiniz
        var section3 = document.getElementById($3); // Section 2'nin ID'sini belirlemelisiniz
        var section4 = document.getElementById($4); // Section 2'nin ID'sini belirlemelisiniz
        var section5 = document.getElementById($5); // Section 2'nin ID'sini belirlemelisiniz
        var section6 = document.getElementById($6); // Section 2'nin ID'sini belirlemelisiniz

        if (checkbox.checked) {
            // Checkbox işaretlenmişse, sectionları göster
            section1.style.display = "block";
            section2.style.display = "block";
            section3.style.display = "block";
            section4.style.display = "block";
            section5.style.display = "block";
            section6.style.display = "block";
        } else {
            // Checkbox işaretlenmemişse, sectionları gizle
            section1.style.display = "none";
            section2.style.display = "none";
            section3.style.display = "none";
            section4.style.display = "none";
            section5.style.display = "none";
            section6.style.display = "none";
        }
    }
</script>
<style>


    td {
        height: 15pt;
    }

    td.calculate-row-right {
        text-align: right;
        border: 1px solid #a8b5cf;
    }

    td.total-group-row-right {
        text-align: right;
        border: 1px solid #a8b5cf;
    }

    td.calculate-row-left {
        text-align: left;
        border: 1px solid #a8b5cf;
    }

    td.total-group-row-left {
        text-align: left;
        border: 1px solid #a8b5cf;
    }

    td.calculate-row-center {
        text-align: center;
        border: 1px solid #a8b5cf;
    }

    td.total-group-row-center {
        text-align: center;
        border: 1px solid #a8b5cf;
    }

    td.total-group-header-center {
        background-color: #e7e7e7;
        text-align: center;
        border: 1px solid #a8b5cf;
    }

    td.total-group-header-right {
        background-color: #e7e7e7;
        text-align: right;
        border: 1px solid #a8b5cf;
    }

    td.calculate-header-center {
        background-color: #e7e7e7;
        text-align: center;
        border: 1px solid #a8b5cf;
    }
</style>

<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>
<style>
    input[readonly] {
        background-color: #f0f0f0; /* Arka plan rengi gri yapılabilir */
        color: #888; /* Yazı rengi gri yapılabilir */
        border: 1px solid #ccc; /* Kenarlık rengi gri yapılabilir */
        cursor: not-allowed; /* Fare imlecini işaretçi olarak değiştirin */
        border-width: 2px; /* Border kalınlığını ayarlayın */
    }
</style>