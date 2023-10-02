<table class="table table-striped">
    <thead>
    <tr>
        <td class="text-center"
            colspan="<?php echo $gun_sayisi + 1; ?>"><?php echo ay_isimleri($ay) . " " . $yil . " " . $site->santiye_ad; ?></td>
    </tr>
    </thead>
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
                <?php echo worker_name($worker->id); ?>
            </td>
            <?php foreach (range(1, $gun_sayisi) as $number) { ?>
                <td>
                    <?php if (isset($a[$worker->id][$number])) { ?>
                        <input type="checkbox" id="limitless" checked
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>a
                    <?php } elseif ($hangi_gundeyiz < $number) { ?>
                        <input type="checkbox" id="limitless" disabled
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>b
                    <?php } else { ?>
                        <input type="checkbox" id="limitless"
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>c
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
    </tbody>
</table>
