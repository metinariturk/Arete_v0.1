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

<?php $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet";

// Klasördeki tüm dosya ve klasörleri alıyoruz
$files = scandir($file_path);

// '.' ve '..' gibi klasörleri filtreleyip sadece dosya isimlerini almak için array_filter kullanıyoruz
$files = array_filter($files, function ($file) use ($file_path) {
    return !is_dir($file_path . '/' . $file); // Klasörleri dahil etmiyoruz, sadece dosyalar
});

// Dosya isimlerini uzantıları olmadan yeni bir diziye alıyoruz
$file_names_without_extension = array_map(function ($file) {
    return pathinfo($file, PATHINFO_FILENAME); // Sadece dosya adını (uzantısız) alıyoruz
}, $files);
?>

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
                          data-form-url="<?php echo base_url("$this->Module_Name/add_expense/$item->id"); ?>"
                          method="post" enctype="multipart/form-data" autocomplete="off">
                        <!-- Tarih -->
                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Çıkış Tarihi</label>
                            <input type="date" name="expense_date" id="expense_date"
                                   value="<?php echo date(set_value('expense_date')); ?>"
                                   class="form-control <?php cms_isset(form_error("expense_date"), "is-invalid", ""); ?>">
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
                            <input id="expense_notes" type="text"
                                   class="form-control <?php cms_isset(form_error("expense_notes"), "is-invalid", ""); ?>"
                                   name="expense_notes" value="<?php echo set_value('expense_notes'); ?>"
                                   placeholder="Açıklama">
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error('expense_notes'); ?></div>
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
        <div class="col-md-8">
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <h5>Harcama Listesi</h5>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table id="expensesTable" style="width:100%">
                    <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Açıklama</th>
                        <th>Miktar</th>
                        <th>Ödeme Türü</th>
                        <th>Düzenle</th>
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
                            <td style="text-align: center">
                                <a data-bs-toggle="modal" class="text-primary"
                                   onclick="edit_modal_form('<?php echo base_url("Site/open_edit_expenses_modal/$expense->id"); ?>','edit_expense_modal','EditExpenseModal')">
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>
                            </td>
                            <td style="text-align: center">
                                <?php
                                $file_path = "$this->File_Dir_Prefix/$project->project_code/$item->dosya_no/Sitewallet/$expense->id";

                                if (!is_dir($file_path)) {
                                    mkdir($file_path, 0777, true);
                                }

                                $files = glob("$file_path/*"); // glob ile tüm dosyaları al
                                ?>
                                <a href="<?php echo base_url("$this->Module_Name/download_all_expense/$expense->id"); ?>">
                                    <i class="fa fa-download fa-lg"></i>(<?php echo count($files); ?>)
                                </a>
                            </td>
                            <td style="text-align: center">
                                <a href="javascript:void(0);"
                                   onclick="confirmDelete('<?php echo base_url("Site/delete_sitewallet/$expense->id"); ?>', '#tab_expenses','expensesTable')"
                                   title="Sil">
                                    <i class="fa fa-trash-o fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
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

<div id="edit_expense_modal">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/edit_expense_modal_form"); ?>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // PHP'den alınan harcama verisini JavaScript'te kullanmak için
        var monthlyExpenses = <?php echo json_encode($monthly_expenses); ?>;

        // Grafik verilerini hazırlama
        var labels = Object.keys(monthlyExpenses); // Aylar
        var data = Object.values(monthlyExpenses); // Toplam harcamalar

        // Her çubuk için farklı renkler tanımlama
        var colors = [
            'rgba(75, 192, 192, 0.2)', // Ocak
            'rgba(255, 99, 132, 0.2)', // Şubat
            'rgba(255, 206, 86, 0.2)', // Mart
            'rgba(75, 192, 192, 0.2)', // Nisan
            'rgba(54, 162, 235, 0.2)', // Mayıs
            'rgba(153, 102, 255, 0.2)', // Haziran
            'rgba(255, 159, 64, 0.2)', // Temmuz
            'rgba(255, 99, 132, 0.2)', // Ağustos
            'rgba(75, 192, 192, 0.2)', // Eylül
            'rgba(255, 206, 86, 0.2)', // Ekim
            'rgba(54, 162, 235, 0.2)', // Kasım
            'rgba(153, 102, 255, 0.2)'  // Aralık
        ];

        // Grafik oluşturma
        var ctx = document.getElementById('expenseChart').getContext('2d');
        var expenseChart = new Chart(ctx, {
            type: 'bar', // Çubuk grafik
            data: {
                labels: labels,
                datasets: [{
                    label: 'Aylık Harcama (TL)',
                    data: data,
                    backgroundColor: colors.slice(0, data.length), // Her çubuğa farklı renk
                    borderColor: colors.slice(0, data.length).map(color => color.replace('0.2', '1')), // Kenar rengi
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>


