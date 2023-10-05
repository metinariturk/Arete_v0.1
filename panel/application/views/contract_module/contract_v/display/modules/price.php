<?php $active_boqs = (json_decode($item->active_boq)); ?>
<?php foreach ($active_boqs as $active_group => $boqs) { ?>

    <table class="table">
        <thead>
        <tr>
            <th colspan="4" class="text-center">
                <?php echo boq_name($active_group); ?> <br>
            </th>
        </tr>
        <tr>
            <th class="text-center">Poz Adı</th>
            <th class="text-center">Sözleşme Miktarı</th>
            <th class="text-center">Fiyat</th>
            <th class="text-center">Toplam Tutar</th>
        </tr>
        <tbody>
        <?php foreach ($boqs as $boq) { ?>
            <tr>
                <td>
                    <?php echo boq_name($boq); ?>
                </td>
                <td class="text-center">
                    <input type="text"><?php echo boq_unit($boq); ?>
                </td>
                <td class="text-center">
                    <input type="text"><?php echo $item->para_birimi; ?>
                </td>

                <td class="text-center">
                    <input type="text"><?php echo $item->para_birimi; ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3">
                TOPLAM
            </td>
            <td  class="text-center">
                <input type="text"><?php echo $item->para_birimi; ?>
            </td>
        </tr>
        </tfoot>
        </thead>
    </table>
<?php } ?>
