<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>
                    <?php echo "Firama Listesi"; ?>
                </h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">

                    <li>
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
                                        <?php $this->load->view("user_module/company_v/common/new_form"); ?>
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
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Şirket Adı</th>
                        <th>Faaliyet Konusu</th>
                        <th>İletişim</th>
                        <th>Rolü</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($companys as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->company_name; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->profession; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->email; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->company_role; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>