<?php if (isset($form_error) && $form_error): ?>
    <script>
        $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
        $('body').removeClass('modal-open');
        $('body').css('overflow', 'auto');
        $('#<?php echo $error_modal; ?>').modal('show');

        // DataTable kontrolü ve yeniden başlatılması
        if ($.fn.DataTable.isDataTable('#expensesTable')) {
            $('#expensesTable').DataTable().destroy(); // Mevcut tabloyu yok et
        }

        // DataTable'ı yeniden başlat
        if (!$.fn.DataTable.isDataTable('#expensesTable')) {
            $('#expensesTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                // Diğer DataTable ayarları
            });
        }
    </script>
<?php endif; ?>


<div class="card-body">
    <div class="modal fade" id="AddExpenseModal" tabindex="-1" role="dialog" aria-labelledby="AddExpenseModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Harcama</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addExpenseForm"
                          data-form-url="<?php echo base_url("$this->Module_Name/sitewallet/$item->id/1"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">

                        <!-- Tarih -->
                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Çıkış Tarihi</label>
                            <input type="date" name="expense_date" id="expense_date"
                                   value="<?php echo set_value('expense_date'); ?>"
                                   class="form-control <?php cms_isset(form_error("contract_name"), "is-invalid", ""); ?>">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error('expense_date'); ?></div>
                            <?php } ?>
                        </div>

                        <!-- Belge No -->
                        <div class="mb-3">
                            <label class="col-form-label" for="bill_code">Belge No:</label>
                            <input id="bill_code" type="text"
                                   class="form-control <?php cms_isset(form_error("bill_code"), "is-invalid", ""); ?>"
                                   name="bill_code"
                                   placeholder="Belge No">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error('bill_code'); ?></div>
                            <?php } ?>
                        </div>

                        <!-- Tutar -->
                        <div class="mb-3">
                            <label class="col-form-label" for="price">Tutar:</label>
                            <input id="price" type="number" min="0" step="any"
                                   class="form-control <?php cms_isset(form_error("price"), "is-invalid", ""); ?>"
                                   name="price"
                                   placeholder="Tutar">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error('price'); ?></div>
                            <?php } ?>
                        </div>

                        <!-- Ödeme Türü -->
                        <div class="mb-3">
                            <label class="col-form-label" for="payment_type">Ödeme Türü:</label>
                            <select id="select2-demo-1" style="width: 100%;"
                                    class="form-control <?php cms_isset(form_error("payment_type"), "is-invalid", ""); ?>"
                                    data-plugin="select2" name="payment_type">
                                <?php if (isset($form_error)) { ?>
                                    <option selected
                                            value="<?php echo set_value('payment_type'); ?>"><?php echo(set_value('payment_type')); ?></option>
                                <?php } else { ?>
                                    <option value="" disabled selected>Tür Seçiniz</option>
                                <?php } ?>
                                <!-- Dynamic site options -->
                                <option>Nakit</option>
                                <option>Havale</option>
                                <option>Kredi Kartı</option>
                                <option>Diğer</option>
                            </select>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error('payment_type'); ?></div>
                            <?php } ?>
                        </div>

                        <!-- Açıklama -->
                        <div class="mb-3">
                            <label class="col-form-label" for="payment_notes">Açıklama:</label>
                            <input id="payment_notes" type="text"
                                   class="form-control <?php cms_isset(form_error("payment_notes"), "is-invalid", ""); ?>"
                                   name="payment_notes" value="<?php echo set_value('payment_notes'); ?>"
                                   placeholder="Açıklama">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error('payment_notes'); ?></div>
                            <?php } ?>
                        </div>

                        <!-- Dosya Yükle -->
                        <div class="mb-3">
                            <label class="col-form-label" for="file-input">Dosya Yükle:</label>
                            <input class="form-control" name="file" id="file-input" type="file">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary"
                            onclick="submit_modal_form('addExpenseForm', 'AddExpenseModal', 'tab_expenses', 'expensesTable')">
                        Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <h5>Harcama Listesi</h5>
                </div>
            </div>
            <hr>

            <table id="expensesTable" style="width:100%">
                <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Harcama Adı</th>
                    <th>Miktar</th>
                    <th>Harcama Türü</th>
                    <th>İndir</th>
                    <th>Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($all_expenses as $expense) { ?>
                    <tr>
                        <td><?php echo dateFormat_dmy($expense->date); ?></td>
                        <td><?php echo $expense->note; ?></td>
                        <td><?php echo money_format($expense->price); ?><?php echo $contract->para_birimi; ?></td>
                        <td><?php echo $expense->payment_type; ?></td>
                        <td>
                            <a href="<?php echo base_url("$this->Module_Name/expense_download/$expense->id"); ?>">
                                <i class="fa fa-download f-14 ellips"></i>
                            </a>
                        </td>
                        <td>
                            <a onclick="deleteExpenseFile(this)"
                               url="<?php echo base_url("site/expense_delete/$expense->id"); ?>"
                            <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                               aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <?php
            $monthly_expenses = [];
            $i = 1; // Satır numarası için sayaç

            // Harcamaları aylara göre gruplama
            foreach ($all_expenses as $expense) {
                $month = date('Y-m', strtotime($expense->date)); // Yıl ve ay bilgisi
                $price = $expense->price; // Fiyatı float'a çevirme

                // Eğer ay dizide yoksa başlat
                if (!isset($monthly_expenses[$month])) {
                    $monthly_expenses[$month] = 0;
                }

                // Ayın toplamını güncelle
                $monthly_expenses[$month] += $price;
            }

            $chart_expense = json_encode($monthly_expenses);


            ?>

            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <h5>Aylık Harcama Dağılımı</h5>
                </div>
            </div>
            <hr>

            <div class="container mt-5">
                <canvas id="expenseChart"></canvas>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Ay</th>
                    <th>Toplam Harcama (<?php echo $contract->para_birimi; ?>)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($monthly_expenses as $month => $total): ?>
                    <tr>
                        <td><?php echo YM_to_M($month); ?></td>
                        <td><?php echo money_format($total); ?><?php echo $contract->para_birimi; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>TOPLAM</td>
                    <td><?php echo money_format($total_expense); ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
