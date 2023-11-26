<?php if (!empty($workmachines)) { ?>
    <div class="content">
        <div class="card-body">
            <table style="width:100%;">
                <thead>
                <tr>
                    <th colspan="4">
                        <p style="font-size:15pt;">
                            <strong>Çalışan Makineler</strong></p>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width:10%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Makine Adı</strong></p>
                    </td>
                    <td style="width:10%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Sayısı</strong></p>
                    </td>
                    <td style="width:20%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Çalıştığı Mahal</strong></p>
                    </td>
                    <td style="width:60%; background-color:#e7e7e7; text-align: center">
                        <p><strong>Açıklama</strong></p>
                    </td>
                </tr>
                <?php foreach ($workmachines as $workmachine) { ?>
                    <tr>
                        <td class="total-group-row-left">
                            <?php echo machine_name($workmachine->workmachine); ?>
                        </td>
                        <td class="total-group-row-center">
                            <?php echo $workmachine->number; ?>
                        </td>
                        <td class="total-group-row-left">
                            <?php echo yazim_duzen($workmachine->place); ?>
                        </td>
                        <td class="total-group-row-left">
                            <?php echo yazim_duzen($workmachine->notes); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="w-3 total-group-row-center">
                        <p><strong>TOPLAM</strong></p>
                    </td>
                    <td class="total-group-row-center">
                        <strong><?php echo $this->Report_workmachine_model->sum_all(array("report_id" => $item->id), "number"); ?></strong>
                    </td>
                </tr>
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
                            <strong>Makine Çalışması Yok</strong></p>
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
<?php } ?>


