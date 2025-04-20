<table class="display contract-table">
<thead>
    <tr>
        <th>No</th>
        <th>Sözleşme Kodu</th>
        <th>Sözleşme Adı</th>
        <th>Yüklenici Adı</th>
        <th>İşveren Adı</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; foreach ($inactive_items as $item) { ?>
        <tr>
            <td class="w5c"><?php echo $i++; ?></td>
            <td><a href="<?= base_url("contract/file_form/$item->id"); ?>"><?= $item->dosya_no; ?></a></td>
            <td><a href="<?= base_url("contract/file_form/$item->id"); ?>"><?= $item->contract_name; ?></a></td>
            <td><a href="<?= base_url("contract/file_form/$item->id"); ?>"><?= company_name($item->yuklenici); ?></a></td>
            <td><a href="<?= base_url("contract/file_form/$item->id"); ?>"><?= company_name($item->isveren); ?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>