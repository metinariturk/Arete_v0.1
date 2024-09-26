<style>
    ul.list,
    ul.list ul {
        margin:0;
        padding:0;
        list-style-type: none;

    }

    ul.list ul {

        position:relative;
        margin-left:10px;
    }

    ul.list ul:before {

        content:"";
        display:block;
        position:absolute;
        top:0;
        left:0;
        bottom:0;
        width:0;

        border-left:1px solid #ccc;
    }

    ul.list li  {

        position:relative;
        margin:0;
        padding:5px 12px;

        color:#ccc;
        text-decoration: none;
        text-transform: uppercase;
        font-size:13px;
        font-weight:normal;
        line-height:20px;
    }

    ul.list li {

        position:relative;

        color:#ccc;
        text-decoration: none;
        text-transform: uppercase;
        font-size:13px;
        font-weight:bold;
        line-height:20px;
    }

    ul.list li li:hover,
    ul.list li li:hover+ul li li {

        color: RGBA(213, 235, 227, 1);
    }

    ul.list ul li:before {

        content:"";
        display:block;
        position:absolute;
        top:15px;
        left: 0;
        width:8px;
        height:0;

        border-top:1px solid #ccc;
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
    .tabs {
        display: flex;
        border-bottom: 2px solid #ccc;
    }

    .tab-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        flex: 1;
        border-radius: 15px 15px 0 0; /* Üst köşeleri pahlı yapmak için */
        text-align: center;
        border-bottom: none;
        padding: 10px;
    }

    .tab-item a {
        text-decoration: none;
        color: #000;
        font-weight: bold;
    }

    .tab-item:not(:last-child) {
        margin-right: -1px; /* Sekmeleri birbirine değdirmek için */
    }

    .tab-item:hover {
        background-color: #e9ecef;
    }

    .custom-card {
        border-radius: 0 0 15px 15px; /* Üst köşeleri pahlı yapmak için */
        border: 1px solid #dcdcdc; /* İncecik ve çok açık gri çerçeve */
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .custom-card-header {
        font-size: 0.8rem; /* Başlık boyutu */
        font-weight: bold;
        border-radius: 15px 15px 0 0; /* Üst köşeleri pahlı yapmak için */
        background-color: #f8f9fa; /* Başlık arka plan rengi */
        padding: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .custom-card-body {
        padding: 1rem;
        border: 1px solid #dcdcdc; /* İncecik ve çok açık gri çerçeve */

    }
</style>