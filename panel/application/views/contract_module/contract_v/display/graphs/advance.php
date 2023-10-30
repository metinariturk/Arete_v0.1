<?php if (isset($advances)) { ?>
    <div class="col-4">
        <div class="card-header text-center">
            <h4>Avans Durumu</h4>
        </div>
        <div id="advancechart"></div>
    </div>
    <div class="col-8">
        <div class="card-header text-center">
            <h4>Verilen Avanslar</h4>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Avans No</th>
                <th>Avans Tutar</th>
                <th>Mahsup Tutar</th>
                <th>Kalan Tutar</th>
                <th>Avans Tarihi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($advances)) { ?>
                <?php
                foreach ($advances as $advance) { ?>
                    <tr>
                        <td>
                            <a href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                                <?php echo $advance->dosya_no; ?>
                            </a>
                        </td>
                        <td><?php echo money_format($advance->avans_miktar); ?><?php echo $item->para_birimi; ?></td>
                        <td><?php $top_limit = sum_anything_and("advance", "avans_miktar", "contract_id", "$item->id", "id<=", "$advance->id"); ?>
                            <?php $sub_limit = sum_anything_and("advance", "avans_miktar", "contract_id", "$item->id", "id<", "$advance->id"); ?>
                            <?php $mahsup_avans = sum_anything("payment", "I", "contract_id", "$item->id"); ?>
                            <?php if ($mahsup_avans >= $top_limit) {
                                echo money_format($advance->avans_miktar) . " " . $item->para_birimi;
                            } elseif ($mahsup_avans < $top_limit and $mahsup_avans > $sub_limit) {
                                echo money_format($mahsup_avans - $sub_limit) . " " . $item->para_birimi;
                            } elseif ($mahsup_avans <= $sub_limit) {
                                echo money_format(0) . " " . $item->para_birimi;
                            } ?>
                        </td>
                        <td><?php $top_limit = sum_anything_and("advance", "avans_miktar", "contract_id", "$item->id", "id<=", "$advance->id"); ?>
                            <?php $sub_limit = sum_anything_and("advance", "avans_miktar", "contract_id", "$item->id", "id<", "$advance->id"); ?>
                            <?php $mahsup_avans = sum_anything("payment", "I", "contract_id", "$item->id"); ?>
                            <?php if ($mahsup_avans >= $top_limit) {
                                echo money_format(0) . " " . $item->para_birimi;
                            } elseif ($mahsup_avans < $top_limit and $mahsup_avans > $sub_limit) {
                                echo money_format($advance->avans_miktar - ($mahsup_avans - $sub_limit)) . " " . $item->para_birimi;
                            } elseif ($mahsup_avans <= $sub_limit) {
                                echo money_format($advance->avans_miktar) . " " . $item->para_birimi;
                            } ?>
                        </td>
                        <td><?php echo dateFormat_dmy($advance->avans_tarih); ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="text-center">GENEL</td>
                <td><?php $total_advance = sum_anything("advance", "avans_miktar", "contract_id", "$item->id");
                    echo money_format($total_advance) . " " . $item->para_birimi; ?></td>
                <td><?php $mahsup_avans = sum_anything("payment", "I", "contract_id", "$item->id");
                    echo money_format($mahsup_avans) . " " . $item->para_birimi; ?></td>
                <td><?php echo money_format($total_advance - $mahsup_avans) . " " . $item->para_birimi; ?></td>
            </tr>
            <tr>
                <td class="text-center">Mahsup Edilen Oran</td>
                <?php if ($mahsup_avans > 0 and $total_advance > 0) { ?>
                    <td>% <?php echo round(($mahsup_avans / $total_advance * 100), 2); ?></td>
                <?php } ?>
            </tr>
            <tr>
                <td class="text-center">Kalan Oran</td>
                <?php if ($mahsup_avans > 0 and $total_advance > 0) { ?>
                    <td>% <?php echo 100 - round(($mahsup_avans / $total_advance * 100), 2); ?></td>
                <?php } ?>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-pill btn-outline-info btn-xs d-print-none"
                onclick="myFunction(this)"
                data-id="advance"
        >Sayfayı Ayır
        </button>
    </div>
    <div class="col-12" id="advance" style="display: none; page-break-after: always;">
        <div class="d-print-none horizontal-line"></div>
    </div>
<?php } ?>

