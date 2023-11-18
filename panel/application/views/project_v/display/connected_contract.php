<div class="row content-container">
    <table class="table table-bordered table-striped table-hover pictures_list">
        <thead>
        <th style="text-align: center">#</th>
        <th>Sözleşme Adı</th>
        <th style="text-align: center">Sözleşme Bedel</th>
        <th style="text-align: center">Toplam Hakediş</th>
        <th class="w20c">Gerçekleşme Oran</th>
        <th class="w20c">Alt Sözleşme Ekle</th>
        </thead>
        <tbody>
        <?php foreach ($contracts as $contract) { ?>
            <?php if ($contract->parent == 0 or $contract->parent = null) { ?>
                <tr>
                    <td style="text-align: center">
                        <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                            <i style="color: green" class="fa fa-arrow-circle-up fa-lg"></i>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>">
                            <?php echo $contract->sozlesme_ad; ?>
                        </a>
                    </td>
                    <td style="text-align: right">+ <?php echo money_format($contract->sozlesme_bedel); ?></td>
                    <td style="text-align: right"></td>
                    <td style="text-align: right"></td>
                    <td style="text-align: center">
                        <a href="<?php echo base_url("contract/new_form_sub/$contract->id"); ?>"><i
                                    style="color: darkgreen" class="fa fa-plus-circle fa-lg"></i></a>
                    </td>
                </tr>
                <?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $contract->id)); ?>
                <?php foreach ($sub_contracts as $sub_contract) { ?>
                    <tr>
                        <td style="text-align: center">
                            <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                            <i style="color: darkred" class="fa fa-arrow-circle-right fa-lg"></i>
                        </a>
                        </td>
                        <td><a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                            <?php echo $sub_contract->sozlesme_ad; ?>
                        </a></td>
                        <td style="text-align: right">- <?php echo money_format($sub_contract->sozlesme_bedel); ?></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>

