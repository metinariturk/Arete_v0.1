
<div id="expense_modal_form">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/add_expense_form"); ?>
</div>

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
