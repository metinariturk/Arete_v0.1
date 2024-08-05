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
                                <?php if (isset($item->contract_id)) { ?>
                                    <li>
                                        <div class="btn btn-light ">
                                            <a href="<?php echo base_url("contract/file_form/$item->contract_id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                      <?php echo contract_code_name($item->contract_id); ?>
                                    </span>
                                            </a>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li>
                                    <div class="btn btn-light">
                                        <a href="<?php echo base_url("site/file_form/$item->id"); ?>">
                                     <span style="padding-left: <?php cms_isset($item->contract_id, "40px", "20px"); ?>">
                                    <i data-feather="home"></i>
                                    <?php echo site_name($item->id); ?>
                                     </span>
                                        </a>
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
                        <td>Şantiye Adı</td>
                        <td>
                            <?php echo $item->santiye_ad; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Şantiye Şefi</td>
                        <td>
                            <?php if (!empty($item->santiye_sefi)) { ?>
                                <span data-tooltip-location="top"
                                      data-tooltip="<?php echo full_name($item->santiye_sefi); ?>">
                                            <a href="<?php echo base_url("user/file_form/$item->santiye_sefi"); ?>">
                                                <img
                                                        class="img-50 rounded-circle" <?php echo get_avatar($item->santiye_sefi); ?>
                                                        alt=""
                                                        data-original-title=""
                                                        title="<?php echo full_name($item->santiye_sefi); ?>">
                                            </a>
                                            </span>
                            <?php } ?>
                            <?php echo full_name($item->santiye_sefi); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Teknik Personeller</td>
                        <td>
                            <?php if (!empty($item->teknik_personel)) { ?>
                                <?php foreach (get_as_array($item->teknik_personel) as $personel) { ?>
                                    <a href="<?php echo base_url("user/file_form/$item->santiye_sefi"); ?>">
                                        <img
                                                class="img-50 rounded-circle" <?php echo get_avatar($personel); ?>
                                                alt=""
                                                data-original-title=""
                                                title="<?php echo full_name($personel); ?>">
                                    </a>
                                    <?php echo full_name($personel); ?>
                                    <br>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Aktif Ekipler</td>

                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>Aktif Makineler</td>
                        <td>
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
                </div>
            </div>
        </div>
    </div>
</div>

