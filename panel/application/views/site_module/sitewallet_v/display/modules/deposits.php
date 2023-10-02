<table class="table tablecenter table-striped"">
<tbody class="bg-color-op-purple">
<?php $deposits = json_decode($item->deposits); ?>
<?php if ($deposits != null) { ?>
<tr>
    <th>id</th>
    <th>Ödeme Tarihi</th>
    <th>Ödeme Türü</th>
    <th>
        Tutar
    </th>
    <th>
        Açıklama
    </th>
</tr>
<?php foreach ($deposits as $deposit) { ?>
<tr>
    <td><?php echo $deposit->id; ?></td>
    <td><?php echo $deposit->avans_tarih; ?></td>
    <td>
        <?php echo $deposit->odeme_tur; ?>
    </td>
    <td>
        <?php echo money_format($deposit->tutar) . " TL"; ?>
    </td>

    <td>
        <?php echo $deposit->aciklama; ?>
    </td>
</tr>


</tbody>

<?php } ?>
<tfoot>
<tr>
    <td></td>
    <td></td>
    <td><strong>TOPLAM</strong></td>
    <td>
        <strong><?php echo money_format($item->total) . " TL"; ?></strong>
    </td>
    <td colspan="3"></td>
</tr>
</tfoot>
<?php } ?>
</table>
<hr>
