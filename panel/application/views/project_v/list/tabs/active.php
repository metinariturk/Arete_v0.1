<table class="display project-table">
    <thead>
    <tr>
        <th>No</th>
        <th>Proje Kodu</th>
        <th>Proje Adı</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;
    foreach ($active_items as $item) { ?>
        <tr>
            <td class="w5c"><?php echo $i++; ?></td>
            <td><a href="<?= base_url("project/file_form/$item->id"); ?>"><?= $item->dosya_no; ?></a></td>
            <td><a href="<?= base_url("project/file_form/$item->id"); ?>"><?= $item->project_name; ?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>