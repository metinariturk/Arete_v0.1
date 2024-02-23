<?php
echo validation_errors();
?>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <h3 class="text-center">
                <?php
                $month = date('n');
                $year = date('Y');
                echo ay_isimleri($month) . " - " . $year;
                ?>
            </h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Adı Soyadı</th>
                    <th>TC Kimlik No</th>
                    <th>İşe Giriş</th>
                    <th>Çıkış Tarihi</th>
                    <th>Hesap No</th>
                    <th>Banka</th>
                    <th>Durumu</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $count_of_days = get_days_in_month($year, $month);
                foreach ($personel_datas as $personel_data) { ?>
                    <tr>
                        <td> <?php echo $i++; ?></td>
                        <td> <input disabled id="<?php echo $personel_data->id; ?>_name_surname" value="<?php echo $personel_data->name_surname; ?>" class="form-control"></td>
                        <td> <input disabled id="<?php echo $personel_data->id; ?>_social_id" type="number" value="<?php echo $personel_data->social_id; ?>" class="form-control"></td>
                        <td>
                            <input class="datepicker-here form-control digits"
                                   type="text"
                                   name="start_date" disabled id="<?php echo $personel_data->id; ?>_start_date"
                                   value="<?php echo dateFormat_dmy($personel_data->start_date); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                        </td>
                        <td>
                            <input class="datepicker-here form-control digits"
                                   type="text"
                                   name="start_date" disabled id="<?php echo $personel_data->id; ?>_end_date"
                                   value="<?php echo dateFormat_dmy($personel_data->end_date); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                        </td>
                        <td><input value="<?php echo $personel_data->IBAN; ?>" disabled id="<?php echo $personel_data->id; ?>_IBAN" class="form-control">
                        <td> <?php echo $personel_data->isActive; ?></td>
                        <td> Cehckbox </td>
                        <td> <button id="<?php echo $personel_data->id; ?>">Düzenle / Kaydet</button> </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Belirli bir satırdaki input değerlerini alarak POST isteği gönderen fonksiyon
    function sendData(id) {
        // Belirli satırdaki inputların değerlerini al
        var name_surname = document.getElementById(id + "_name_surname").value;
        var social_id = document.getElementById(id + "_social_id").value;
        var start_date = document.getElementById(id + "_start_date").value;
        var end_date = document.getElementById(id + "_end_date").value;
        var IBAN = document.getElementById(id + "_IBAN").value;

        // POST isteği için bir JavaScript nesnesi oluştur
        var data = {
            id: id,
            name_surname: name_surname,
            social_id: social_id,
            start_date: start_date,
            end_date: end_date,
            IBAN: IBAN
        };

        // POST isteği gönder
        fetch('your_post_url_here', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                // Yanıtı kontrol et
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
</script>
