<div class="row">
    <div class="text-center"><h3><?php echo site_name($site_id); ?><br>Şantiye Cüzdanı</h3></div>
</div>
<hr>
<table class="table" >
    <tbody class="bg-color-op-orange">
    <tr>
        <td style="width: 150px"><strong>Dosya No</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Şantiye Adı</strong></td>
        <td><?php echo $site_code . " / " . site_name($site_id); ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Proje Kodu/Adı</strong></td>
        <td><?php echo project_code_name($project_id); ?></td>
    </tr>
    <?php if (!empty($contract_id)) { ?>
        <tr>
            <td style="width: 150px"><strong>Sözleşme Kodu/Adı</strong></td>
            <td><?php echo contract_code($contract_id); ?> / <?php echo contract_name($contract_id); ?></td>
        </tr>
    <?php } ?>

    </tbody>
</table>
<hr>
