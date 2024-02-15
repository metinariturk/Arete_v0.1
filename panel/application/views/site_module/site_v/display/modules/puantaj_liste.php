<?php
echo validation_errors();
?>
<?php
$i = 1;
foreach ($personel_datas as $personel_data) { ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Adı Soyadı</th>
                <th scope="col">1</th>
                <th scope="col">2</th>
                <th scope="col">3</th>
                <th scope="col">4</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <th scope="col">5</th>
                <!-- Buraya diğer sütun başlıkları eklenebilir -->
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row"> <?php echo $i++; ?></th>
                <th scope="row"> <?php echo $personel_data->name_surname; ?></th>

                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                    </div>
                </td>
                <td>Veri 2</td>
                <!-- Buraya diğer hücre verileri eklenebilir -->
            </tr>
            <!-- Diğer satırlar da buraya eklenebilir -->
            </tbody>
        </table>
    </div>


<?php } ?>