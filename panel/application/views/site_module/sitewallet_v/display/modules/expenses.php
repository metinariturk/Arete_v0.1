<table class="table tablecenter table-striped"">
<tbody class="bg-color-op-purple">
<?php $expenses = json_decode($item->expenses); ?>
<?php if ($expenses != null) { ?>
<tr>
    <th>id</th>
    <th>Harcama Tarihi</th>
    <th>Gider Türü</th>
    <th>
        Tutar
    </th>
    <th>
        Ödeme Türü
    </th>
    <th>
        Belge Türü
    </th>
    <th>
        Açıklama
    </th>
</tr>
<?php foreach ($expenses as $expense) { ?>
<tr>
    <td><?php echo $expense->id; ?></td>
    <td><?php echo $expense->harcama_tarih; ?></td>
    <td>
        <?php echo $expense->gider_turu; ?>
    </td>
    <td>
        <?php echo money_format($expense->tutar) . " TL"; ?>
    </td>

    <td>
        <?php echo $expense->odeme_tur; ?>
    </td>
    <td>
        <?php echo $expense->belge_tur; ?>
    </td>
    <td>
        <?php echo $expense->aciklama; ?>
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
