<style>
    ul.list,
    ul.list ul {
        margin: 0;
        padding: 0;
        list-style-type: none;

    }

    ul.list ul {

        position: relative;
        margin-left: 10px;
    }

    ul.list ul:before {

        content: "";
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;

        border-left: 1px solid #ccc;
    }

    ul.list li {

        position: relative;
        margin: 0;
        padding: 5px 12px;

        color: #ccc;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 13px;
        font-weight: normal;
        line-height: 20px;
    }

    ul.list li {

        position: relative;

        color: #ccc;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 13px;
        font-weight: bold;
        line-height: 20px;
    }

    ul.list li li:hover,
    ul.list li li:hover + ul li li {

        color: RGBA(213, 235, 227, 1);
    }

    ul.list ul li:before {

        content: "";
        display: block;
        position: absolute;
        top: 15px;
        left: 0;
        width: 8px;
        height: 0;

        border-top: 1px solid #ccc;
    }

    ul.list ul li:last-child:before {
        top: 10px;
        bottom: 0;
        height: auto;

        background: RGBA(0, 58, 97, 1);
    }

    /* CSS Styles */

    #baslik {
        font-weight: bold;
        font-size: 15px;
    }

    #isaret {
        margin-top: -3px;
    }

    #para {
        color: #007bff;
        font-weight: bold;
    }

    #ozet {
        background-color: #f2f2f2;
        border-radius: 5px;
        padding: 10px;
    }


</style>
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
    .btn-download {
        border-radius: 50%; /* Yuvarlak köşeler */
        width: 27px; /* Buton genişliği */
        height: 27px; /* Buton yüksekliği */
        display: flex; /* İçerikleri ortalamak için flex kullan */
        align-items: center; /* Yatayda ortala */
        justify-content: center; /* Dikeyde ortala */
        font-size: 16px; /* İkon boyutu */
        color: #fff; /* İkon rengi */
        background-color: #50ba25; /* Buton arka plan rengi */
        text-decoration: none; /* Link alt çizgisini kaldır */
        transition: background-color 0.3s; /* Hover efekti için geçiş */
    }

    .btn-download:hover {
        color: #07296c; /* Hover rengi */
        background-color: #50ba25; /* Hover rengi */
    }

    .btn-display {
        border-radius: 50%; /* Yuvarlak köşeler */
        width: 27px; /* Buton genişliği */
        height: 27px; /* Buton yüksekliği */
        display: flex; /* İçerikleri ortalamak için flex kullan */
        align-items: center; /* Yatayda ortala */
        justify-content: center; /* Dikeyde ortala */
        font-size: 16px; /* İkon boyutu */
        color: #fff; /* İkon rengi */
        background-color: #2548ba; /* Buton arka plan rengi */
        text-decoration: none; /* Link alt çizgisini kaldır */
        transition: background-color 0.3s; /* Hover efekti için geçiş */
    }

    .btn-display:hover {
        background-color: #07296c; /* Hover rengi */
    }

</style>

<style>
    .table td input {
        width: 100%;
        box-sizing: border-box;
    }

    .table .input-cell {
        position: relative;
    }

    .table .save-btn {
        display: none;
    }

    .table .edit-mode .save-btn {
        display: inline-block;
    }

    .table .edit-mode td input {
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>

<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button.page-item {
        padding: 0px 0px 0px 0px;  /* Buton içindeki boşlukları küçültün */
        font-size: 0.8em;    /* Yazı boyutunu daha da küçültün */
        margin: 0px;       /* Butonlar arasındaki boşluğu azaltın */
        border-radius: 4px;  /* Kenarları yuvarlatın */
        height: auto;        /* Yüksekliği otomatik ayarla */
        min-width: 15px;     /* Butonun minimum genişliğini ayarlayın */
        text-align: center;  /* Yazıyı ortalayın */
        overflow: hidden;    /* Taşmaları gizle */
        white-space: nowrap; /* Tek satıra zorla */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.page-item a {
        line-height: 1; /* Buton içindeki yazının yüksekliğini ayarlayın */
        display: block;    /* Butonların dikey olarak tamamen doldurmasını sağlar */
        width: 100%;       /* Butonun tam genişlikte olmasını sağlar */
        font-size: inherit;/* Ana font boyutunu kullanın */
    }

    /* Aktif sayfa butonunun görünümünü ayarlamak için */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #007bff; /* Seçili sayfa butonunun arka plan rengi */
        color: white;               /* Seçili sayfa butonunun yazı rengi */
    }

    #stock-table_length select {
        width: 150px; /* Genişliği ihtiyacınıza göre ayarlayabilirsiniz */
    }

    #report_table_length select {
        width: 150px; /* Genişliği ihtiyacınıza göre ayarlayabilirsiniz */
    }

    #expensesTable_length select {
        width: 150px; /* Genişliği ihtiyacınıza göre ayarlayabilirsiniz */
    }

    #advancesTable_length select {
        width: 150px; /* Genişliği ihtiyacınıza göre ayarlayabilirsiniz */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #0056b3; /* Hover rengini ayarlayın */
        color: white;               /* Hover durumundaki yazı rengi */
    }

    .table-responsive {
        overflow-x: auto; /* Yalnızca yatay kaydırma çubuğu göster */
    }

    .table-responsive table {
        width: 100%; /* Tablonun genişliğini %100 yap */
        border-collapse: collapse; /* Kenar boşluklarını kaldır */
    }

    .table-responsive th, .table-responsive td {
        padding: 8px; /* Hücre içi boşluk */
        text-align: left; /* Metni sola yasla */
        border: 1px solid #ddd; /* Kenarlara sınır ekle */
    }

    .table-responsive th {
        background-color: #f2f2f2; /* Başlık hücreleri için arka plan rengi */
    }

    .icon-group {
        display: flex; /* Flexbox kullanarak yan yana hizalar */
        align-items: center; /* Dikey olarak ortalar */
    }

    .icon-group a {
        margin-right: 10px; /* İkonlar arasına boşluk ekler */
    }

    .icon-group a:last-child {
        margin-right: 0; /* Son ikonun sağındaki boşluğu kaldır */
    }

    #ibanText {
        cursor: zoom-in; /* Fare imlecini büyüteç (zoom-in) şeklinde değiştir */
    }

</style>


