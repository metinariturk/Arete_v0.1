<table class="table-sm">
    <thead>
    <tr>
        <th>Grup Adı</th>
    </tr>
    </thead>
    <tbody>
    <?php $active_boqs = json_decode($contract->active_boq, true); ?>
    <?php foreach ($active_boqs as $boq_group => $boqs) { ?>
        <tr>
            <td style="">
                <a onclick="renderGroup(this)"
                   class="me-3" href="#" style="width: 250px;"
                   data-bs-original-title=""
                   title=""
                   url="<?php echo base_url("$this->Module_Name/select_group/$contract->id/$payment_no/$boq_group"); ?>">
                    <span style="text-align: left"><?php echo boq_name($boq_group); ?></span>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>