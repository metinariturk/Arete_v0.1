<?php
echo validation_errors();
?>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Adı Soyadı</th>
            <?php for ($j = 1; $j <= 29; $j++): ?>
                <th scope="col"><?php echo $j; ?></th>
            <?php endfor; ?>
            <!-- Buraya diğer sütun başlıkları eklenebilir -->
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $count_of_days = get_days_in_month(2024, 2);
        $month =  date('n');
        $year = date('Y');
        foreach ($personel_datas as $personel_data) { ?>
            <tr>
                <th scope="row"> <?php echo $i++; ?></th>
                <th scope="row"> <?php echo $personel_data->name_surname; ?></th>
                <?php for ($j = 1; $j <= 29; $j++): ?>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" onclick="send_puantaj(this)"
                                   worker-id = "<?php echo $personel_data->id; ?>"
                                   date = "$j-$month-$year"
                                   data-url = "<?php echo base_url("site/update_puantaj/$item->id/"); ?>">
                        </div>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script>
    function send_puantaj(checkbox) {
        if (checkbox.checked) {
            var workerId = $(checkbox).attr('worker-id');
            var date = $(checkbox).attr('date');
            var url = $(checkbox).attr('data-url');

            // Verileri topladık, şimdi HTTP isteği gönderelim
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify({ workerId: workerId, date: date }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Veri başarıyla gönderildi.');
                },
                error: function(xhr, status, error) {
                    console.error('Veri gönderilirken bir hata oluştu:', error);
                }
            });
        }
    }
</script>