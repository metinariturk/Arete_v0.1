<?php if (!empty($supplies)) { ?>
    <div class="content">
        <div class="card-body">
            <table style="width:100%;">
                <thead>
                <tr>
                    <th colspan="4">
                        <p style="font-size:15pt;">
                            <strong>Gelen Malzemeler</strong></p>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width:30%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Malzeme Adı</strong></p>
                    </td>
                    <td style="width:10%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Miktar</strong></p>
                    </td>
                    <td style="width:10%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Birim</strong></p>
                    </td>
                    <td style="width:50%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Açıklama</strong></p>
                    </td>
                </tr>
                <?php foreach ($supplies as $supply) { ?>
                    <tr>
                        <td class="total-group-row-left">
                            <?php echo $supply->supply; ?>
                        </td>
                        <td class="total-group-row-center">
                            <?php echo $supply->qty; ?>
                        </td>
                        <td class="total-group-row-center">
                            <?php echo yazim_duzen($supply->unit); ?>
                        </td>
                        <td class="total-group-row-left">
                            <?php echo yazim_duzen($supply->notes); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <div class="content">
        <div class="card-body">
            <table style="width:100%;">
                <thead>
                <tr>
                    <th colspan="4">
                        <p style="font-size:15pt;">
                            <strong>Gelen Malzeme Yok</strong></p>
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
<?php } ?>


