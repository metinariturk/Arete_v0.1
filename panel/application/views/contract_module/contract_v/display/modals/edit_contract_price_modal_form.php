<script>
    $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
    $('body').removeClass('modal-open');
    $('body').css('overflow', 'auto');
</script>

<?php if (isset($edit_contract_price)) { ?>
    <div class="modal fade" id="EditContractPriceModal" tabindex="-1" aria-labelledby="EditContractPriceModallLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditContractPriceModallLabel"><?php echo $edit_contract_price->name; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContractPriceForm" data-form-url="<?php echo base_url("$this->Module_Name/update_leader_selection/$edit_contract_price->id"); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
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
                            $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $edit_contract_price->id), "code ASC");
                            $boq_leader_ids = array_map(function ($item) {
                                return $item->leader_id;
                            }, $boq_items);
                            ?>

                            <?php foreach ($leaders as $leader) {
                                $isChecked = in_array($leader->id, $boq_leader_ids) ? 'checked' : '';
                                ?>
                                <tr class="leader-item">
                                    <td>
                                        <input class="form-check-input" type="checkbox" name="leaders[]" value="<?php echo $leader->id; ?>" <?php echo $isChecked; ?>>
                                    </td>
                                    <td><?php echo $leader->code; ?></td>
                                    <td><?php echo $leader->name; ?></td>
                                    <td><?php echo $leader->unit; ?></td>
                                    <td><?php echo money_format($leader->price). " - " . $item->para_birimi; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </form>

                    <!-- JavaScript kodu ile arama ve seçim işlevselliği -->
                    <script>
                        $(document).ready(function () {
                            $('#searchInput').on('keyup', function () {
                                var query = $(this).val().toLowerCase();
                                $('.leader-item').each(function () {
                                    var pozText = $(this).find('td').text().toLowerCase();
                                    if (pozText.includes(query)) {
                                        $(this).show();
                                    } else {
                                        $(this).hide();
                                    }
                                });
                            });

                            $('.leader-item').show();

                            $('#selectAllCheck').on('click', function() {
                                $('.leader-item:visible').find('.form-check-input').prop('checked', this.checked);
                            });

                            $('#saveButton').click(function() {
                                $.ajax({
                                    url: $('#editContractPriceForm').data('form-url'),
                                    type: 'POST',
                                    data: $('#editContractPriceForm').serialize(),
                                    success: function(response) {
                                        $('#EditContractPriceModal').modal('hide');
                                        $('#tab_contract_price').html(response); // response ile div'i güncelle
                                    },
                                    error: function() {
                                        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                                    }
                                });
                            });
                        });
                    </script>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button class="btn btn-primary" id="saveButton" type="button">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
