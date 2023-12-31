<hr>
<div class="row">
    <div class="col-sm-12" id="explain" style="display: none">
        <div class="card-header">
            <h5 class="text-center">Açıklama</h5>
        </div>
        <div class="card-body">
            <div id="area1" contenteditable="true">
                <p>Açıklamanızı Buraya Ekleyiniz</p>
            </div>
        </div>
        <div class="col-12 text-center">
            <button class="btn btn-pill btn-outline-info btn-xs d-print-none"
                    onclick="myFunction(this)"
                    data-id="explain-line"
            >Sayfayı Ayır
            </button>
        </div>
        <div class="col-12" id="explain-line" style="display: none; page-break-after: always;">
            <div class="d-print-none horizontal-line"></div>
        </div>
    </div>

</div>
<div class="col-12 text-center">
    <button class="btn btn-pill btn-outline-info btn-xl d-print-none"
            onclick="hideGroup(this)"
            data-id="explain"
    >Açıklama Ekle
    </button>
</div>