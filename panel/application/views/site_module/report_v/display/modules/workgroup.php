<?php if (!empty($workgroups)) { ?>
    <div class="content">
        <table style="width:100%;">
            <thead>
            <tr>
                <th colspan="4">
                    <p style="font-size:15pt;">
                        <strong>Çalışan Ekipler</strong></p>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width:10%; background-color:#e7e7e7; text-align: center">
                    <p><strong>Ekip Adı</strong></p>
                </td>
                <td style="width:10%; background-color:#e7e7e7; text-align: center">
                    <p><strong>Sayısı</strong></p>
                </td>
                <td style="width:20%; background-color:#e7e7e7; text-align: center">
                    <p><strong>Çalıştığı Mahal</strong></p>
                </td>
                <td style="width:70%; background-color:#e7e7e7; text-align: center">
                    <p><strong>Açıklama</strong></p>
                </td>
            </tr>
            <?php foreach ($workgroups as $workgroup) { ?>
                <tr>
                    <td class="total-group-row-left">
                        <?php echo group_name($workgroup->workgroup); ?>
                    </td>
                    <td class="total-group-row-center">
                        <?php echo $workgroup->number; ?>
                    </td>
                    <td class="total-group-row-left">
                        <?php echo yazim_duzen($workgroup->place); ?>
                    </td>
                    <td class="total-group-row-left">
                        <?php echo yazim_duzen($workgroup->notes); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td class="w-3 total-group-row-center">
                    <p><strong>TOPLAM</strong></p>
                </td>
                <td class="total-group-row-center">
                    <strong><?php echo $this->Report_workgroup_model->sum_all(array("report_id" => $item->id), "number"); ?></strong>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="content">
        <table style="width:100%;">
            <thead>
            <tr>
                <th colspan="4">
                    <p style="font-size:15pt;">
                        <strong>Ekip Çalışması Yok</strong></p>
                </th>
            </tr>
            </thead>
        </table>
    </div>
<?php } ?>


