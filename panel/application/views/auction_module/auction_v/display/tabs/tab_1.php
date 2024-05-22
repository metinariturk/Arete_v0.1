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
                                    <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                        <div class="btn btn-light">

                                            <i data-feather="home"></i>
                                            <?php echo project_code_name($item->proje_id); ?>
                                        </div>
                                    </a>
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
            <div class="container">
                <div class="row py-3">
                    <div class="col-6">
                        <p class="font-weight-bold">Teklif Verilecek Kuruluş</p>
                    </div>
                    <div class="col-6">
                        <p><?php echo company_name($item->isveren); ?></p>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-6">
                        Hedeflenen Tarih
                    </div>
                    <div class="col-6">
                        <?php echo $item->talep_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->talep_tarih); ?>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-6">
                        Bütçe Bedeli (Varsa)
                    </div>
                    <div class="col-6">
                        <?php echo money_format($item->butce) . " " . $item->para_birimi; ?>

                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-6">
                        Bütçe Bedeli (Varsa)
                    </div>
                    <div class="col-6">
                        <p><?php echo money_format(sum_anything("cost", "cost", "auction_id", "$item->id")) . " " . $item->para_birimi; ?></p>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-6">
                        Genel Açıklama - Kapsam
                    </div>
                    <div class="col-6">
                        <?php echo $item->aciklama; ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-7 col-lg-12 col-md-12 box-col-10">
            <div class="card">
                <div class="file-content">
                    <div class="card-header">
                        <form action="<?php echo base_url("$this->Module_Name/file_upload/$item->id"); ?>" method="post" enctype="multipart/form-data">
                            <!-- file input -->
                            <input type="file" name="files">

                            <input type="submit">
                        </form>
                    </div>
                    <div class="image_list_container">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



