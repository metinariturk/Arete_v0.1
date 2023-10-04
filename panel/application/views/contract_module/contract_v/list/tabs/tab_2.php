<div class="tab-pane fade" id="top-prep" role="tabpanel" aria-labelledby="prep-top-tab">
    <div class="row">
        <div class="tab-pane fade show active" id="top-all" role="tabpanel" aria-labelledby="top-all-tab">
            <div class="table-responsive">
                <table class="display" id="basic-2">
                    <thead>
                    <tr>
                        <th>Sözleşme Kodu</th>
                        <th>Sözleşme Adı</th>
                        <th>İşveren</th>
                        <th>Sözleşme Tutar</th>
                        <th>İmza Tarihi</th>
                        <th>Bitiş Tarihi Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($passive_items as $passive) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$passive->id"); ?>">
                                    <?php echo project_name($passive->proje_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$passive->id"); ?>">
                                    <?php echo $passive->sozlesme_ad; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$passive->id"); ?>">
                                    <?php echo company_name($passive->isveren); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$passive->id"); ?>">
                                    <?php echo money_format($passive->sozlesme_bedel) . " " . $passive->para_birimi; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$passive->id"); ?>">
                                    <?php echo dateFormat_dmy($passive->sozlesme_tarih); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$passive->id"); ?>">
                                    <?php echo $passive->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $passive->sozlesme_bitis); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>



    </div>
</div>
