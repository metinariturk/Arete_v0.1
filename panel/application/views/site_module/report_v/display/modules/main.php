<?php $weathers = json_decode($item->weather); ?>
<div class="card-body">
    <div id="container">
        <div id="left"><h5><a><?php get_readable_date($item->report_date); ?></a></h5></div>
        <div id="center">
            <form id="search" action="#" method="post">
                <div id="label1">
                    <div class="text-center">Günlük Rapor Formu</div>
                    <h2><?php echo $site->santiye_ad; ?></h2>
                    <p><?php echo $project->proje_ad; ?></p>
                </div>
            </form>
        </div>
        <div id="right"><h1><a><?php echo weather_icon($weathers->event); ?></a></h1>
            <?php echo $weathers->min_temp; ?> &deg; - <?php echo $weathers->max_temp; ?> &deg;
            <br>
            <?php echo ($item->off_days == 1) ? 'Çalışma Yok' : ''; ?>
        </div>
    </div>
</div>