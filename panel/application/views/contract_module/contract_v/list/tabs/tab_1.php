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
                <?php if ($active->subcont != 1) { ?>
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
                    <?php $sub_conts = get_from_any_and_array("contract", "proje_id", "$active->proje_id", "subcont", "1"); ?>
                    <tr class="hidden-row">
                        <td colspan="6">
                            <div class="additional-info">
                                <?php foreach ($sub_conts as $sub_cont=>$value) { ?>
                                    <div class="row">
                                        <div class="col-12"><?php echo print_r($value); ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


