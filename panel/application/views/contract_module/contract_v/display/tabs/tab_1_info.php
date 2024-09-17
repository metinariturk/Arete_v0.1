<div class="card-body">
    <ul class="nav nav-tabs" id="icon-tab" role="tablist">
        <li class="nav-item"><a class="nav-link active txt-primary" id="icon-home-tab"
                                data-bs-toggle="tab" href="#icon-home" role="tab" aria-controls="icon-home"
                                aria-selected="true"> <i class="icofont icofont-ui-home"></i>Genel Bilgiler</a>
        </li>
        <li class="nav-item"><a class="nav-link txt-primary" id="profile-icon-tabs" data-bs-toggle="tab"
                                href="#profile-icon" role="tab" aria-controls="profile-icon"
                                aria-selected="false"><i class="icofont icofont-presentation-alt"></i>Detay
                Bilgiler</a></li>
        <li class="nav-item"><a class="nav-link txt-primary" id="contact-icon-tab" data-bs-toggle="tab"
                                href="#contact-icon" role="tab" aria-controls="contact-icon"
                                aria-selected="false"><i class="icofont icofont-upload-alt"></i>Yüklemeler</a>
        </li>
    </ul>
    <div class="tab-content" id="icon-tabContent">
        <div class="tab-pane fade show active" id="icon-home" role="tabpanel"
             aria-labelledby="icon-home-tab">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <td><strong>Proje</strong></td>
                    <td>
                        <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                            <?php echo project_code_name($item->proje_id); ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><strong>Şantiye</strong></td>
                    <td>
                        <?php if ($site) { ?>
                            <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                <?php echo site_code_name($site->id); ?>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Yüklenici Adı:</strong></td>
                    <td><?php echo company_name($item->yuklenici); ?></td>
                </tr>
                <tr>
                    <td><strong>İşveren:</strong></td>
                    <td><?php echo company_name($item->isveren); ?></td>
                </tr>
                <tr>
                    <td><strong>İşin Türü:</strong></td>
                    <td><?php echo $item->isin_turu; ?></td>
                </tr>
                <tr>
                    <td><strong>Teklif Türü:</strong></td>
                    <td><?php echo $item->sozlesme_turu; ?></td>
                </tr>

                <?php if ($item->parent == 0 || $item->parent == null) { ?>
                    <?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id)); ?>
                    <tr>
                        <td><strong>Alt Sözleşmeler</strong>
                            <a href="<?php echo base_url("contract/new_form_sub/$item->id"); ?>"><i
                                        class="fa fa-plus-circle fa-lg"></i></a>
                        </td>
                        <td colspan="3">
                            <?php $i = 1; ?>
                            <?php foreach ($sub_contracts as $sub_contract) { ?>
                                <p>
                                    <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                        <?php echo $i++; ?> - <?php echo $sub_contract->contract_name; ?>
                                    </a>
                                </p>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="profile-icon" role="tabpanel" aria-labelledby="profile-icon-tabs">
            <div class="pt-3 mb-0">
                <div class="flex-space flex-wrap align-items-center">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <td style="width: 20%;"><strong>Sözleşme İmza Tarihi:</strong></td>
                            <td>
                                <?php echo $item->sozlesme_tarih == null ? null : dateFormat('d-m-Y', $item->sozlesme_tarih); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Sözleşme Bitiş Tarihi:</strong></td>
                            <td>
                                <?php echo $item->sozlesme_bitis == null ? null : dateFormat('d-m-Y', $item->sozlesme_bitis); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>İşin Süresi:</strong></td>
                            <td><?php echo $item->isin_suresi; ?> Gün</td>
                        </tr>
                        <tr>
                            <td><strong>Yer Teslimi Tarihi:</strong></td>
                            <td>
                                <?php if (date_control($item->sitedel_date)) { ?>
                                    <?php echo $item->sitedel_date == null ? null : dateFormat('d-m-Y', $item->sitedel_date); ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>İşin Türü:</strong></td>
                            <td><?php echo $item->isin_turu; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Teklif Türü:</strong></td>
                            <td><?php echo $item->sozlesme_turu; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Sözleşme Bedeli:</strong></td>
                            <td>
                                <?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="contact-icon" role="tabpanel" aria-labelledby="contact-icon-tab">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/add_document"); ?>

        </div>
    </div>
</div>
