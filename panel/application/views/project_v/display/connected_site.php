<div class="row content-container">
    <table class="table table-bordered table-striped table-hover pictures_list">
        <thead>
        <th>#id</th>
        <th>Şantiye Adı</th>
        <th>Başlangıç Tarihi</th>
        <th>Bağlı Sözleşme</th>
        </thead>
        <tbody>
        <?php
        foreach ($sites as $site) { ?>
            <tr>
                <td><?php echo $site->id; ?></td>
                <td>
                    <?php $site_yetkili = site_auth($site->id);
                    if ((in_array(active_user_id(), $site_yetkili)) or isAdmin()) { ?>
                        <a href="<?php echo base_url("site/file_form/$site->id"); ?>"><?php echo $site->santiye_ad; ?></a>
                    <?php } else { ?>
                        <?php echo $site->santiye_ad; ?>
                    <?php } ?>

                </td>
                <td><?php echo dateFormat_dmy($site->teslim_tarihi); ?></td>
                <td><?php echo cms_if_echo("$site->contract_id", "0", "Sözleşmesiz", contract_name($site->contract_id)); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
