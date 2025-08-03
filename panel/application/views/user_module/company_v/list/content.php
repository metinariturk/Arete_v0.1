
<div class="card">
    <div class="card-header">
        <h2>Firma Yönetimi</h2>

        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                data-bs-target=".bd-example-modal-lg" data-bs-original-title="" title="">+ Yeni Firma
        </button>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Yeni Firma</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view("user_module/company_v/list/new_form"); ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button class="btn btn-primary" form="new_company" type="submit">Kaydet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="display company-table">
            <thead>
            <tr>
                <th>No</th>
                <th>Firma Adı</th>
                <th>Faaliyet Alanı</th>
                <th>Kategori</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($companys as $company) { ?>
                <tr>
                    <td class="w5c"><?php echo $i++; ?></td>
                    <td><a href="<?= base_url("company/file_form/$company->id"); ?>"><?= $company->company_name; ?></a></td>
                    <td><a href="<?= base_url("company/file_form/$company->id"); ?>"><?= $company->profession; ?></a></td>
                    <td><a href="<?= base_url("company/file_form/$company->id"); ?>"><?= $company->company_role; ?></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
