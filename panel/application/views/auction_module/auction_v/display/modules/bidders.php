<?php if (isset($teklifler->offer)) { ?>
    <?php $teklifler = json_decode($teklifler->offer, true); ?>
    <?php foreach ($teklifler as $teklif) { ?>
        <?php $istekliler = array_keys($teklif); ?>
    <?php } ?>
<?php } ?>
<hr>
<div class="bidder_list_container">
    <div class="container-fluid">
        <div class="row">
            <?php $istekliler = json_decode($item->istekliler);
            if (!empty($istekliler)) { ?>
                <?php foreach ($istekliler as $istekli) { ?>
                    <div class="col-xxl-4 col-md-6">
                        <div class="prooduct-details-box">
                            <div class="media">
                                <?php $avatars = (directory_map("uploads/companys_v/system_companys/$istekli")); ?>
                                <img class="align-self-center img-fluid img-60" style=" border-radius: 30%;"
                                     src="<?php $avatars = (directory_map("uploads/companys_v/system_companys/$istekli"));
                                     if (!empty($avatars)) {
                                         echo base_url("uploads/companys_v/system_companys/$istekli/$avatars[0]");
                                     } else {
                                         echo base_url("assets/images/avtar/default-logo.png");
                                     } ?>"
                                     alt="#">
                                <div class="media-body ms-3">
                                    <div class="product-name">
                                        <h6><?php echo company_name($istekli); ?></h6>
                                    </div>
                                    <div class="avaiabilty">
                                        <div class="text-success"><?php echo get_from_id("companys", "profession", "$istekli"); ?></div>
                                    </div>
                                    <div class="price d-flex">
                                        <div class="text-muted me-1">Teklif</div>
                                        <?php if (!empty($teklifler)) { ?>
                                            <?php foreach ($teklifler as $teklif) { ?>
                                                <?php echo money_format($teklif[$istekli]) . " " . $item->para_birimi; ?>
                                                <br>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <a onclick="deleteConfirmationCompany(this)"
                                       url="<?php echo base_url("$this->Module_Name/delete_bidder/$item->id/$istekli"); ?>"
                                    <i style="font-size: 18px;
                                              color: Tomato;
                                              position: absolute;
                                              top: 10px;
                                              right: 10px;
                                              height: 16px;
                                              cursor: pointer;"
                                       class="fa fa-trash-o fa-2x"
                                       aria-hidden="true">
                                    </i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
