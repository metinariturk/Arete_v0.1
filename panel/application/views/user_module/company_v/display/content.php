<div class="card">
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">

                    <!-- Başlık Kartı -->
                    <div class="container my-4">
                        <div class="card border-0 shadow-lg rounded-3"
                             style="background: linear-gradient(135deg, #f1f3f5, #e9ecef);">
                            <div class="card-body p-4">
                                <p class="mb-2 text-muted fw-medium">
                                    <?php echo $item->company_role; ?>
                                </p>
                                <h2 class="card-title fw-bold mb-2 text-dark">
                                    <?php echo full_name($item->id); ?>
                                </h2>
                                <p class="mb-2 text-secondary fs-5">
                                    <?php echo $item->profession; ?>
                                </p>
                                <p class="mb-0 fw-semibold text-primary fs-5">
                                    <?php echo $item->company_name; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- İletişim ve Cari Bilgileri Kartları -->
                    <div class="row mb-3">

                        <!-- İletişim Bilgileri Kartı -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted">
                                        <i class="fa fa-address-card"></i>&nbsp; İletişim Bilgileri
                                    </h6>

                                    <!-- Adres -->
                                    <p class="mb-2">
                                        <strong><i class="fa fa-map-marker-alt text-secondary"></i> Adres:</strong><br>
                                        <?php echo $item->adress; ?><br>
                                        <?php echo city_name($item->adress_city); ?> /
                                        <?php echo district_name($item->adress_district); ?>
                                    </p>

                                    <!-- E-posta -->
                                    <p class="mb-2">
                                        <strong><i class="fa fa-envelope text-secondary"></i> E-posta:</strong><br>
                                        <a href="mailto:<?php echo $item->email; ?>">
                                            <?php echo $item->email; ?>
                                        </a>
                                    </p>

                                    <!-- Telefon -->
                                    <p class="mb-0">
                                        <strong><i class="fa fa-phone text-secondary"></i> Telefon:</strong><br>
                                        <a href="tel:+90<?php echo $item->phone; ?>">
                                            <?php echo formatPhoneNumber($item->phone); ?>
                                        </a>
                                        <?php if (!empty($item->phone)) { ?>
                                            <br>
                                            <a href="https://wa.me/+90<?php echo $item->phone; ?>" target="_blank"
                                               class="text-success">
                                                <i class="fa fa-whatsapp"></i> WhatsApp ile görüş
                                            </a>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Cari Bilgileri Kartı -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted">
                                        <i class="fa fa-briefcase"></i>&nbsp; Cari Bilgileri
                                    </h6>
                                    <p class="mb-1"><strong>Şirket Adı:</strong> <?php echo $item->company_name; ?></p>
                                    <p class="mb-1"><strong>Vergi No:</strong> <?php echo $item->tax_no; ?></p>
                                    <p class="mb-1"><strong>Vergi Dairesi:</strong>
                                        <?php echo tax_office_name($item->tax_office); ?> /
                                        <?php echo city_name($item->tax_city); ?>
                                    </p>
                                    <p class="mb-1"><strong>IBAN:</strong> <?php echo $item->IBAN; ?></p>
                                    <p class="mb-0"><strong>Banka:</strong> <?php echo $item->bank; ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                <?php if ($Subcontractor) { ?>
                    <?php
                    $total_payment = 0;
                    $total_collection = 0;
                    ?>
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
                                                <th scope="col">Sözleşme</th>
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

                                                // Toplamlara ekleme
                                                $total_payment += $payment;
                                                $total_collection += $collection;

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
                                                            <a href="<?= base_url("contract/file_form/$Subcontract->id"); ?>"
                                                               class="text-decoration-none text-primary">
                                                                <?= project_name($project->id) . " - " . $Subcontract->contract_name; ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url("contract/file_form/$Subcontract->id"); ?>"
                                                               class="text-decoration-none text-secondary">
                                                                <?= money_format($payment) . " " . $Subcontract->para_birimi; ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url("contract/file_form/$Subcontract->id"); ?>"
                                                               class="text-decoration-none text-secondary">
                                                                <?= money_format($collection) . " " . $Subcontract->para_birimi; ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td><strong><?= money_format($total_payment) ?></strong></td>
                                                <td><strong><?= money_format($total_collection) ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td><strong>KALAN</strong></td>
                                                <td><strong><?= money_format($total_payment - $total_collection) ?></strong></td>
                                            </tr>
                                            </tfoot>
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
                                                                <?= money_format($payment) . " " . $Client->para_birimi; ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url("contract/file_form/$Client->id"); ?>"
                                                               class="text-decoration-none text-secondary">
                                                                <?= money_format($collection) . " " . $Client->para_birimi; ?>
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

    </div>
</div>
