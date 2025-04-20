<table class="display site-table" style="width:100%">
    <thead>
    <tr>
        <th>No</th>

        <th>Sözleşme Adı</th>
        <th>Şantiye Adı</th>
        <th>Şantiye Sorumlusu</th>
        <th>Günlük Rapor Sayısı</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>

    <?php foreach ($all_items as $item): ?>
        <tr>
            <td class="w5c"><?php echo $i++; ?></td>

            <td><a href="<?= base_url("site/file_form/$item->id"); ?>"><?= contract_name($item->contract_id); ?></a>
            </td>
            <td><a href="<?= base_url("site/file_form/$item->id"); ?>"><?= $item->santiye_ad; ?></a></td>
            <td><a href="<?= base_url("site/file_form/$item->id"); ?>"><?= full_name($item->santiye_sefi); ?></a></td>
            <td>
                <a href="<?= base_url("site/file_form/$item->id"); ?>">
                    <?= count($this->Report_model->get_all(["site_id" => $item->id])); ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
