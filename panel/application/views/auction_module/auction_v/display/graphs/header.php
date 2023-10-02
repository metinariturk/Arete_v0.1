<div class="row">
    <div class="col-12 text-end">
        <div id="spoiler">
            <?php echo $bugun = date("d-m-Y"); ?>
        </div>
        <div class="d-print-none">Rapor Tarihi</div>
        <button class="btn btn-pill text-end btn-outline-info btn-xs d-print-none"
                onclick="toggle()"
                id="date"
        >Tarihi Gizle
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div>
            <p style="font-size:25px" class="text-center"><?php echo $settings->sirket_adi; ?></p>
            <p style="font-size:20px" class="text-center"><?php echo $item->ihale_ad; ?></p>
        </div>
    </div>
</div>