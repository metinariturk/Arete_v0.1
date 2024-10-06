<?php if (isset($form_error) && $form_error): ?>
    <script>
        $('.modal-backdrop').remove(); // Eski backdrop varsa kaldır
        $('body').removeClass('modal-open');
        $('body').css('overflow', 'auto');
        $('#<?php echo $error_modal; ?>').modal('show');

        // DataTable kontrolü ve yeniden başlatılması
        if ($.fn.DataTable.isDataTable('#depositsTable')) {
            $('#depositsTable').DataTable().destroy(); // Mevcut tabloyu yok et
        }

        // DataTable'ı yeniden başlat
        if (!$.fn.DataTable.isDataTable('#depositsTable')) {
            $('#depositsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                // Diğer DataTable ayarları
            });
        }
    </script>
<?php endif; ?>

<?php $path_sitewallet = base_url("uploads/$project->project_code/$item->dosya_no/Sitewallet/"); ?>

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
            <div class="table-responsive">
                <table id="depositsTable" style="width:100%">
                    <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Açıklama</th>
                        <th>Miktar</th>
                        <th>Ödeme Türü</th>
                        <th>İndir</th>
                        <th>Sil</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($all_deposits as $deposit) { ?>
                        <tr>
                            <td><?php echo dateFormat_dmy($deposit->date); ?></td>
                            <td><?php echo $deposit->note; ?></td>
                            <td><?php echo money_format($deposit->price); ?><?php echo $contract->para_birimi; ?></td>
                            <td><?php echo $deposit->payment_type; ?></td>
                            <td>
                                <?php
                                // Dosya varlığını kontrol et
                                $file_isset = glob("$path_sitewallet.*") !== [];

                                // Eğer dosya varsa
                                if ($file_isset) { ?>
                                    <a href="<?php echo base_url("$this->Module_Name/expense_download/$expense->id"); ?>">
                                        <i class="fa fa-download f-14 ellips"></i>
                                    </a>
                                <?php } else { ?>
                                    <!-- Dosya mevcut değilse alternatif bir ikon gösterebilirsin -->
                                    <i class="fa fa-download f-14 ellips" style="color: grey;"
                                       title="Dosya mevcut değil"></i>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="javascript:void(0);"
                                   onclick="confirmDelete('<?php echo base_url("Site/delete_sitewallet/$deposit->id"); ?>', '#tab_depostis','depositsTable')"
                                   title="Sil">
                                    <i class="fa fa-trash-o fa-2x"></i>
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


<div class="modal fade" id="AddDepositModal" tabindex="-1" role="dialog" aria-labelledby="AddDepositModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Avans</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addDepositForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/add_deposit/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <!-- Tarih -->
                    <div class="mb-3">
                        <label for="deposit_date" class="form-label">Geliş Tarihi</label>
                        <input type="date" name="deposit_date" id="deposit_date"
                               value="<?php echo date(set_value('deposit_date')); ?>"
                               class="form-control <?php cms_isset(form_error("deposit_date"), "is-invalid", ""); ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('deposit_date'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Tutar -->
                    <div class="mb-3">
                        <label class="col-form-label" for="price">Tutar:</label>
                        <input id="price" type="number" min="0" step="any"
                               class="form-control <?php cms_isset(form_error("price"), "is-invalid", ""); ?>"
                               name="price"
                               placeholder="Tutar">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('price'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Ödeme Türü -->
                    <div class="mb-3">
                        <label class="col-form-label" for="payment_type">Ödeme Türü:</label>
                        <select id="select2-demo-1" style="width: 100%;"
                                class="form-control <?php cms_isset(form_error("payment_type"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="payment_type">
                            <?php if (isset($form_error)) { ?>
                                <option selected
                                        value="<?php echo set_value('payment_type'); ?>"><?php echo(set_value('payment_type')); ?></option>
                            <?php } else { ?>
                                <option value="" disabled selected>Tür Seçiniz</option>
                            <?php } ?>
                            <!-- Dynamic site options -->
                            <option>Nakit</option>
                            <option>Havale</option>
                            <option>Kredi Kartı</option>
                            <option>Diğer</option>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('payment_type'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Açıklama -->
                    <div class="mb-3">
                        <label class="col-form-label" for="payment_notes">Açıklama:</label>
                        <input id="payment_notes" type="text"
                               class="form-control <?php cms_isset(form_error("payment_notes"), "is-invalid", ""); ?>"
                               name="payment_notes" value="<?php echo set_value('payment_notes'); ?>"
                               placeholder="Açıklama">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error('payment_notes'); ?></div>
                        <?php } ?>
                    </div>

                    <!-- Dosya Yükle -->
                    <div class="mb-3">
                        <label class="col-form-label" for="file-input">Dosya Yükle:</label>
                        <input class="form-control" name="file" id="file-input" type="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addDepositForm', 'AddDepositModal', 'tab_deposits', 'depositsTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
