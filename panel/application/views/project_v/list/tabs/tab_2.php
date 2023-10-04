<div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
    <div class="table-responsive">
        <table class="display" id="basic-2">
            <thead>
            <tr>
                <th>Proje Kodu</th>
                <th>Proje Adı</th>
                <th>Etiketler</th>
                <th>Departman</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($actives as $active) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("project/file_form/$active->id"); ?>">
                            <?php echo $active->proje_kodu; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("project/file_form/$active->id"); ?>">
                            <?php echo $active->proje_ad; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("project/file_form/$active->id"); ?>">
                            <?php echo tags($active->etiketler); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("project/file_form/$active->id"); ?>">
                            <?php echo $active->department; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

