<style>
    *{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
    }
    .tree-structure{
        list-style: none;
        clear: both;
        padding-left: 15px;
    }
    .tree-structure li {
        position: relative;
    }
    .tree-structure li a{
        font-weight: normal;
        color: red;
        text-decoration: none;
        font-weight: 700;
        vertical-align: middle;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.2s ease-in-out;
        display: inline-block;
        max-width: calc(100% - 50px);
        vertical-align: top;
    }
    .tree-structure li a:hover{
        padding-left: 5px;
    }
    .tree-structure > li > .num{
        display: inline-block;
        background: #333;
        min-width: 24px;
        padding-left: 0px;
        padding-right: 0px;
        text-align: center;
        padding: 3px 9px;
        margin-right: 10px;
        color: #fff;
        font-weight: 700;
        font-size: 12px;
    }
    .tree-structure > li > .num:after{
        position: absolute;
        content: "";
        width: 1px;
        height: 100%;
        background-color: #939393;
        top: 5px;
        left: 12px;
        z-index: -1;
    }
    .tree-structure > li:last-child > .num:after{
        height: calc(100% - 44px);
    }
    .tree-structure ol{
        padding: 20px 0 20px 45px;
    }
    .tree-structure ol li{
        list-style-type: none;
        padding: 8px 0
    }
    .tree-structure ol li .num{
        position: relative;
    }
    .tree-structure ol li a{
        color: #000;
        font-weight: normal;
    }
    .tree-structure .num{
        background-color: #666;
        min-width: 24px;
        padding-left: 0px;
        padding-right: 0px;
        text-align: center;
        padding: 3px 9px;
        margin-right: 10px;
        color: #fff;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
        vertical-align: middle;
    }
    .tree-structure  ol  li .num:before{
        position: absolute;
        content: "";
        top: 0;
        bottom: 0;
        right: 100%;
        margin: auto;
        width: 33px;
        height: 1px;
        background-color: #939393;
    }

    .tree-structure li > ol > li {
        position: relative;
    }

    .tree-structure ol ol {
        padding-left: 30px;
    }

    .tree-structure ol ol li .num {
        background-color: #999;
    }

    .tree-structure ol ol li a {
        color: #333;
    }

    .tree-structure ol ol ol {
        padding-left: 30px;
    }

    .tree-structure ol ol ol li .num {
        background-color: #bbb;
    }

    .tree-structure ol ol ol li a {
        color: #666;
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