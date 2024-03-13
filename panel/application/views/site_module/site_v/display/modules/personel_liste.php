<?php
echo validation_errors();
?>

<div class="row">
    <div class="col-12">
        <div>
            <h3 class="text-center">
                Personel Listesi
            </h3>
            <table style="border-collapse: collapse; width: 100%;">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Adı Soyadı</th>
                    <th>TC Kimlik No</th>
                    <th>Branş</th>
                    <th>İşe Giriş/Çıkış</th>
                    <th>Hesap No</th>
                    <th>Banka</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                foreach ($personel_datas as $personel_data) { ?>
                    <tr style="height: 30px; border: 1px solid black;">
                        <td style="border: 1px solid black;"> <?php echo $i++; ?></td>
                        <td style="border: 1px solid black;"> <?php echo $personel_data->name_surname; ?></td>
                        <td style="border: 1px solid black;"> <?php echo $personel_data->social_id; ?></td>
                        <td style="border: 1px solid black;"> <?php echo group_name($personel_data->group); ?></td>
                        <td style="border: 1px solid black;">
                            <?php echo dateFormat_dmy($personel_data->start_date); ?> /
                            <?php if (!empty($personel_data->end_date)) { ?>
                                <?php echo dateFormat_dmy($personel_data->end_date); ?>
                            <?php } else { ?>
                                Çalışıyor
                            <?php } ?>
                        </td>
                        <td style="border: 1px solid black;"> <?php echo $personel_data->IBAN; ?> </td>
                        <td style="border: 1px solid black;"> <?php echo $personel_data->bank; ?> </td>
                        <td style="border: 1px solid black;">
                            <i class="fa fa-edit" name="personel_id"
                               onclick="updatePersonelForm(this)"
                               workerid="<?php echo $personel_data->id; ?>"></i>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

