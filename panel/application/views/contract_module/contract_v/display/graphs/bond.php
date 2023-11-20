<?php if (!empty($bonds)) { ?>
    <div class="col-4">
        <div class="card-header text-center">
            <h4>Teminat Durumu</h4>
        </div>
        <div id="bondchart"></div>
    </div>
    <div class="col-8">
        <div class="row">
        <div class="card-header text-center">
            <h4>Teminat Mektupları</h4>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Teminat No</th>
                <th>Gerekçe</th>
                <th>Teminat Tutar</th>
                <th>Oran</th>
                <th>Teslim Tarihi</th>
                <th>Geçerlilik Tarihi</th>
                <th>Durumu</th>
                <th>İade Tarihi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($bonds)) { ?>
                <?php foreach ($bonds as $bond) { ?>
                    <?php if (!empty($bond->teminat_gerekce == "advance")) { ?>
                        <?php if ($bond->teminat_gerekce == "advance") { ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                                        <?php echo $bond->dosya_no; ?>
                                    </a>
                                </td>
                                <td><?php echo module_name($bond->teminat_gerekce); ?></td>
                                <td><?php echo money_format($bond->teminat_miktar); ?><?php echo $item->para_birimi; ?></td>
                                <?php if ($bond->teminat_gerekce == "contract") { ?>
                                    <td>
                                        % <?php echo round(($bond->teminat_miktar / $item->sozlesme_bedel * 100), 2); ?></td>
                                <?php } elseif ($bond->teminat_gerekce == "advance") { ?>
                                    <td>
                                        % <?php $advance = get_from_any("advance", "avans_miktar", "id", "$bond->teminat_avans_id");
                                        echo round(($bond->teminat_miktar / $advance * 100), 2); ?>
                                    </td>
                                <?php } elseif ($bond->teminat_gerekce == "costinc") { ?>
                                    <td>
                                        % <?php $costinc = get_from_any("costinc", "artis_miktar", "id", "$bond->teminat_kesif_id");
                                        echo round(($bond->teminat_miktar / $costinc * 100), 2); ?>
                                    </td>
                                <?php } ?>
                                <td><?php echo dateFormat_dmy($bond->teslim_tarihi); ?></td>
                                <td><?php if (!empty($bond->gecerlilik_tarihi)) {
                                        echo dateFormat_dmy($bond->gecerlilik_tarihi);
                                    } else {
                                        echo "Süresiz";
                                    } ?></td>
                                <td><?php if (!empty($bond->teminat_durumu == 1)) {
                                        echo "İade Edildi";
                                    } else {
                                        echo "İade Edilmedi";
                                    } ?></td>
                                <td><?php if (!empty($bond->iade_tarihi)) {
                                        echo dateFormat_dmy($bond->iade_tarihi);
                                    } ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <?php if ((!empty($bond->teminat_gerekce == "contract")) or (!empty($bond->teminat_gerekce == "price_diff"))) { ?>
                        <?php if ($bond->teminat_gerekce == "contract" or $bond->teminat_gerekce == "price_diff") { ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                                        <?php echo $bond->dosya_no; ?>
                                    </a>
                                </td>
                                <td><?php echo module_name($bond->teminat_gerekce); ?></td>
                                <td><?php echo money_format($bond->teminat_miktar); ?><?php echo $item->para_birimi; ?></td>
                                <?php if ($bond->teminat_gerekce == "contract") { ?>
                                    <td>
                                        % <?php echo round(($bond->teminat_miktar / $item->sozlesme_bedel * 100), 2); ?></td>
                                <?php } elseif ($bond->teminat_gerekce == "advance") { ?>
                                    <td>
                                        % <?php $advance = get_from_any("advance", "avans_miktar", "id", "$bond->teminat_avans_id");
                                        echo round(($bond->teminat_miktar / $advance * 100), 2); ?>
                                    </td>
                                <?php } elseif ($bond->teminat_gerekce == "costinc") { ?>
                                    <td>
                                        % <?php $costinc = get_from_any("costinc", "artis_miktar", "id", "$bond->teminat_kesif_id");
                                        echo round(($bond->teminat_miktar / $costinc * 100), 2); ?>
                                    </td>
                                <?php } elseif ($bond->teminat_gerekce == "price_diff") { ?>
                                    <td>

                                    </td>
                                <?php } ?>
                                <td><?php echo dateFormat_dmy($bond->teslim_tarihi); ?></td>
                                <td><?php if (!empty($bond->gecerlilik_tarihi)) {
                                        echo dateFormat_dmy($bond->gecerlilik_tarihi);
                                    } else {
                                        echo "Süresiz";
                                    } ?></td>
                                <td><?php if (!empty($bond->teminat_durumu == 1)) {
                                        echo "İade Edildi";
                                    } else {
                                        echo "İade Edilmedi";
                                    } ?></td>
                                <td><?php if (!empty($bond->iade_tarihi)) {
                                        echo dateFormat_dmy($bond->iade_tarihi);
                                    } ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($bond->teminat_gerekce == "costinc") { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                                    <?php echo $bond->dosya_no; ?>
                                </a>
                            </td>
                            <td><?php echo module_name($bond->teminat_gerekce); ?></td>
                            <td><?php echo money_format($bond->teminat_miktar); ?><?php echo $item->para_birimi; ?></td>
                            <?php if ($bond->teminat_gerekce == "contract") { ?>
                                <td>
                                    % <?php echo round(($bond->teminat_miktar / $item->sozlesme_bedel * 100), 2); ?></td>
                            <?php } elseif ($bond->teminat_gerekce == "advance") { ?>
                                <td>
                                    % <?php $advance = get_from_any("advance", "avans_miktar", "id", "$bond->teminat_avans_id");
                                    echo round(($bond->teminat_miktar / $advance * 100), 2); ?>
                                </td>
                            <?php } elseif ($bond->teminat_gerekce == "costinc") { ?>
                                <td>
                                    % <?php $costinc = get_from_any("costinc", "artis_miktar", "id", "$bond->teminat_kesif_id");
                                    echo round(($bond->teminat_miktar / $costinc * 100), 2); ?>
                                </td>
                            <?php } elseif ($bond->teminat_gerekce == "price_diff") { ?>
                                <td>

                                </td>
                            <?php } ?>
                            <td><?php echo dateFormat_dmy($bond->teslim_tarihi); ?></td>
                            <td><?php if (!empty($bond->gecerlilik_tarihi)) {
                                    echo dateFormat_dmy($bond->gecerlilik_tarihi);
                                } else {
                                    echo "Süresiz";
                                } ?></td>
                            <td><?php if (!empty($bond->teminat_durumu == 1)) {
                                    echo "İade Edildi";
                                } else {
                                    echo "İade Edilmedi";
                                } ?></td>
                            <td><?php if (!empty($bond->iade_tarihi)) {
                                    echo dateFormat_dmy($bond->iade_tarihi);
                                } ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div>
                    <div>
                        <h4>Teminat Durum</h4>
                    </div>
                    <ul>
                        <li class="m-2"><b>Toplam Teminat</b><br><i><?php $total_bond = sum_anything("bond", "teminat_miktar", "contract_id", "$item->id");
                            echo money_format($total_bond) . " " . $item->para_birimi; ?></i>
                        </li>
                        <li class="m-2"><b>İade Edilen Teminat</b><br><i><?php $total_payback = sum_anything_and("bond", "teminat_miktar", "contract_id", "$item->id", "teminat_durumu", "1");
                            echo money_format($total_payback) . " " . $item->para_birimi; ?></i>
                        </li>
                        <li class="m-2"><b>Kalan Teminat</b><br><i>
                            <?php echo money_format($total_bond - $total_payback) . " " . $item->para_birimi; ?></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <div>
                        <h4>Sözleşme Teminatı</h4>
                    </div>
                    <ul>
                        <li class="m-2"><b>Toplam Teminat</b><br><i><?php $total_contract = sum_anything_and_or("bond", "teminat_miktar", "contract_id", "$item->id","teminat_gerekce","contract","price_diff");
                            echo money_format($total_contract) . " " . $item->para_birimi; ?></i>
                        </li>
                        <li class="m-2"><b>İade Edilen Teminat</b><br><i><?php $total_payback_contract = sum_anything_and_and_or("bond", "teminat_miktar", "contract_id", "$item->id", "teminat_durumu", "1","teminat_gerekce","contract","price_diff");
                            echo money_format($total_payback_contract) . " " . $item->para_birimi; ?></i>
                        </li>
                        <li class="m-2"><b>Kalan Teminat</b><br><i>
                            <?php echo money_format($total_contract - $total_payback_contract) . " " . $item->para_birimi; ?></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <div>
                        <h4>Avans Teminatı</h4>
                    </div>
                    <ul>
                        <li class="m-2"><b>Toplam Teminat</b><br><i><?php $total_advance = sum_anything_and("bond", "teminat_miktar", "contract_id", "$item->id","teminat_gerekce","advance");
                            echo money_format($total_advance) . " " . $item->para_birimi; ?></i>
                        </li>
                        <li class="m-2"><b>İade Edilen Teminat</b><br><i><?php $total_payback_advance = sum_anything_and_and("bond", "teminat_miktar", "contract_id", "$item->id", "teminat_durumu", "1","teminat_gerekce","advance");
                            echo money_format($total_payback) . " " . $item->para_birimi; ?></i>
                        </li>
                        <li class="m-2"><b>Kalan Teminat</b><br><i>
                            <?php echo money_format($total_advance - $total_payback_advance) . " " . $item->para_birimi; ?></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } ?>