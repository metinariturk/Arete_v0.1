<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="file-sidebar">
                        <ul>
                            <li>
                                <div class="btn btn-light">
                                    <a href="<?php echo base_url("project/file_form/$contract->proje_id"); ?>">
                                        <i data-feather="home"></i>
                                        <?php echo project_code_name($contract->proje_id); ?>
                                    </a>

                                </div>
                            </li>
                            <li>
                                <div class="btn btn-light">
                                <span style="padding-left: 20px">
                                    <i class="icon-gallery"></i>
                                     <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                                         <?php echo contract_code_name($contract->id); ?>
                                    </a>

                                </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-md-6">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Aşağıdaki Tüm Veriler ve Sözleşmeye Ait Dosyanın Tamamı Silinecektir. </h5>
                    <h5> Dosyanın yedeğini indirmek için <a href="<?php echo base_url("contract/download_backup/$contract->id"); ?>">Tıklayınız</a></h5>
                    <h6>Bu işlem geri alınamaz. Lütfen yapmış olduğunuz işlemi dikkatli bir şekilde inceleyiniz.</h6>
                    <hr>
                    <h5>Sözleşmeye Bağlı Avanslar (<?php echo count($advances); ?>)</h5>
                    <?php if (empty($advances)) { ?>
                        <i class="fa fa-check-circle fa-2x" style="color: green"></i> Sözleşmeye Bağlı Avans Yok
                    <?php } else { ?>
                        <?php foreach ($advances as $advance) { ?>
                            <?php echo $advance->dosya_no; ?> -  <?php echo money_format($advance->avans_miktar) . " " . $contract->para_birimi; ?> - <?php echo dateFormat_dmy($advance->avans_tarih); ?>
                            <a target="_blank" href="<?php echo base_url("advance/file_form/$advance->id"); ?>" ><i style="color: green; font-size: 12pt" class="fa fa-arrow-circle-right"></i> </a>
                            <br>
                        <?php } ?>
                    <?php } ?>
                    <hr>
                    <h5>Sözleşmeye Bağlı Teminatlar (<?php echo count($bonds); ?>)</h5>
                    <?php if (empty($bonds)) { ?>
                        <i class="fa fa-check-circle fa-2x" style="color: green"></i> Sözleşmeye Bağlı Teminat Yok
                    <?php } else { ?>
                        <?php foreach ($bonds as $bond) { ?>
                            <?php echo $bond->dosya_no; ?> -  <?php echo money_format($bond->teminat_miktar) . " " . $contract->para_birimi; ?> - <?php echo dateFormat_dmy($bond->teslim_tarihi); ?>
                                                            <a target="_blank" href="<?php echo base_url("bond/file_form/$bond->id"); ?>" ><i style="color: green; font-size: 12pt" class="fa fa-arrow-circle-right"></i> </a>

                            <br>
                        <?php } ?>
                    <?php } ?>
                    <hr>
                    <h5>Sözleşmeye Bağlı Keşif Artışları (<?php echo count($costincs); ?>)</h5>
                    <?php if (empty($costincs)) { ?>
                        <i class="fa fa-check-circle fa-2x" style="color: green"></i> Sözleşmeye Bağlı Keşif Artış Yok
                    <?php } else { ?>
                        <?php foreach ($costincs as $costinc) { ?>
                            <?php echo $costinc->dosya_no; ?> -  <?php echo money_format($costinc->artis_miktar) . " " . $contract->para_birimi; ?> - <?php echo dateFormat_dmy($costinc->artis_tarih); ?>
                                                            <a target="_blank" href="<?php echo base_url("costinc/file_form/$costinc->id"); ?>" ><i style="color: green; font-size: 12pt" class="fa fa-arrow-circle-right"></i> </a>

                            <br>
                        <?php } ?>
                        <?php print_r($costincs); ?>
                    <?php } ?>
                    <hr>
                    <h5>Sözleşmeye Bağlı Tahsilatlar (<?php echo count($collections); ?>)</h5>
                    <?php if (empty($collections)) { ?>
                        <i class="fa fa-check-circle fa-2x" style="color: green"></i>  Sözleşmeye Bağlı Tahsilat Yok
                    <?php } else { ?>
                        <?php foreach ($collections as $collection) { ?>
                            <?php echo $collection->dosya_no; ?> -  <?php echo money_format($collection->tahsilat_miktar) . " " . $contract->para_birimi; ?> - <?php echo dateFormat_dmy($collection->tahsilat_tarih); ?>
                                                            <a target="_blank" href="<?php echo base_url("collection/file_form/$collection->id"); ?>" ><i style="color: green; font-size: 12pt" class="fa fa-arrow-circle-right"></i> </a>

                            <br>
                        <?php } ?>
                    <?php } ?>
                    <hr>
                    <h5>Sözleşmeye Bağlı Süre Uzatımları (<?php echo count($extimes); ?>)</h5>
                    <?php if (empty($extimes)) { ?>
                        <i class="fa fa-check-circle fa-2x" style="color: green"></i> Sözleşmeye Bağlı Süre Uzatım Yok
                    <?php } else { ?>
                        <?php foreach ($extimes as $extime) { ?>
                            <?php echo $extime->dosya_no; ?> -  <?php echo money_format($extime->uzatim_miktar) . " Gün"; ?> - <?php echo dateFormat_dmy($extime->karar_tarih); ?>
                                                            <a target="_blank" href="<?php echo base_url("extime/file_form/$extime->id"); ?>" ><i style="color: green; font-size: 12pt" class="fa fa-arrow-circle-right"></i> </a>

                            <br>
                        <?php } ?>
                    <?php } ?>
                    <hr>
                    <h5>Sözleşmeye Bağlı Yeni Birim Fiyatlar (<?php echo count($newprices); ?>)</h5>
                    <?php if (empty($newprices)) { ?>
                        <i class="fa fa-check-circle fa-2x"
                           style="color: green"></i> Sözleşmeye Bağlı Yeni Birim Fiyat Yok
                    <?php } else { ?>
                        <?php foreach ($newprices as $newprice) { ?>
                            <?php echo $newprice->dosya_no; ?> -  <?php echo money_format($newprice->ybf_tutar) . " Gün"; ?> - <?php echo dateFormat_dmy($extime->ybf_tarih); ?>
                                                            <a target="_blank" href="<?php echo base_url("newprice/file_form/$newprice->id"); ?>" ><i style="color: green; font-size: 12pt" class="fa fa-arrow-circle-right"></i> </a>

                            <br>
                        <?php } ?>
                    <?php } ?>
                    <hr>
                    <h5>Sözleşmeye Bağlı Hakedişler (<?php echo count($payments); ?>)</h5>
                    <?php if (empty($payments)) { ?>
                        <i class="fa fa-check-circle fa-2x" style="color: green"></i> Sözleşmeye Bağlı Ödeme Yok
                    <?php } else { ?>
                        <?php foreach ($payments as $payment) { ?>
                            <?php echo $payment->hakedis_no." No'lu Hakediş"; ?> -  <?php echo money_format($payment->balance) . " " . $contract->para_birimi; ?> - <?php echo dateFormat_dmy($payment->imalat_tarihi); ?>
                                                            <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>" ><i style="color: green; font-size: 12pt" class="fa fa-arrow-circle-right"></i> </a>

                            <br>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <h5>Yukarıdaki tüm verilerle birlikte sözleşmeyi silmek için <a href="<?php echo base_url("contract/hard_delete/$contract->id"); ?>"> burayı</a> tıklayınız</h5>
    </div>
</div>



