<div class="container">
    <h1 class="text-center">Finans Takibi</h1>
    <div class="total-balance text-center">
        <p>Kasa Kalan:   <?php echo money_format($total_deposit - $total_expense); ?><?php echo $contract->para_birimi; ?></p>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Harcamalar <?php echo money_format($total_expense); ?></h2>
            <table id="expensesTable" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
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
                        <td><?php echo $i++; ?></td>
                        <td><?php echo dateFormat_dmy($expense->date); ?></td>
                        <td><?php echo $expense->note; ?></td>
                        <td><?php echo money_format($expense->price); ?> <?php echo $contract->para_birimi; ?></td>
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


            <div class="container mt-5">
                <h2>Aylık Harcamalar</h2>
                <canvas id="expenseChart"></canvas>
            </div>

            <h2>Aylara Göre Harcamalar</h2>
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
                        <td><?php echo money_format($total); ?> <?php echo $contract->para_birimi; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <h2>Alınan Avanslar  <?php echo money_format($total_deposit); ?></h2>
            <table id="advancesTable" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tarih</th>
                    <th>Açıklama</th>
                    <th>Miktar</th>
                    <th>Ödeme Türü</th>
                    <th>İndir</th>
                    <th>Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php $j=1; ?>
                <?php foreach ($all_deposites as $deposit) { ?>
                    <tr>
                        <td><?php echo $j++; ?></td>
                        <td><?php echo dateFormat_dmy($deposit->date); ?></td>
                        <td><?php echo money_format($deposit->price); ?> <?php echo $contract->para_birimi; ?></td>
                        <td><?php echo $deposit->payment_type; ?></td>
                        <td><?php echo $deposit->note; ?></td>
                        <td>
                            <a href="<?php echo base_url("$this->Module_Name/expense_download/$deposit->id"); ?>">
                                <i class="fa fa-download f-14 ellips"></i>
                            </a>
                        </td>
                        <td>
                            <a onclick="deleteDepositeFile(this)"
                               url="<?php echo base_url("site/expense_delete/$deposit->id"); ?>"
                            <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                               aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <!-- Daha fazla avans satırı ekleyebilirsiniz -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="ExpenseModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Harcama</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contract_id"
                      action="<?php echo base_url("$this->Module_Name/sitewallet/$item->id/1"); ?>"
                      method="post" enctype="multipart/form-data"
                      autocomplete="off">
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="recipient-name">Tarih:</label>
                        <input class="datepicker-here form-control digits"
                               type="text"
                               name="expense_date"
                               value="<?php echo date('d-m-Y'); ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="recipient-name">Belge
                            No:</label>
                        <input type="text" class="form-control"
                               name="bill_code" placeholder="Belge No">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="recipient-name">Tutar:</label>
                        <input type="number" min="0" step="any" class="form-control"
                               name="price" placeholder="Tutar">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="recipient-name">Ödeme
                            Türü:</label>
                        <select name="payment_type" class="form-control">
                            <option>Nakit</option>
                            <option>Havale</option>
                            <option>Kredi Kartı</option>
                            <option>Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="message-text">Açıklama:</label>
                        <input type="text" class="form-control"
                               name="payment_notes" placeholder="Açıklama">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="file-input">Dosya
                            Yükle:</label>
                        <input class="form-control" name="file" id="file-input"
                               type="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">
                    Kapat
                </button>
                <button class="btn btn-primary" form="contract_id" type="submit">
                    Kaydet
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="DepositModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Avans</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deposit"
                      action="<?php echo base_url("$this->Module_Name/sitewallet/$item->id/0"); ?>"
                      method="post" enctype="multipart/form-data"
                      autocomplete="off">
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="recipient-name">Tarih:</label>
                        <input class="datepicker-here form-control digits"
                               type="text"
                               name="expense_date"
                               value="<?php echo date('d-m-Y'); ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="recipient-name">Belge
                            No:</label>
                        <input type="text" class="form-control"
                               name="bill_code" placeholder="Belge No">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="recipient-name">Tutar:</label>
                        <input type="number" min="0" step="any" class="form-control"
                               name="price" placeholder="Tutar">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="recipient-name">Ödeme
                            Türü:</label>
                        <select name="payment_type" class="form-control">
                            <option>Nakit</option>
                            <option>Havale</option>
                            <option>Kredi Kartı</option>
                            <option>Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="message-text">Açıklama:</label>
                        <input type="text" class="form-control"
                               name="payment_notes" placeholder="Açıklama">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="file-input">Dosya
                            Yükle:</label>
                        <input class="form-control" name="file" id="file-input"
                               type="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">
                    Kapat
                </button>
                <button class="btn btn-primary" form="deposit" type="submit">Kaydet
                </button>
            </div>
        </div>
    </div>
</div>



