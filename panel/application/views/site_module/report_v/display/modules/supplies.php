<div class="card mb-3 shadow-sm">
    <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0 fw-bold">Gelen Malzemeler</h5>
    </div>
    <div class="card-body p-0"> <?php if (!empty($supplies)) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th class="text-center py-2" style="width:30%;">Malzeme Adı</th>
                        <th class="text-center py-2" style="width:10%;">Miktar</th>
                        <th class="text-center py-2" style="width:10%;">Birim</th>
                        <th class="text-center py-2" style="width:50%;">Açıklama</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($supplies as $supply) { ?>
                        <tr>
                            <td class="text-start py-2"><?php echo $supply->supply; ?></td>
                            <td class="text-center py-2"><?php echo $supply->qty; ?></td>
                            <td class="text-center py-2"><?php echo yazim_duzen($supply->unit); ?></td>
                            <td class="text-start py-2"><?php echo yazim_duzen($supply->notes); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="p-4 text-center text-muted">
                <i class="fas fa-boxes me-2"></i> Gelen Malzeme Yok.
            </div>
        <?php } ?>
    </div>
</div>