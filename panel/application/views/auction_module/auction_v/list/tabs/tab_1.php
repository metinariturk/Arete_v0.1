<div class="tab-pane fade show active" id="top-all" role="tabpanel" aria-labelledby="top-all-tab">
    <div class="table-responsive">
        <table class="display" id="basic-1">
            <thead>
            <tr>
                <th>Teklif Adı</th>
                <th>Proje Adı</th>
                <th>İşveren</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($active_items as $active) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("auction/file_form/$active->id"); ?>">
                            <?php echo $active->ihale_ad; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("auction/file_form/$active->id"); ?>">
                            <?php echo project_name($active->proje_id); ?>
                        </a>
                    </td>

                    <td>
                        <a href="<?php echo base_url("auction/file_form/$active->id"); ?>">
                            <?php echo company_name($active->isveren); ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
