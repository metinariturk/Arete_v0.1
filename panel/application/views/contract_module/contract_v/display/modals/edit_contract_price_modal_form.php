<?php if (isset($edit_contract_price)) { ?>

    <div class="modal fade" id="EditContractPriceModal" tabindex="-1" aria-labelledby="EditContractPriceModallLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditContractPriceModallLabel"><?php echo $edit_contract_price->name; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContractPriceForm" data-form-url="<?php echo base_url("$this->Module_Name/edit_contract_price/$edit_contract_price->id"); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                        <h5 class="modal-title" id="EditContractPriceModallLabel">Alt İş Grubuna Poz Ekle/Çıkar</h5>
                        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Poz Ara...">

                        <!-- Tablo Başlıkları -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAllCheck" /></th>
                                <th>Kod</th>
                                <th>Ad</th>
                                <th>Birim</th>
                                <th>Fiyat</th>
                            </tr>
                            </thead>
                            <tbody id="list-group">
                            <?php
                            // BOQ item'larını çekiyoruz
                            $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "code ASC");

                            // BOQ item'larının leader_id'lerini bir diziye alalım
                            $boq_leader_ids = array_map(function ($item) {
                                return $item->leader_id;
                            }, $boq_items);
                            ?>

                            <?php foreach ($leaders as $leader) {
                                // Eğer $leader->id, $boq_leader_ids dizisinde varsa checkbox'ı işaretli yapalım
                                $isChecked = in_array($leader->id, $boq_leader_ids) ? 'checked' : '';
                                ?>

                                <tr class="leader-item">
                                    <td>
                                        <input class="form-check-input" type="checkbox" name="leaders[]" value="<?php echo $leader->id; ?>" <?php echo $isChecked; ?>>
                                    </td>
                                    <td><?php echo $leader->code; ?></td>
                                    <td><?php echo $leader->name; ?></td>
                                    <td><?php echo $leader->unit; ?></td>
                                    <td><?php echo money_format($leader->price). " - " . $contract->para_birimi; ?></td>
                                </tr>

                            <?php } ?>
                            </tbody>
                        </table>
                    </form>

                    <!-- JavaScript kodu ile arama ve seçim işlevselliği -->
                    <script>
                        $(document).ready(function () {
                            // Arama input'u ile filtreleme işlemi
                            $('#searchInput').on('keyup', function () {
                                var query = $(this).val().toLowerCase();  // Kullanıcının girdiği değeri al
                                $('.leader-item').each(function () {
                                    var pozText = $(this).find('td').text().toLowerCase(); // Poz isimlerini al
                                    if (pozText.includes(query)) {
                                        $(this).show();  // Poz adı arama sorgusuyla uyuyorsa göster
                                    } else {
                                        $(this).hide();  // Uymuyorsa gizle
                                    }
                                });
                            });

                            // Sayfa yüklendiğinde tüm pozları göster
                            $('.leader-item').show();

                            // Tümünü Seç butonunun işlevi
                            $('#selectAllButton').on('click', function() {
                                $('.leader-item:visible').find('.form-check-input').prop('checked', true);  // Yalnızca görünür checkbox'ları işaretle
                            });

                            // Tüm Seçimleri İptal Et butonunun işlevi
                            $('#deselectAllButton').on('click', function() {
                                $('.leader-item:visible').find('.form-check-input').prop('checked', false);  // Yalnızca görünür checkbox'ların işaretini kaldır
                            });

                            // Select All checkbox işlevi
                            $('#selectAllCheck').on('click', function() {
                                $('.leader-item:visible').find('.form-check-input').prop('checked', this.checked);  // Yalnızca görünür checkbox'ları işaretle veya iptal et
                            });
                        });

                    </script>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
