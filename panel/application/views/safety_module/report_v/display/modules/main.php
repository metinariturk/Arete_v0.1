<div class="row">
    <div class="text-center"><h3><?php echo site_name($site_id); ?><br>Günlük Rapor Formu</h3></div>
</div>
<hr>
<table class="table" >
    <tbody class="bg-color-op-orange">
    <tr>
        <td style="width: 150px"><strong>Şantiye Adı</strong></td>
        <td><?php echo $site_code . " / " . site_name($site_id); ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Proje Kodu/Adı</strong></td>
        <td><?php echo project_code_name($proje_id); ?></td>
    </tr>
    <?php if (!empty($contract_id)) { ?>
        <tr>
            <td style="width: 150px"><strong>Sözleşme Kodu/Adı</strong></td>
            <td><?php echo contract_code($contract_id); ?> / <?php echo contract_name($contract_id); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td style="width: 150px"><strong>Rapor Tarihi</strong></td>
        <td><?php echo dateFormat_dmy($item->report_date); ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Hava Durumu</strong></td>

        <td>
        <?php $weathers = json_decode($item->weather); ?>
            <b>En Düşük : </b><?php echo $weathers->min_temp; ?> (°C)
            <b>En Yüksek : </b><?php echo $weathers->max_temp; ?> (°C)
            <b>Olay : </b><?php echo $weathers->event." ".weather($weathers->event); ?>
        </td>
    </tr>
    </tbody>
</table>
<hr>
