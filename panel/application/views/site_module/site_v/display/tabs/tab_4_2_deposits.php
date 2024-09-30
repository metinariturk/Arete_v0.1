<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <h2></h2>
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <h5>Avans Listesi</h5>
                </div>
            </div>
            <hr>
            <table id="advancesTable" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tarih</th>
                    <th>Açıklama</th>
                    <th>Miktar</th>
                    <th>Ödeme Türü</th>
                    <th>İndir</th>
                    <th>Sil</th>
                </tr>
                <tr>
                    <th colspan="2">Alınan Avanslar Toplamı</th>
                    <th><?php echo money_format($total_deposit); ?><?php echo $contract->para_birimi; ?></th>
                    <th colspan="4"></th>
                </tr>
                </thead>
                <tbody>
                <?php $j = 1; ?>
                <?php foreach ($all_deposites as $deposit) { ?>
                    <tr>
                        <td><?php echo $j++; ?></td>
                        <td><?php echo dateFormat_dmy($deposit->date); ?></td>
                        <td><?php echo money_format($deposit->price); ?><?php echo $contract->para_birimi; ?></td>
                        <td><?php echo $deposit->payment_type; ?></td>
                        <td><?php echo $deposit->note; ?></td>
                        <td>
                            <a href="<?php echo base_url("$this->Module_Name/expense_download/$deposit->id"); ?>">
                                <i class="fa fa-download f-14 ellips"></i>
                            </a>
                        </td>
                        <td>
                            <a onclick="deleteDepositeFile(this)"
                               url="<?php echo base_url("site/expense_delete/$deposit->id"); ?>"
                            <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                               aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <!-- Daha fazla avans satırı ekleyebilirsiniz -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="DepositModal" tabindex="-1" role="dialog"
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
                      method="post" enctype="multipart/form-data"
                      autocomplete="off">
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="recipient-name">Tarih:</label>
                        <input class="datepicker-here form-control digits"
                               type="text"
                               name="date"
                               value="<?php echo date('d-m-Y'); ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="recipient-name">Belge
                            No:</label>
                        <input type="text" class="form-control"
                               name="bill_code" placeholder="Belge No">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label"
                               for="recipient-name">Tutar:</label>
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
                        <label class="col-form-label"
                               for="message-text">Açıklama:</label>
                        <input type="text" class="form-control"
                               name="payment_notes" placeholder="Açıklama">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="file-input">Dosya
                            Yükle:</label>
                        <input class="form-control" name="file" id="file-input"
                               type="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">
                    Kapat
                </button>
                <button class="btn btn-primary" form="deposit" type="submit">Kaydet
                </button>
            </div>
        </div>
    </div>
</div>