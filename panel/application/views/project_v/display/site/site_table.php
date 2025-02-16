<table class="table table-responsive-sm">
    <thead>
    <tr>
        <th>Kodu</th>
        <th>Şantiye Adı</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sites as $site) { ?>
        <tr style="background-color: #baf7c2; border-radius: 10px;">
            <td><a href="<?php echo base_url("site/file_form/$site->id"); ?>"><?php echo $site->dosya_no; ?></a></td>
            <td><a href="<?php echo base_url("site/file_form/$site->id"); ?>"><?php echo $site->santiye_ad; ?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
