<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="text-center">
            <h3 class="m-0 m-h-md"><?php echo ay_isimleri($ay) . " Ayı " . $site->santiye_ad; ?> Şantiyesi
                <br> Puantaj Formu
            </h3>
        </div>
    </div>
</div>
<table class="table table-striped">

    <tbody>
    <tbody>
    <tr>
        <td><b>Adı Soyadı</b></td>

        <?php foreach (range(1, $gun_sayisi) as $number) { ?>
            <td><b><?php echo $number; ?></b></td>
        <?php } ?>
        <td><b>Toplam</b></td>
    </tr>

    <?php foreach ($workers as $worker) { ?>
        <?php
        $a = json_decode($item->score, TRUE);
        ?>
        <tr>
            <td>
                <?php echo worker_name($worker->id) ; ?>
            </td>
            <?php foreach (range(1, $gun_sayisi) as $number) { ?>
                <td>
                    <?php if (isset($a[$worker->id][$number])) { ?>
                        <span style="color: DarkGreen;">
                            <i class="fa-solid text-yellow fa-check"></i>
                        </span>
                    <?php } elseif ($hangi_gundeyiz < $number) { ?>
                        <span style="color: SteelBlue;">
                            <i class="fa-regular fa-circle"></i>
                        </span>
                    <?php } else { ?>
                        <span style="color: Tomato;">
                        <i class="fa-solid fa-xmark"></i>
                        </span>
                    <?php } ?>
                </td>

            <?php } ?>
            <td><b>
                    <?php if (isset($a[$worker->id])) {
                        echo count($a[$worker->id]);
                    } else {
                        echo "0";
                    } ?>
                </b></td>
        </tr>
    <?php } ?>


    <?php $score_array = json_decode($item->score, true); ?>
    <?php $score_array_id = array_keys($score_array); ?>
    <?php $worker_ids = array_column($workers, 'id'); ?>
    <?php $passives_in_month = array_diff($score_array_id, $worker_ids); ?>
    <?php foreach ($passives_in_month as $passive_in_month) { ?>
        <tr>
            <td>
                <del> <?php echo worker_name($passive_in_month); ?></del>
            </td>
            <?php foreach (range(1, $gun_sayisi) as $number) { ?>
                <td>
                    <?php if (isset($a[$passive_in_month][$number])) { ?>
                        <span style="color: DarkGreen;">
                            <i class="fa-solid text-yellow fa-check"></i>
                        </span>
                    <?php } elseif ($hangi_gundeyiz < $number) { ?>
                        <span style="color: SteelBlue;">
                        </span>
                    <?php } else { ?>
                        <span style="color: Tomato;">
                        <i class="fa-solid fa-xmark"></i>
                        </span>
                    <?php } ?>
                </td>

            <?php } ?>
            <td><b>
                    <?php if (isset($a[$passive_in_month])) {
                        echo count($a[$passive_in_month]);
                    } else {
                        echo "0";
                    } ?>
                </b></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td>
            TOPLAM
        </td>
        <?php
        $a = json_decode($item->score, TRUE);
        ?>
        <?php
        $x = 0;
        foreach (range(1, $gun_sayisi) as $number) { ?>
            <td>
                <b><?php $first_names = array_column($a, $number);
                    echo $y = count($first_names);
                    $x = $x + $y; ?></b>
            </td>
        <?php } ?>
        <td>
            <b><?php echo $x; ?></b>
        </td>
    </tr>
    </tfoot>

</table>


