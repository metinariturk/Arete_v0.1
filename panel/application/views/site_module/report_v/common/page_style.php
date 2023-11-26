<style>
    .enlarge-image {
        transition: transform 0.5s;
    }

    .enlarge-image:hover {
        transform: scale(2);
    }

    body{
        margin-top:20px;
        background:#DCDCDC;
    }
    .card-box {
        padding: 20px;
        border-radius: 3px;
        margin-bottom: 30px;
        background-color: #fff;
    }

    .file-man-box {
        padding: 20px;
        border: 1px solid #e3eaef;
        border-radius: 5px;
        position: relative;
        margin-bottom: 20px
    }

    .file-man-box .file-close {
        color: #f1556c;
        position: absolute;
        line-height: 24px;
        font-size: 24px;
        right: 10px;
        top: 10px;
        visibility: hidden
    }

    .file-man-box .file-img-box {
        line-height: 120px;
        text-align: center
    }

    .file-man-box .file-img-box img {
        height: 64px
    }

    .file-man-box .file-download {
        font-size: 32px;
        color: #98a6ad;
        position: absolute;
        right: 10px
    }

    .file-man-box .file-download:hover {
        color: #313a46
    }

    .file-man-box .file-man-title {
        padding-right: 25px
    }

    .file-man-box:hover {
        -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
        box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02)
    }

    .file-man-box:hover .file-close {
        visibility: visible
    }
    .text-overflow {
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
        width: 100%;
        overflow: hidden;
    }
    h5 {
        font-size: 15px;
    }

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

