<div class="card mb-3 shadow-sm">
    <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0 fw-bold">Çalışan Makineler</h5>
    </div>
    <div class="card-body p-0"> <?php if (!empty($workmachines)) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th class="text-center py-2" style="width:10%;">Makine Adı</th>
                        <th class="text-center py-2" style="width:10%;">Sayısı</th>
                        <th class="text-center py-2" style="width:20%;">Çalıştığı Mahal</th>
                        <th class="text-center py-2" style="width:60%;">Açıklama</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($workmachines as $workmachine) { ?>
                        <tr>
                            <td class="text-start py-2"><?php echo machine_name($workmachine->workmachine); ?></td>
                            <td class="text-center py-2"><?php echo $workmachine->number; ?></td>
                            <td class="text-start py-2"><?php echo yazim_duzen($workmachine->place); ?></td>
                            <td class="text-start py-2"><?php echo yazim_duzen($workmachine->notes); ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="table-active">
                        <td class="text-center fw-bold py-2">TOPLAM</td>
                        <td class="text-center fw-bold py-2">
                            <?php echo $this->Report_workmachine_model->sum_all(array("report_id" => $item->id), "number"); ?>
                        </td>
                        <td colspan="2" class="text-start py-2"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="p-4 text-center text-muted">
                <i class="fas fa-robot me-2"></i> Makine Çalışması Yok.
            </div>
        <?php } ?>
    </div>
</div>