<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="text-center">
            <h3 class="m-0 m-h-md"> <?php echo ay_isimleri($ay)." ".$yil." ". $site->santiye_ad; ?> Şantiyesi
                <br> Puantaj Formu
            </h3>
        </div>
    </div>
</div>

<table class="table table-striped">
    <tbody>
    <tr>
        <td> <b>Adı Soyadı</b></td>

        <?php foreach (range(1, $gun_sayisi) as $number) { ?>
            <td>  <b><?php echo $number; ?></b></td>
        <?php } ?>
        <td> <b>Toplam</b></td>
    </tr>

    <?php foreach ($workers as $worker) { ?>
        <?php
        ?>
        <tr>
            <td>
                <?php echo worker_name($worker->id); ?>
            </td>
            <?php foreach (range(1, $gun_sayisi) as $number) { ?>
                <td>
                    <?php if ((isset([$worker->id][$number])) and ($hangi_gundeyiz - 3 > $number)) { ?>
                        <input type="checkbox" id="limitless" checked hidden
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>
                        <input type="checkbox" id="limitless" checked disabled
                               name=""/>
                    <?php } elseif ((!isset([$worker->id][$number])) and ($hangi_gundeyiz - 3 > $number)) { ?>
                        <input type="checkbox" id="limitless" hidden
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>
                        <input type="checkbox" id="limitless" disabled
                               name=""/>
                    <?php } elseif ((isset([$worker->id][$number])) and ($hangi_gundeyiz - 3 <= $number)) { ?>
                        <input type="checkbox" id="limitless" checked
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>
                    <?php } elseif ((isset([$worker->id][$number])) and ($hangi_gundeyiz - 3 <= $number)) { ?>
                        <input type="checkbox" id="limitless" checked hidden
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>
                        <input type="checkbox" id="limitless" checked
                               name=""/>
                    <?php } elseif ($hangi_gundeyiz < $number) { ?>
                        <input type="checkbox" id="limitless" disabled
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>
                    <?php } else { ?>
                        <input type="checkbox" id="limitless"
                               name="score[<?php echo $worker->id; ?>][<?php echo $number; ?>]"/>
                    <?php } ?>
                </td>

            <?php } ?>
            <td> </td>
        </tr>
    <?php } ?>
    <tfoot>
    <tr>
        <td>
            TOPLAM
        </td>
        <td>
        </td>


    </tr>
    </tfoot>
    </tbody>
</table>
