<div class="tab-pane fade show active" id="top-all" role="tabpanel" aria-labelledby="top-all-tab">
    <div class="table-responsive">
        <table class="display" id="basic-1">
            <thead>
            <tr>
                <th>Proje Adı</th>
                <th>Sözleşme Adı</th>
                <th>İşveren</th>
                <th>Sözleşme Tutar</th>
                <th>İmza Tarihi</th>
                <th>Bitiş Tarihi Tarihi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($active_items as $active) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                            <?php echo project_name($active->proje_id); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                            <?php echo $active->sozlesme_ad; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                            <?php echo company_name($active->isveren); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                            <?php echo money_format($active->sozlesme_bedel) . " " . $active->para_birimi; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                            <?php echo dateFormat_dmy($active->sozlesme_tarih); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                            <?php echo $active->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $active->sozlesme_bitis); ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


