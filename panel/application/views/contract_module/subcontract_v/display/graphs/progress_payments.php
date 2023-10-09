<?php if (!empty($payments)) { ?>
    <div class="col-12">
        <div class="card-header text-center">
            <h4>Aylık Hakediş Performansı</h4>
        </div>
        <div id="area-spaline"></div>
    </div>
    <div class="col-12">
        <div class="card-header text-center">
            <h4>Kümülatif Hakediş Performansı</h4>
        </div>
        <div id="area-cumulative"></div>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-pill btn-outline-info btn-xs d-print-none"
                onclick="myFunction(this)"
                data-id="progress_payments"
        >Sayfayı Ayır
        </button>
    </div>
    <div class="col-12" id="progress_payments" style="display: none; page-break-after: always;">
        <div class="d-print-none horizontal-line"></div>
    </div>
<?php } ?>