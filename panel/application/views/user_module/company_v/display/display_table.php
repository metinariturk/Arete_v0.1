<div class="container-fluid">
    <div class="user-profile">
        <div class="row">
            <div class="col-sm-12">
                <div class="card hovercard text-center">
                    <div class="cardheader">
                        <div class="avatar_list_container">
                            <div class="content-container">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/common/avatar"); ?>
                            </div>
                        </div>
                    </div>

                    <div class="info">
                        <div class="row">
                            <div class="col-sm-3 col-lg-4 order-sm-1 order-xl-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ttl-info text-start">
                                            <h6><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Email</h6>
                                            <a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ttl-info text-start">
                                            <h6><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;Adres</h6>
                                            <span><?php echo $item->adress; ?> / <?php echo city_name($item->adress_city); ?> / <?php echo district_name($item->adress_district); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                <div class="user-designation">
                                    <p><?php echo $item->company_role; ?></p>
                                    <div class="title"><?php echo full_name($item->id); ?></div>
                                    <div class="desc"><?php echo $item->profession; ?></div>
                                    <p><?php echo $item->company_name; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-3 col-lg-4 order-sm-2 order-xl-2">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="ttl-info text-start">
                                            <a href="https://wa.me/+90<?php echo $item->phone; ?>" target="_blank">
                                                <h6>
                                                    <i class="fa fa-whatsapp fa-2xl"></i>&nbsp;Whatsapp
                                                </h6>
                                            </a>
                                            <a href="tel:+90<?php echo $item->phone; ?>"><i
                                                        class="fa fa-phone fa-lg"></i>
                                                +90 <?php echo formatPhoneNumber($item->phone); ?></a>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="ttl-info text-start">
                                            <h6><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;Cari Bilgileri
                                            </h6>
                                            <p>Şirket Adı : <?php echo $item->company_name; ?></p>
                                            <p>Vergi No : <?php echo $item->tax_no; ?></p>
                                            <p>Adres :<?php echo tax_office_name($item->tax_office); ?>
                                                /<?php echo city_name($item->tax_city); ?></p>
                                            <p> IBAN :<?php echo $item->IBAN; ?></p>
                                            <p>Banka :<?php echo $item->bank; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card hovercard text-center">
                    <div class="info">
                        <div class="row">
                            <div class="ttl-info text-start">
                                <h5>Sözleşmeler</h5>
                                <ul>
                                    <?php foreach ($contracts as $contract) { ?>
                                        <?php $cont_auth = contract_company($contract->id);
                                        if (in_array($item->id, $cont_auth)) { ?>
                                            <li>
                                                <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>"><?php echo $contract->sozlesme_ad; ?></a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
