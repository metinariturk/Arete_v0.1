<div class="section-full p-tb80 inner-page-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-9 offset-lg-3 text-center">
                <div class="section-content">
                    <div class="m-b50">

                        <!-- TITLE START -->
                        <div class="section-head">
                            <div class="mt-separator-outer separator-left">
                                <div class="mt-separator">
                                    <h2 class="text-black text-uppercase sep-line-one "><span
                                                class="font-weight-300 site-text-primary">Firma</span> Bilgileri
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <!-- TITLE END -->
                        <!-- TABS DEFAULT NAV LEFT -->
                        <div class="mt-tabs vertical bg-tabs">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#web-design-15" type="button">Firma Bilgileri
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="web-design-15">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td style="width: 10%">
                                                <img width="20px" src="<?php echo base_url("assets"); ?>/fonts/copy.svg"
                                                     onclick="kopyala('name')">
                                            </td>
                                            <td style="width: 30%">Firma Adı</td>
                                            <td style="width: 60%" id="name"><?php echo $settings->sirket_adi; ?></td>

                                        </tr>
                                        <tr>
                                            <td style="width: 10%">
                                                <img width="20px" onclick="kopyala('adres')"
                                                     src="<?php echo base_url("assets"); ?>/fonts/copy.svg">
                                            </td>
                                            <td>Adres</td>
                                            <td id="adres"><?php echo $settings->adres; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10%">
                                                <img width="20px" onclick="kopyala('tel_no_1')"
                                                     src="<?php echo base_url("assets"); ?>/fonts/copy.svg">
                                            </td>
                                            <td>Telefon</td>
                                            <td id="tel_no_1"><?php echo $settings->tel_no_1; ?></td>
                                        </tr>
                                        <?php if (isset($settings->tel_no_2)) {
                                            ?>
                                            <tr>
                                                <td style="width: 10%">
                                                    <img width="20px" onclick="kopyala('tel_no_2')"
                                                         src="<?php echo base_url("assets"); ?>/fonts/copy.svg">
                                                </td>
                                                <td>Telefon - 2</td>
                                                <td id="tel_no_2"><?php echo $settings->tel_no_2; ?></td>
                                            </tr>
                                            <?php
                                        } ?>

                                        <tr>
                                            <td style="width: 10%">
                                                <img width="20px" onclick="kopyala('email')"
                                                     src="<?php echo base_url("assets"); ?>/fonts/copy.svg">
                                            </td>
                                            <td>E-Posta</td>
                                            <td id="email"><?php echo $settings->email; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>