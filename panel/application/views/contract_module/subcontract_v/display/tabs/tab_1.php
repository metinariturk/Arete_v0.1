<div class="tab-pane fade <?php if (empty($active_tab)) {
    echo "active show";
} ?>"
     id="genel" role="tabpanel"
     aria-labelledby="genel-tab">
    <div class="row">
        <div class="col-xl-5 col-lg-12 col-md-12 box-col-10">
            <div class="card-body d-flex">
                <div class="row">
                    <div class="col-11">
                        <div class="file-sidebar">
                            <ul>

                                <?php if (!empty($item->proje_id)) { ?>
                                <li>
                                    <div class="btn btn-light">
                                        <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                            <i data-feather="home"></i>
                                            <?php echo project_code_name($item->proje_id); ?>
                                        </a>
                                    </div>
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
            <div class="card-body d-flex">
                <table class="table">
                    <tbody>
                    <?php if (!empty($item->final_date)) { ?>
                        <tr>
                            <td>
                                <h3>
                                    Kesin Kabulü Yapılmış
                                </h3>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td>Yüklenici Adı</td>
                        <td>
                            <?php echo company_name($item->yuklenici); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>İşin Süresi</td>

                        <td>
                            <?php echo $item->isin_suresi; ?> Gün
                        </td>
                    </tr>
                    <tr>
                        <td>Sözleşme İmza Tarihi</td>

                        <td>
                            <?php echo $item->sozlesme_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_tarih); ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Sözleşme Bitiş Tarihi</td>

                        <td>
                            <?php echo $item->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_bitis); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>İşin Türü</td>
                        <td>
                            <?php echo $item->isin_turu; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Teklif Türü</td>
                        <td>
                            <?php echo $item->sozlesme_turu; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Sözleşme Bedeli</td>
                        <td>
                            <?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?>
                        </td>
                    </tr>

                    </tbody>
                </table>
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
