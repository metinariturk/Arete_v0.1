<?php $weathers = json_decode($item->weather); ?>
<div class="card-body">
    <div id="container">
        <div id="left"><h5><a><?php dateFormat_dmy($item->report_date); ?></a></h5></div>
        <div id="center">
            <h6>Günlük Rapor Formu</h6>
            <h2><?php echo $site->santiye_ad; ?></h2>
            <p><?php echo $project->proje_ad; ?></p>
        </div>
        <div id="right">
            <?php echo ($item->off_days == 1) ? 'Çalışma Yok' : ''; ?>
        </div>
    </div>
</div>