<div class="tab-pane fade <?php if (empty($active_tab)) {
    echo "active show";
} ?>"
     id="genel" role="tabpanel"
     aria-labelledby="genel-tab">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-6 box-col-10">
                <div class="container">
                    <div class="row py-3">
                        <div class="col-12">
                            <?php if (!empty($item->final_date)) { ?>
                                <h3>Kesin Kabulü Yapılmış</h3>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-12" style="text-align: center">
                            <h4>
                                <?php if (!empty($item->parent)) { ?>
                                    <strong>Taşeron Sözleşmesi</strong>
                                    <br><?php echo contract_code_name($item->id); ?>
                                <?php } else { ?>
                                    <strong><?php echo contract_code_name($item->id); ?></strong>
                                <?php } ?>
                                <a onclick="changeIcon(this)"
                                   url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
                                   id="myBtn">
                                    <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?>"> </i>
                                </a>
                                <br>

                            </h4>
                            <?php if ($item->parent > 0) { ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/update/update"); ?>
                            <?php } elseif ($item->parent == 0 || !null ) { ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/update/update_sub"); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Proje</strong>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                <?php echo project_code_name($item->proje_id); ?>
                            </a>
                        </div>
                    </div>
                    <?php if (!empty($item->parent)) { ?>
                        <div class="row py-3">
                            <div class="col-6">
                                <strong>Ana Sözleşme:</strong>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo base_url("contract/file_form/$item->parent"); ?>">
                                    <?php echo contract_code_name($item->parent); ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Şantiye</strong>
                        </div>
                        <?php $site = $this->Site_model->get(array("contract_id" => $item->id)); ?>
                        <div class="col-6">
                            <?php if (isset($site)){ ?>
                                <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                    <?php echo site_code_name($site->id); ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Teklif</strong>
                        </div>
                        <div class="col-6">
                            <?php if (isset($site)){ ?>
                                <a href="<?php echo base_url("contract/file_form_offer/$item->id"); ?>">
                                    <?php echo contract_name($item->id); ?> (Teklif Dosyası)
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>İşveren:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo company_name($item->isveren); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Yüklenici Adı:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo company_name($item->yuklenici); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>İşin Süresi:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->isin_suresi; ?> Gün
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Sözleşme İmza Tarihi:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->sozlesme_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_tarih); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Yer Teslimi Tarihi:</strong>
                        </div>
                        <div class="col-6">
                            <?php if (date_control($item->sitedel_date)) { ?>
                                <?php echo $item->sitedel_date == null ? null : dateFormat($format = 'd-m-Y', $item->sitedel_date); ?>
                            <?php } else { ?>
                                <a class="btn btn-success m-r-10" data-bs-original-title=""
                                   href="<?php echo base_url("contract/file_form/$item->id/sitedel"); ?>">
                                    <i class="fa fa-plus-circle me-1"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Sözleşme Bitiş Tarihi:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_bitis); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>İşin Türü:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->isin_turu; ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Teklif Türü:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->sozlesme_turu; ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Sözleşme Bedeli:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?>
                        </div>
                    </div>
                    <?php if ($item->parent == 0 or $item->parent = null) { ?>
                        <div class="row py-3">
                            <div class="col-6">
                                <strong>Alt Sözleşmeler</strong>
                                <a href="<?php echo base_url("contract/new_form_sub/$item->id"); ?>"><i
                                            class="fa fa-plus-circle fa-lg"></i></a>
                            </div>
                            <div class="col-6">

                                <?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id)); ?>
                                <ol>
                                    <?php foreach ($sub_contracts as $sub_contract) { ?>
                                        <li><a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                                <?php echo $sub_contract->contract_name; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ol>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-6 box-col-10">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/common/add_document"); ?>
            </div>
        </div>
    </div>
</div>