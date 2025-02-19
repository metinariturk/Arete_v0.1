<table class="table table-responsive-sm">
    <thead>
    <tr>
        <th>Kodu</th>
        <th>Sözleşme Adı</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($main_contracts as $main_contract) { ?>
        <tr style="background-color: #baf7c2; border-radius: 10px;">
            <td><a href="<?php echo base_url("contract/file_form/$main_contract->id"); ?>"><?php echo $main_contract->dosya_no; ?></a></td>
            <td><a href="<?php echo base_url("contract/file_form/$main_contract->id"); ?>"><?php echo $main_contract->contract_name; ?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
