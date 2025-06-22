<div class="row g-3 align-items-start">
    <div class="col-lg-8 col-md-12">
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Şantiye Seçimi</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($active_sites) && is_array($active_sites)) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Dosya No</th>
                                <th>Şantiye Adı</th>
                                <th>Durum</th>
                                <th>Konum</th>
                            </tr>
                            </thead>
                            <tbody id="site-selection-table-body">
                            <?php foreach ($active_sites as $site_data) { ?>
                                <tr class="clickable-site-row"
                                    data-site-id="<?php echo htmlspecialchars($site_data->id); ?>">
                                    <td><?php echo htmlspecialchars(mb_strtoupper($site_data->dosya_no)); ?></td>
                                    <td><?php echo htmlspecialchars($site_data->santiye_ad); ?></td>
                                    <td>
                                        <?php
                                        $status_text = '';
                                        $status_class = '';
                                        if ($site_data->isActive == 1) {
                                            $status_text = 'Aktif';
                                            $status_class = 'badge bg-success';
                                        } else {
                                            $status_text = 'Pasif';
                                            $status_class = 'badge bg-danger';
                                        }
                                        ?>
                                        <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($site_data->location); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info" role="alert">
                        Gösterilecek şantiye bulunamadı.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>


