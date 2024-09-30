

<div class="modal fade" id="AddExpenseModal" tabindex="-1" role="dialog"
     aria-labelledby="AddExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Harcama</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="errorMessages"></div> <!-- Hata mesajları buraya gelecek -->

                <form id="addExpenseForm"
                      data-form-url="<?php echo base_url("$this->Module_Name/sitewallet/$item->id/1"); ?>" method="post" autocomplete="off">
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
                <div id="tab_4_1_expenses"></div> <!-- Hata mesajlarını göstermek için -->

                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">
                    Kapat
                </button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addExpenseForm', 'tab_4_1_expenses', 'AddExpenseModal')">Gönder
                </button>
            </div>
        </div>
    </div>
</div>

<div id="tab_3_sitestock">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tables/table_4_1_expenses"); ?>
</div>


