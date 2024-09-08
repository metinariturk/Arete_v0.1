<div class="row price_update">
    <div class="col-12">
        <div class="card-body ">

            <h4><?php echo money_format(sum_anything("contract_price", "total", "contract_id", "$item->id")); ?></h4>
            <hr>
            <?php foreach ($prices_main_groups as $prices_main_group) { ?>


                <h5><?php echo $prices_main_group->code . " - " . upper_tr($prices_main_group->name); ?>
                    - <?php echo money_format(sum_anything("contract_price", "total", "main_id", "$prices_main_group->id")); ?></h5>
                <?php $i = 1; ?>
                <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC"); ?>
                <?php foreach ($sub_groups as $sub_group) { ?>
                    <button class="btn btn-primary" onclick="openSearchModal(<?php echo $sub_group->id; ?>)">Kalem
                        Ekle
                    </button>
                    <h6><?php echo $sub_group->code . " - " . upper_tr($sub_group->name); ?>
                    </h6>
                    <?php $i++; ?>
                    <div class="dropTarget" data-info="<?php echo $sub_group->id; ?>">
                        <table class="table-s">
                            <tbody>

                            <tr>
                                <td class="table-header-cell">
                                    <p><strong>Poz No:</strong></p>
                                </td>
                                <td class="table-header-cell">
                                    <p><strong>Poz Tanımı</strong></p>
                                </td>
                                <td class="table-header-cell">
                                    <p><strong>Birim</strong></p>
                                </td>
                                <td class="table-header-cell">
                                    <p><strong>Miktar</strong></p>
                                </td>
                                <td class="table-header-cell">
                                    <p><strong>Fiyat</strong></p>
                                </td>
                                <td class="table-header-cell">
                                    <p><strong>Toplam</strong></p>
                                </td>
                                <td class="table-header-cell">
                                    <p><strong>İşlem</strong></p>
                                </td>
                            </tr>
                            <?php $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC"); ?>
                            <?php foreach ($boq_items as $boq_item) { ?>
                                <tr>
                                    <td class="table-cell w10">
                                        <input name="boq[<?php echo $boq_item->id; ?>][code]" onclick="hesaplaT"
                                               style="width: 100%" disabled
                                               value="<?php echo $boq_item->code; ?>">
                                    </td>
                                    <td class="table-cell w35">
                                        <input name="boq[<?php echo $boq_item->id; ?>][name]" onclick="hesaplaT"
                                               style="width: 100%" disabled
                                               value="<?php echo $boq_item->name; ?>">
                                    </td>
                                    <td class="table-cell w5">
                                        <input name="boq[<?php echo $boq_item->id; ?>][unit]" onclick="hesaplaT"
                                               style="width: 100%" disabled
                                               value="<?php echo $boq_item->unit; ?>">
                                    </td>
                                    <td class="table-cell w10">
                                        <input name="boq[<?php echo $boq_item->id; ?>][qty]" onclick="hesaplaT"
                                               id="q-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                               value="<?php echo $boq_item->qty; ?>">
                                    </td>
                                    <td class="table-cell w15">
                                        <input name="boq[<?php echo $boq_item->id; ?>][price]" onclick="hesaplaT"
                                               disabled
                                               id="p-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                               value="<?php echo $boq_item->price; ?>">
                                    </td>
                                    <td class="table-cell w15">
                                        <input name="boq[<?php echo $boq_item->id; ?>][total]" onclick="hesaplaT"
                                               id="t-<?php echo $boq_item->id; ?>" style="width: 100%" type="number"
                                               value="<?php echo $boq_item->total; ?>">
                                    </td>
                                    <td class="table-cell w5">
                                        <a onclick="" id="<?php echo $boq_item->id; ?>">
                                            <i style="color: tomato" class="fa fa-minus-circle fa-2x"
                                               aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5">
                                    <h6>TOPLAM</h6>
                                </td>
                                <td class="w10">
                                    <input type="number" disabled style="width: 100%"
                                           value="<?php echo sum_anything("contract_price", "total", "sub_id", "$sub_group->id"); ?>">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">İmalat Kalemi Seç</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tümünü Seç Butonu -->
                    <button type="button" class="btn btn-sm btn-secondary mb-2" id="selectAllBtn">Tümünü Seç</button>

                    <input type="text" id="searchInput" class="form-control" placeholder="Kalem ara...">
                    <div id="imalatKalemList" class="mt-3">
                        <!-- PHP ile imalat kalemleri listelenecek -->
                        <div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Poz No</th>
                                    <th>İmalat Adı</th>
                                    <th>Birimi</th>
                                    <th>Birim Fiyat</th>
                                </tr>
                                </thead>
                                <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($leaders as $leader): ?>

                                    <tr>
                                        <td><input type="checkbox" name="leaders[]" value="<?php echo $leader->id; ?>"></td>
                                        <td><?php echo $leader->code; ?></td>
                                        <td style="text-align: left"><?php echo $leader->name; ?></td>
                                        <td><?php echo $leader->unit; ?></td>
                                        <td><?php echo $leader->price; ?> <?php echo $item->para_birimi; ?></td>
                                    </tr>
                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveSelection()">Seçimleri Kaydet</button>
                </div>
            </div>
        </div>
    </div>

</div>