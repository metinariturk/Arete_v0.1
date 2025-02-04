<?php
$boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $edit_pricegroup->id), "code ASC");
$boq_leader_ids = array_map(function ($item) {
    return $item->leader_id;
}, $boq_items);
?>
<table class="table table-bordered">
    <thead>
    <tr>
        <!-- Ana checkbox için PHP kontrolü -->
        <th>
            <input type="checkbox" id="selectAllCheck" <?php echo (count($boq_leader_ids) === count($leaders)) ? 'checked' : ''; ?> onclick="check_all(this)" />
        </th>
        <th>Kod</th>
        <th>Ad</th>
        <th>Birim</th>
        <th>Fiyat</th>
    </tr>
    </thead>
    <tbody id="list-group">


    <?php foreach ($leaders as $leader) {
        $isChecked = in_array($leader->id, $boq_leader_ids) ? 'checked' : '';
        ?>
        <tr class="leader-item">
            <td>
                <input class="form-check-input" type="checkbox" name="leaders[]"
                       value="<?php echo $leader->id; ?>" <?php echo $isChecked; ?>
                       onclick="check_select_all_status()">
            </td>
            <td><?php echo $leader->code; ?></td>
            <td><?php echo $leader->name; ?></td>
            <td><?php echo $leader->unit; ?></td>
            <td><?php echo money_format($leader->price) . " - " . $item->para_birimi; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    // check_all fonksiyonu - Tüm kutucukları işaretler/kaldırır
    function check_all(selectAllCheckbox) {
        document.querySelectorAll('input[name="leaders[]"]').forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
        updateSelectAllStatus();
    }

    // check_select_all_status fonksiyonu - Ana kutucuğun durumunu kontrol eder
    function updateSelectAllStatus() {
        const checkboxes = document.querySelectorAll('input[name="leaders[]"]');
        const selectAllCheckbox = document.getElementById('selectAllCheck');
        selectAllCheckbox.checked = [...checkboxes].every(checkbox => checkbox.checked);
    }

    // Sayfa yüklendiğinde, checkbox durumunu kontrol et
    document.addEventListener('DOMContentLoaded', updateSelectAllStatus);
</script>