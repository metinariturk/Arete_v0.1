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

</style>