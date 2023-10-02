
<table class="table tablecenter">
    <tbody class="bg-color-op-blue">
    <?php $workgroups = json_decode($item->workgroup); ?>
    <?php if ($workgroups != null) { ?>
    <tr>
        <th style="width: 150px"><strong>#</strong></th>
        <th>
            <div class="row">
                <div class="col-sm-3">
                    <b>Ekip/Makine</b>
                </div>
                <div class="col-sm-2">
                    <b>Çalışan Sayısı</b>
                </div>
                <div class="col-sm-2">
                    <b>Çalışılan Mahal</b>
                </div>
                <div class="col-sm-5">
                    <b>Yaptığı İş</b>
                </div>
            </div>
        </th>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Çalışan Ekipler</strong></td>
        <td><?php foreach ($workgroups as $workgroup) { ?>
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo group_name($workgroup->workgroup); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo $workgroup->worker_count; ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo yazim_duzen($workgroup->place); ?>
                    </div>
                    <div class="col-sm-5">
                        <?php echo yazim_duzen($workgroup->notes); ?>
                    </div>
                </div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Toplam Çalışan</strong></td>
        <td><?php $workgroups = json_decode($item->workgroup); ?>
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-2">
                    <b><?php echo $sum = array_sum(array_column($workgroups, "worker_count")); ?></b>
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-5">
                </div>
            </div>

        </td>
    </tr>
    </tbody>
    <?php } else { ?>
        <tr>
            <td style="width: 150px"><strong>Ekip Çalışması</strong></td>
            <td>
                Ekip Çalışması Yok
            </td>
        </tr>
        </tbody>
    <?php } ?>
</table>