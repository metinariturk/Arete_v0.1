<div class="tab-pane fade show active" id="top-all" role="tabpanel" aria-labelledby="top-all-tab">
    <div class="table">
        <table class="display" id="basic-1">
            <thead>
            <tr>
                <th>Sözleşme Adı</th>
                <th>Proje Adı</th>
                <th>İşveren</th>
                <th>Sözleşme Tutar</th>
                <th>İmza Tarihi</th>
                <th>Bitiş Tarihi Tarihi</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($active_items as $active) { ?>
                <?php if ($active->subcont != 1) { ?>
                    <tr >
                        <td>
                            <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                                <?php echo $i++; ?> - <?php echo $active->sozlesme_ad; ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("contract/file_form/$active->id"); ?>">
                                <?php echo project_name($active->proje_id); ?>
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
                    <?php $j = "a";
                    $subcontracts = $this->Contract_model->get_all(array(
                        "main_contract" => $active->id,
                    )); ?>
                    <?php foreach ($subcontracts as $subcontract) { ?>
                        <tr>
                            <td style="text-align: right">
                                <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>">
                                    <?php echo $j . ' ';
                                    $j = chr(ord($j) + 1); ?> -  <?php echo $subcontract->sozlesme_ad; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>">
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>">
                                    <?php echo company_name($subcontract->yuklenici); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>">
                                    <?php echo money_format($subcontract->sozlesme_bedel) . " " . $subcontract->para_birimi; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>">
                                    <?php echo dateFormat_dmy($subcontract->sozlesme_tarih); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>">
                                    <?php echo $subcontract->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $subcontract->sozlesme_bitis); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


