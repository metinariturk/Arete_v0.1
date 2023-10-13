<div class="tab-pane fade <?php if (empty($active_tab)) {
    echo "active show";
} ?>"
     id="genel" role="tabpanel"
     aria-labelledby="genel-tab">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-5 col-lg-12 col-md-12 box-col-10">
                <div class="card-body d-flex">
                    <div class="row">
                        <div class="col-11">
                            <div class="file-sidebar">
                                <ul>
                                    <li>
                                        <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                            <div class="btn btn-light">
                                                <i data-feather="home"></i>
                                                <?php echo project_code_name($item->proje_id); ?>
                                            </div>
                                        </a>
                                    </li>
                                    <?php if (!empty($item->auction_id)) { ?>
                                        <?php $auction_control = get_from_any("auction", "dosya_no", "id", "$item->auction_id"); ?>
                                        <?php if (!empty($auction_control)) { ?>
                                            <li>
                                                <div class="btn btn-light ">
                                                    <a href="<?php echo base_url("auction/file_form/$item->auction_id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                      <?php echo auction_code($item->auction_id); ?> / <?php echo auction_name($item->auction_id); ?>
                                    </span>s
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (($item->subcont == 1)) { ?>
                                        <li>
                                            <a href="<?php echo base_url("contract/file_form/$item->main_contract"); ?>">
                                                <div class="btn btn-light ">

                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo contract_code_name($item->main_contract); ?>
                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <div class="btn btn-light">
                                <span style="padding-left: 40px">
                                    <i class="icon-gallery"></i>
                                    <?php echo contract_code_name($item->id); ?>
                                </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-1">
                            <a onclick="changeIcon(this)"
                               url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
                               id="myBtn">
                                <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?> fa-2x">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row py-3">
                        <div class="col-12">
                            <?php if (!empty($item->final_date)) { ?>
                                <h3>Kesin Kabulü Yapılmış</h3>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-12">
                            <div id="list1" onclick="openList1()" class="d-block">
                                <i class="fa fa-warning"></i>
                                <span class="px-2">Önemli Uyarılar</span>
                                <span class="badge rounded-pill badge-dark ms-2"><span id="result"></span></span>
                            </div>
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
                    <div class="row py-3 ">
                        <div class="col-6">
                            <strong>Sözleşme Bedeli:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Yaklaşık Maliyet:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo money_format(sum_anything("cost", "cost", "auction_id", "$item->auction_id")) . " " . $item->para_birimi; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-12 col-md-12 box-col-10">
                <div class="card">
                    <div class="file-content">
                        <div class="card-header">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                        </div>
                        <div class="image_list_container">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>