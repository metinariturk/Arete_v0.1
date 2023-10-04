<div class="tab-pane fade" id="top-prep" role="tabpanel" aria-labelledby="prep-top-tab">
    <div class="table-responsive">
        <table class="display" id="basic-2">
            <thead>
            <tr>
                <th>Teklif Adı</th>
                <th>Proje Adı</th>
                <th>İşveren</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($passive_items as $passive) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("auction/file_form/$passive->id"); ?>">
                            <?php echo $passive->ihale_ad; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("auction/file_form/$passive->id"); ?>">
                            <?php echo project_name($passive->proje_id); ?>
                        </a>
                    </td>

                    <td>
                        <a href="<?php echo base_url("auction/file_form/$passive->id"); ?>">
                            <?php echo company_name($passive->isveren); ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
