<table class="display project-table">
<thead>
    <tr>
        <th>No</th>
        <th>Sözleşme Kodu</th>
        <th>Sözleşme Adı</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; foreach ($inactive_items as $item) { ?>
        <tr>
            <td class="w5c"><?php echo $i++; ?></td>
            <td><a href="<?= base_url("project/file_form/$item->id"); ?>"><?= $item->dosya_no; ?></a></td>
            <td><a href="<?= base_url("project/file_form/$item->id"); ?>"><?= $item->project_name; ?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>