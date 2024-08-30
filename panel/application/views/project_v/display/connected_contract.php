<div>
    <button class="btn btn-outline-none border-0" type="button"
            data-bs-toggle="modal"
            data-bs-target="#exampleModalgetbootstrap"
            data-whatever="@getbootstrap">
        <i class="fas fa-edit fa-2x"></i>
    </button>
    <div class="modal fade" id="exampleModalgetbootstrap"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalgetbootstrap"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">
                        Düzenle</h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation"
                              novalidate=""
                              action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>"
                              method="post"
                              enctype="multipart/form-data">
                            <div class="mb-3">
                                <div class="col-form-label">
                                    Proje Kodu
                                    : <?php echo $item->project_code; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control <?php echo cms_isset(form_error("project_name"), "is-invalid", ""); ?>"
                                       placeholder="Proje Adı"
                                       aria-describedby="inputGroupPrepend"
                                       name="project_name"
                                       value="<?php echo isset($form_error) ? set_value("project_name") : $item->project_name; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("project_name"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <input type="text"
                                       class="form-control"
                                       name="notes"
                                       value="<?php echo $item->notes; ?>"
                                       placeholder="Genel Açıklama">
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary"
                                        type="submit">Güncelle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row content-container">
    <div class="table-responsive">
        <table class="display">
            <thead>
            <tr>
                <th>#</th>
                <th>Sözleşme Adı</th>
                <th>Sözleşme Bedel</th>
                <th>Hakediş Bedeli</th>
                <th>Fark Bedel</th>
            </thead>
            </tr>
            <tbody>
            <?php $total_main_payment_A = 0; ?>
            <?php $total_main_payment_B = 0; ?>
            <?php foreach ($contracts as $contract) { ?>
                <?php if ($contract->parent == 0 or $contract->parent = null) { ?>
                    <?php $payment_A = $this->Payment_model->sum_all(array("contract_id" => $contract->id), "A"); ?>
                    <?php $payment_B = $this->Payment_model->sum_all(array("contract_id" => $contract->id), "B"); ?>
                    <?php $contract_price = $contract->sozlesme_bedel; ?>
                    <tr>
                        <td>
                            <a href="<?php echo base_url("contract/new_form_sub/$contract->id"); ?>">
                                <i style="color: darkgreen" class="fa fa-plus-circle fa-lg"></i>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                                <?php echo $contract->contract_name; ?>
                            </a>
                        </td>
                        <td style="text-align: right">+ <?php echo money_format($contract->sozlesme_bedel); ?></td>
                        <td style="text-align: right">+ <?php echo money_format($payment_A); ?></td>
                        <td style="text-align: right">+ <?php echo money_format($payment_B); ?></td>
                    </tr>
                    <?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $contract->id)); ?>
                    <?php $total_sub_payment_A = 0; ?>
                    <?php $total_sub_payment_B = 0; ?>

                    <?php foreach ($sub_contracts as $sub_contract) { ?>
                        <?php $payment_sub_A = $this->Payment_model->sum_all(array("contract_id" => $sub_contract->id), "A"); ?>
                        <?php $payment_sub_B = $this->Payment_model->sum_all(array("contract_id" => $sub_contract->id), "B"); ?>
                        <?php $sub_contract_price = $sub_contract->sozlesme_bedel; ?>
                        <?php $total_sub_payment_A += $payment_sub_A; ?>
                        <?php $total_sub_payment_B += $payment_sub_B; ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                    <i style="color: darkred" class="fa fa-arrow-circle-right fa-lg"></i>
                                </a>
                            </td>
                            <td><a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                    <?php echo $sub_contract->contract_name; ?>
                                </a></td>
                            <td style="text-align: right">
                                - <?php echo money_format($sub_contract->sozlesme_bedel); ?></td>
                            <td style="text-align: right">- <?php echo money_format($payment_sub_A); ?></td>
                            <td style="text-align: right">- <?php echo money_format($payment_sub_B); ?></td>
                        </tr>
                    <?php } ?>
                    <?php $total_main_payment_A += $payment_A; ?>
                    <?php $total_main_payment_B += $payment_B; ?>
                <?php } ?>

            <?php } ?>
            </tbody>

            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>TOPLAM</td>
                <td style="text-align: right"><?php echo money_format($total_main_payment_A - $total_sub_payment_A); ?></td>
                <td style="text-align: right"><?php echo money_format($total_main_payment_B - $total_sub_payment_B); ?></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

