<div class="container-fluid">
    <div class="user-profile">
        <div class="row">
            <div class="col-sm-12">
                <div class="card hovercard text-center">
                    <div class="cardheader"><img alt=""
                                                 style="height: 250px; width: auto" <?php echo get_company_avatar($item->company); ?>>
                    </div>
                    <div class="user-image">
                        <div class="avatar"><img alt="" <?php echo get_avatar($item->id); ?>></div>
                        <div class="icon-wrapper"><a href="<?php echo base_url("user/update_form/$item->id"); ?>"><i
                                        class="icofont icofont-pencil-alt-5"></i></a></div>
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
                                            <h6><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;Katılma Tarihi</h6>
                                            <span><?php echo dateFormat_dmy($item->createdAt); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                <div class="user-designation">
                                    <div class="title"><?php echo full_name($item->id); ?></div>
                                    <div class="desc"><?php echo $item->profession; ?></div>
                                    <p><?php echo $item->unvan; ?></p>

                                </div>
                            </div>
                            <div class="col-sm-3 col-lg-4 order-sm-2 order-xl-2">
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="ttl-info text-start">
                                            <h6><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;Firma</h6>
                                            <a href="<?php echo base_url("company/file_form/$item->company"); ?>"><?php echo company_name($item->company); ?></a>
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
    </div>
</div>
