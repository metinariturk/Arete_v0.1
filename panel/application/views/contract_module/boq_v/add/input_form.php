<?php $active_boqs = (json_decode($contract->active_boq)); ?>
<?php foreach ($active_boqs as $active_group => $boqs) { ?>

    <table class="table">
        <thead>
        <tr>
            <th colspan="3" class="text-center">
                <?php echo boq_name($active_group); ?> <br>
            </th>
        </tr>
        <tr>
            <th>Poz Adı</th>
            <th colspan="2">Önceki Hakedişler Toplamı</th>
            <th colspan="2">Bu Hakediş Miktarı</th>
            <th colspan="2">Toplam</th>
        </tr>
        <tbody>
        <?php foreach ($boqs as $boq) { ?>
            <tr>
                <td>
                    <?php echo boq_name($boq); ?>
                </td>
                <td>
                    123123
                </td>
                <td style="width: 3%">
                    <?php echo boq_unit($boq); ?>
                </td>
                <td>
                    123
                </td>
                <td style="width: 3%">
                    <?php echo boq_unit($boq); ?>
                </td>
                <td>
                    123
                </td>
                <td style="width: 3%">
                    <?php echo boq_unit($boq); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        </thead>
    </table>
<?php } ?>
