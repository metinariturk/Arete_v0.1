<?php if (!empty($payments)) { ?>
    <div class="col-4">
        <div class="card-header text-center">
            <h4>Finansal İlerleme</h4>
        </div>
        <div id="financechart"></div>
    </div>
    <div class="col-8">
        <div class="card-header text-center">
            <h4>Finansal Ölçütler</h4>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Dosya No</th>
                <th>Miktar</th>
                <th>Hakediş</th>
                <th>Kalan</th>
                <th>Yüzde</th>
            </tr>
            <tr>
                <?php $top_limit = $item->sozlesme_bedel; ?>
                <?php $sub_limit = 0; ?>
                <?php $amount_payed = sum_anything("payment", "bu_imalat_ihzarat", "contract_id", "$item->id"); ?>

                <th>
                    <?php echo $item->dosya_no; ?>
                </th>
                <th><?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></th>
                <th>
                    <?php if ($amount_payed >= $top_limit) {
                        echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi;
                    } elseif ($amount_payed < $top_limit and $amount_payed > $sub_limit) {
                        echo money_format($amount_payed) . " " . $item->para_birimi;
                    } ?>

                <th>
                    <?php if ($amount_payed >= $top_limit) {
                        echo money_format(0) . " " . $item->para_birimi;
                    } elseif ($amount_payed < $top_limit and $amount_payed > $sub_limit) {
                        echo money_format($item->sozlesme_bedel - $amount_payed) . " " . $item->para_birimi;
                    } ?>
                <th>%
                    <?php if ($amount_payed >= $top_limit) {
                        echo $x = 100;
                    } elseif ($amount_payed < $top_limit and $amount_payed > $sub_limit) {
                        echo $x = intval(($amount_payed - $sub_limit) / $item->sozlesme_bedel * 100);
                    } elseif ($amount_payed < $sub_limit) {
                        echo $x = 0;
                    } ?>

                </th>


            </tr>
            </thead>
            <tbody>
            <?php if (!empty($costincs)) { ?>
                <?php $top_limit = $item->sozlesme_bedel + sum_anything("costinc", "artis_miktar", "contract_id", "$item->id"); ?>
                <?php $sub_limit = $item->sozlesme_bedel + sum_anything("costinc", "artis_miktar", "contract_id", "$item->id"); ?>
                <?php $amount_payed = sum_anything("payment", "bu_imalat", "contract_id", "$item->id") +
                    sum_anything("payment", "bu_ihzarat", "contract_id", "$item->id"); ?>

                <?php
                foreach ($costincs

                         as $costinc) { ?>
                    <tr>
                        <td>
                            <a href="<?php echo base_url("costinc/file_form/$costinc->id"); ?>">
                                <?php echo $costinc->dosya_no; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo money_format($costinc->artis_miktar) . " " . $item->para_birimi; ?>
                        </td>
                        <td>
                            <?php $top_limit = $item->sozlesme_bedel + sum_anything_and("costinc", "artis_miktar", "contract_id", "$item->id", "id<=", "$costinc->id"); ?>
                            <?php $sub_limit = $item->sozlesme_bedel + sum_anything_and("costinc", "artis_miktar", "contract_id", "$item->id", "id<", "$costinc->id"); ?>
                            <?php $amount_payed = sum_anything("payment", "bu_imalat", "contract_id", "$item->id") +
                                sum_anything("payment", "bu_ihzarat", "contract_id", "$item->id"); ?>
                            <?php if ($amount_payed >= $top_limit) {
                                echo money_format($costinc->artis_miktar) . " " . $item->para_birimi;
                            } elseif ($amount_payed < $top_limit and $amount_payed > $sub_limit) {
                                echo money_format($amount_payed - $sub_limit) . " " . $item->para_birimi;
                            } elseif ($amount_payed <= $sub_limit) {
                                echo "-";
                            } ?>
                        </td>
                        <td>
                            <?php $top_limit = $item->sozlesme_bedel + sum_anything_and("costinc", "artis_miktar", "contract_id", "$item->id", "id<=", "$costinc->id"); ?>
                            <?php $sub_limit = $item->sozlesme_bedel + sum_anything_and("costinc", "artis_miktar", "contract_id", "$item->id", "id<", "$costinc->id"); ?>
                            <?php $amount_payed = sum_anything("payment", "bu_imalat", "contract_id", "$item->id") +
                                sum_anything("payment", "bu_ihzarat", "contract_id", "$item->id"); ?>
                            <?php if ($amount_payed >= $top_limit) {
                                echo money_format(0) . " " . $item->para_birimi;
                            } elseif ($amount_payed < $top_limit and $amount_payed > $sub_limit) {
                                echo money_format($top_limit - $amount_payed) . " " . $item->para_birimi;
                            } elseif ($amount_payed <= $sub_limit) {
                                echo "-";
                            } ?>
                        </td>
                        <td>%
                            <?php $top_limit = $item->sozlesme_bedel + sum_anything_and("costinc", "artis_miktar", "contract_id", "$item->id", "id<=", "$costinc->id"); ?>
                            <?php $sub_limit = $item->sozlesme_bedel + sum_anything_and("costinc", "artis_miktar", "contract_id", "$item->id", "id<", "$costinc->id"); ?>
                            <?php $amount_payed = sum_anything("payment", "bu_imalat", "contract_id", "$item->id") +
                                sum_anything("payment", "bu_ihzarat", "contract_id", "$item->id"); ?>
                            <?php if ($amount_payed >= $top_limit) {
                                echo 100;
                            } elseif ($amount_payed < $top_limit and $amount_payed > $sub_limit) {
                                echo round((($top_limit - $amount_payed) / $costinc->artis_miktar * 100), 2);
                            } elseif ($amount_payed <= $sub_limit) {
                                echo "-";
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
            <?php if (!empty($costincs)) { ?>
                <tfoot>
                <td>GENEL</td>
                <td><?php echo money_format($top_limit) . " " . $item->para_birimi; ?></td>
                <td><?php echo money_format($amount_payed) . " " . $item->para_birimi; ?></td>
                <td><?php echo money_format($top_limit - $amount_payed) . " " . $item->para_birimi; ?></td>
                <td>% <?php echo round(($amount_payed / $top_limit * 100), 2); ?></td>
                </tfoot>
            <?php } ?>
        </table>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-pill btn-outline-info btn-xs d-print-none"
                onclick="myFunction(this)"
                data-id="finance"
        >Sayfayı Ayır
        </button>
    </div>
    <div class="col-12" id="finance" style="display: none; page-break-after: always;">
        <div class="d-print-none horizontal-line"></div>
    </div>
<?php } ?>

