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
                                <li>
                                    <div class="btn btn-light">
                                        <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                            <i data-feather="home"></i>
                                            <?php echo project_code_name($item->proje_id); ?>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="btn btn-light">
                                <span style="padding-left: 20px">
                                    <i class="icon-gallery"></i>
                                    <?php echo $item->dosya_no; ?> / <?php echo $item->ihale_ad; ?>
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
                    <tr>
                        <td>Teklif Verilecek Kuruluş</td>
                        <td>
                            <?php echo company_name($item->isveren); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Hedeflenen Tarih</td>

                        <td>
                            <?php echo $item->talep_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->talep_tarih); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Bütçe Bedeli (Varsa)</td>
                        <td>
                            <?php echo money_format($item->butce) . " " . $item->para_birimi; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Yaklaşık Maliyet (Toplam)</td>
                        <td>
                            <?php echo money_format(sum_anything("cost", "cost", "auction_id", "$item->id")) . " " . $item->para_birimi; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Genel Açıklama - Kapsam</td>
                        <td>
                            <?php echo $item->aciklama; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Yetkili Personeller</td>
                        <td>
                            <div class="customers">
                                <ul>
                                    <?php if (!empty($item->yetkili_personeller)) { ?>
                                        <?php
                                        $yetkili_personeller = get_as_array($item->yetkili_personeller);
                                        foreach ($yetkili_personeller as $personel) { ?>
                                            <li class="d-inline-block">
                                            <span data-tooltip-location="top"
                                                  data-tooltip="<?php echo full_name($personel); ?>">
                                            <a href="<?php echo base_url("user/file_form/$personel"); ?>">
                                                <img
                                                        class="img-50 rounded-circle" <?php echo get_avatar($personel); ?>
                                                        alt=""
                                                        data-original-title=""
                                                        title="<?php echo full_name($personel); ?>">
                                            </a>
                                            </span>
                                            </li>
                                        <?php } ?>

                                    <?php } ?>
                                </ul>
                            </div>
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



