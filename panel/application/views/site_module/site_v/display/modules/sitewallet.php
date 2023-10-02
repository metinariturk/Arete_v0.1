<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-lg-6 col-xl-4 box-col-6">
            <div class="card custom-card p-0">
                <div class="text-center m-3"><h5>Kasa Durum</h5></div>

                <div class="card-footer row">
                    <div class="col-6 col-sm-6">
                        <h6>Harcama</h6>
                        <h5><span class="counter">
                                <?php $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1");
                                echo money_format($total_expense); ?>
                            </span>TL</h5>
                    </div>
                    <div class="col-6 col-sm-6">
                        <h6>Avans</h6>
                        <h5><span class="counter">
                                <?php $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0");
                                echo money_format($total_deposit); ?>
                            </span>TL</h5>
                    </div>
                </div>
                <hr>
                <div class="text-center profile-details">
                    <h5 class="counter"><?php echo money_format($total_deposit - $total_expense); ?>TL</h5>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4 box-col-6">
            <div class="card custom-card p-0">
                <div class="card-header text-center">
                    <h5>Harcamalar
                        <div class="card-body btn-showcase">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalmdo" data-whatever="@fat">
                                <i class="fas fa-plus"></i> Harcama Ekle
                            </button>
                            <div class="modal fade" id="exampleModalmdo" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Yeni Harcama</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="contract_id"
                                                  action="<?php echo base_url("$this->Module_Name/sitewallet/$item->id/1"); ?>"
                                                  method="post" enctype="multipart/form-data" autocomplete="off">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Tarih:</label>
                                                    <input class="datepicker-here form-control digits"
                                                           type="text"
                                                           name="expense_date"
                                                           value="<?php echo date('d-m-Y'); ?>"
                                                           data-options="{ format: 'DD-MM-YYYY' }"
                                                           data-language="tr">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Belge No:</label>
                                                    <input type="text" class="form-control"
                                                           name="bill_code" placeholder="Belge No">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Tutar:</label>
                                                    <input type="number" min="0" step="any" class="form-control"
                                                           name="price" placeholder="Tutar">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Ödeme
                                                        Türü:</label>
                                                    <select name="payment_type" class="form-control">
                                                        <option>Nakit</option>
                                                        <option>Havale</option>
                                                        <option>Kredi Kartı</option>
                                                        <option>Diğer</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="message-text">Açıklama:</label>
                                                    <input type="text" class="form-control"
                                                           name="payment_notes" placeholder="Açıklama">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file-input">Dosya Yükle:</label>
                                                    <input class="form-control" name="file" id="file-input" type="file">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                                Kapat
                                            </button>
                                            <button class="btn btn-primary" form="contract_id" type="submit">Kaydet
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h5>
                </div>
                <div class="card-profile">
                </div>
                <div class="text-center profile-details">
                    <h5 class="counter"><?php echo money_format(sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "1")); ?>
                        TL</h5>
                </div>

                <div class="card-footer row">
                    <div class="col-12 col-sm-12">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4 box-col-6">
            <div class="card custom-card p-0">
                <div class="card-header text-center">
                    <h5>Avanslar
                        <div class="card-body btn-showcase">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModaldeposit" data-whatever="@fat">
                                <i class="fas fa-plus"></i> Avans Ekle
                            </button>
                            <div class="modal fade" id="exampleModaldeposit" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Yeni Avans</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="deposit"
                                                  action="<?php echo base_url("$this->Module_Name/sitewallet/$item->id/0"); ?>"
                                                  method="post" enctype="multipart/form-data" autocomplete="off">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Tarih:</label>
                                                    <input class="datepicker-here form-control digits"
                                                           type="text"
                                                           name="expense_date"
                                                           value="<?php echo date('d-m-Y'); ?>"
                                                           data-options="{ format: 'DD-MM-YYYY' }"
                                                           data-language="tr">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Belge No:</label>
                                                    <input type="text" class="form-control"
                                                           name="bill_code" placeholder="Belge No">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Tutar:</label>
                                                    <input type="number" min="0" step="any" class="form-control"
                                                           name="price" placeholder="Tutar">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="recipient-name">Ödeme
                                                        Türü:</label>
                                                    <select name="payment_type" class="form-control">
                                                        <option>Nakit</option>
                                                        <option>Havale</option>
                                                        <option>Kredi Kartı</option>
                                                        <option>Diğer</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="message-text">Açıklama:</label>
                                                    <input type="text" class="form-control"
                                                           name="payment_notes" placeholder="Açıklama">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file-input">Dosya Yükle:</label>
                                                    <input class="form-control" name="file" id="file-input" type="file">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                                Kapat
                                            </button>
                                            <button class="btn btn-primary" form="deposit" type="submit">Kaydet
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h5>
                </div>
                <div class="card-profile">
                </div>
                <div class="text-center profile-details">
                    <h5 class="counter"><?php echo money_format(sum_anything_and("sitewallet", "price", "site_id", "$item->id", "type", "0")); ?>
                        TL</h5>
                </div>
                <div class="card-footer row">
                    <div class="col-12 col-sm-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-6">
        <div class="expense_list_container">
            <div class="table-responsive">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/expense_table"); ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-6">
        <div class="deposit_list_container">
            <div class="table-responsive">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/deposit_table"); ?>
            </div>
        </div>
    </div>
</div>
