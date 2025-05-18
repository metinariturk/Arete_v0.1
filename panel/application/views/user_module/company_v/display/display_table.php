<div class="container-fluid">
    <div class="row">
        <!-- Başlık Kartı -->
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-start">
                        <p class="mb-1 text-muted small"><?php echo $item->company_role; ?></p>
                        <h4 class="card-title mb-1"><?php echo full_name($item->id); ?></h4>
                        <p class="mb-1 text-secondary"><?php echo $item->profession; ?></p>
                        <p class="mb-0 fw-semibold"><?php echo $item->company_name; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- İletişim Bilgileri Kartı -->
        <div class="row mb-3">
            <!-- Adres Kartı -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-calendar"></i>&nbsp; Adres</h6>
                        <p class="mb-0">
                            <?php echo $item->adress; ?><br>
                            <?php echo city_name($item->adress_city); ?>
                            / <?php echo district_name($item->adress_district); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <!-- Email Kartı -->
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-envelope"></i> E-posta</h6>
                                <a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a>
                            </div>
                        </div>
                    </div>
                    <!-- Telefon Kartı -->
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-phone"></i> Telefon</h6>
                                <a href="tel:+90<?php echo $item->phone; ?>"><?php echo formatPhoneNumber($item->phone); ?></a>
                                <?php if (!empty($item->phone)) { ?>
                                    <a href="https://wa.me/+90<?php echo $item->phone; ?>" target="_blank"
                                       class="text-success">
                                        <i class="fa fa-whatsapp"></i> WhatsApp ile görüş
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cari Bilgileri Kartı -->
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-3 text-muted"><i class="fa fa-location-arrow"></i>&nbsp; Cari
                            Bilgileri</h6>
                        <p class="mb-1">Şirket Adı: <?php echo $item->company_name; ?></p>
                        <p class="mb-1">Vergi No: <?php echo $item->tax_no; ?></p>
                        <p class="mb-1">Vergi Dairesi: <?php echo tax_office_name($item->tax_office); ?>
                            / <?php echo city_name($item->tax_city); ?></p>
                        <p class="mb-1">IBAN: <?php echo $item->IBAN; ?></p>
                        <p class="mb-0">Banka: <?php echo $item->bank; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php if ($Subcontractor) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Taşeronluk Sözleşmeleri</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Proje Adı</th>
                                    <th scope="col">Sözleşme Adı</th>
                                    <th scope="col">Hakediş Toplamı</th>
                                    <th scope="col">Ödeme Toplamı</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($Subcontractor as $Subcontract): ?>
                                    <?php
                                    $project = $this->Project_model->get(array("id" => $Subcontract->project_id));
                                    $collection = $this->Collection_model->sum_all(array("contract_id" => $Subcontract->id), "tahsilat_miktar");
                                    $payment = $this->Payment_model->sum_all(array("contract_id" => $Subcontract->id), "E");
                                    if ($project):
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url("project/file_form/$project->id"); ?>"
                                                   class="text-decoration-none text-primary">
                                                    <?= $Subcontract->id; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("project/file_form/$project->id"); ?>"
                                                   class="text-decoration-none text-primary">
                                                    <?= $project->project_name; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("contract/file_form/$Subcontract->id"); ?>"
                                                   class="text-decoration-none text-secondary">
                                                    <?= $Subcontract->contract_name; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("contract/file_form/$Subcontract->id"); ?>"
                                                   class="text-decoration-none text-secondary">
                                                    <?= money_format($payment)." ".$Subcontract->para_birimi; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("contract/file_form/$Subcontract->id"); ?>"
                                                   class="text-decoration-none text-secondary">
                                                    <?= money_format($collection)." ".$Subcontract->para_birimi; ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>


    <?php if ($Clients) { ?>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>İşveren Sözleşmeleri</h4>
                    <span>Bu İşverene ait tüm sözleşmeler</span>
                </div>
                <div class="card-block row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Proje Adı</th>
                                    <th scope="col">Sözleşme Adı</th>
                                    <th scope="col">Hakediş Toplamı</th>
                                    <th scope="col">Ödeme Toplamı</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($Clients as $Client): ?>
                                    <?php
                                    $project = $this->Project_model->get(array("id" => $Client->project_id));
                                    $collection = $this->Collection_model->sum_all(array("contract_id" => $Client->id), "tahsilat_miktar");
                                    $payment = $this->Payment_model->sum_all(array("contract_id" => $Client->id), "E");
                                    if ($project):
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url("project/file_form/$project->id"); ?>"
                                                   class="text-decoration-none text-primary">
                                                    <?= $Client->id; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("project/file_form/$project->id"); ?>"
                                                   class="text-decoration-none text-primary">
                                                    <?= $project->project_name; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("contract/file_form/$Client->id"); ?>"
                                                   class="text-decoration-none text-secondary">
                                                    <?= $Client->contract_name; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("contract/file_form/$Client->id"); ?>"
                                                   class="text-decoration-none text-secondary">
                                                    <?= money_format($payment)." ".$Client->para_birimi; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url("contract/file_form/$Client->id"); ?>"
                                                   class="text-decoration-none text-secondary">
                                                    <?= money_format($collection)." ".$Client->para_birimi; ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>
</div>
