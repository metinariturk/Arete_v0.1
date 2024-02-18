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
                            <input type="checkbox" onclick="save_puantaj(puantaj_form)"
                                   worker-id = "<?php echo $personel_data->id; ?>"
                                   date = "$j-$month-$year"
                            >
                        </div>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
