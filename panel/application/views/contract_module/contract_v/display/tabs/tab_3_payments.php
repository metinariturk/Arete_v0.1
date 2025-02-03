<?php if (isset($error_modal) && $error_modal == "AddPaymentModal") { ?>
    <script>

        if ($.fn.DataTable.isDataTable('#PaymentTable')) {
            $('#PaymentTable').DataTable().destroy();
        }

        $(document).ready(function() {
            $('#PaymentTable').DataTable({
                "pageLength": 25, // Her sayfada 25 öğe göster
                "order": [[0, 'desc']] // 0. sütun (ilk sütun) göre azalan sıralama
            });
        });

        // Modal açma işlemi ve z-index hatası düzeltme
        $('#openPaymentModal').click(); // Önce modalı aç

    </script>
<?php } ?>


<table class="table-lg" id="PaymentTable">
    <thead>
    <tr>
        <th Payment><p>Hakediş No</p></th>
        <th Payment><p>Hakediş İtibar Tarihi</p></th>
        <th><p>Hakediş Tutar</p></th>
        <th><p>Kesinti</p></th>
        <th Payment><p>Net Ödenecek</p></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($payments)) { ?>
        <?php foreach ($payments as $payment) { ?>
            <tr id="center_row">
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo str_pad($payment->hakedis_no, 2, "0", STR_PAD_LEFT); ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo dateFormat_dmy($payment->imalat_tarihi); ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->E); ?><?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->I); ?><?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->balance); ?><?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td><p>TOPLAM</p></td>
        <td></td>
        <td>
            <p><?php echo money_format(sum_anything("payment", "E", "contract_id", $item->id)); ?><?php echo "$item->para_birimi"; ?></p>
        </td>
        <td>
            <p><?php echo money_format(sum_anything("payment", "H", "contract_id", $item->id)); ?><?php echo "$item->para_birimi"; ?></p>
        </td>
        <td>
            <p><?php echo money_format(sum_anything("payment", "balance", "contract_id", $item->id)); ?><?php echo "$item->para_birimi"; ?></p>
        </td>
    </tr>
    </tfoot>
</table>

<div class="modal fade" id="AddPaymentModal" tabindex="-1" role="dialog" aria-labelledby="AddPaymentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Ödeme</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPaymentForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/create_payment/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="mb-2">
                        <div class="col-form-label">Hakediş No</div>
                        <input class="form-control" type="number" name="hakedis_no" readonly
                               value="<?php echo last_payment($item->id) + 1; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("hakedis_no"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-2">
                        <div class="col-form-label">Son İmalat
                            Tarihi
                        </div>
                        <input class="flatpickr form-control <?php cms_isset(form_error("imalat_tarihi"), "is-invalid", ""); ?>"
                               type="text" id="flatpickr" style="width: 100%"
                               name="imalat_tarihi"
                               value="<?php echo isset($form_error) ? set_value("imalat_tarihi") : ""; ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("imalat_tarihi"); ?></div>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addPaymentForm', 'AddPaymentModal', 'tab_Payment', 'PaymentTable')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
