
<table class="table tablecenter">
    <tbody class="bg-color-op-green">
    <?php $workmachines = json_decode($item->workmachine); ?>
    <?php if ($workmachines != null) { ?>
    <tr>
        <th style="width: 150px"><strong>#</strong></th>
        <th style="width: 20px"><strong>&nbsp;</strong></th>
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
        <td style="width: 150px"><strong>Çalışan Makineler</strong></td>
        <td style="width: 20px"><strong></strong></td>
        <td>
            <?php foreach ($workmachines as $workmachine) { ?>
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo machine_name($workmachine->workmachine); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo $workmachine->machine_count; ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo yazim_duzen($workmachine->machine_place); ?>
                    </div>
                    <div class="col-sm-5">
                        <?php echo yazim_duzen($workmachine->machine_notes); ?>
                    </div>
                </div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Toplam Çalışan</strong></td>
        <td style="width: 20px"><strong></strong></td>
        <td><?php $workmachines = json_decode($item->workmachine); ?>

            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-2">
                    <b><?php echo $sum = array_sum(array_column($workmachines, "machine_count")); ?></b>
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
            <td style="width: 150px"><strong>Makine Çalışması</strong></td>
            <td>
                Makine Çalışması Yok
            </td>
        </tr>
        </tbody>
    <?php } ?>
</table>
