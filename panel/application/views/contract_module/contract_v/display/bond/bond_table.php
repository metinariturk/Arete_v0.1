<?php $path_bond = base_url("uploads/$project->project_code/$item->dosya_no/Bond/"); ?>

<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="bondTable" style="width:100%">
                    <thead>
                    <tr>
                        <th><i class="fa fa-reorder"></i></th>
                        <th>Teminat Teslim Tarihi</th>
                        <th>Teminat Türü</th>
                        <th>Banka</th>
                        <th>Tutarı</th>
                        <th>Geçerlilik Tarihi</th>
                        <th>Açıklama</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($bonds)) { ?>
                        <?php foreach ($bonds as $bond) { ?>
                            <tr>
                                <td> </td>
                                <td>
                                    <?php echo $bond->teslim_tarih; ?>
                                </td>
                                <td>
                                    <p><?php echo $bond->teminat_turu; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $bond->teminat_banka; ?></p>
                                </td>
                                <td>
                                    <p><?php echo money_format($bond->teminat_miktar) . " " . get_currency($item->id); ?></p>
                                </td>
                                <td>
                                    <p><?php echo dateFormat_dmy($bond->gecerlilik_tarih); ?></p>
                                </td>
                                <td>
                                    <p><?php echo $bond->aciklama; ?></p>
                                </td>
                                <td>
                                    <a data-bs-toggle="modal" class="text-primary" id="open_edit_bond_modal_<?php echo $bond->id;?>"
                                       onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_bond_modal/$bond->id"); ?>','edit_bond_modal','EditBondModal')">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete('<?php echo base_url("Contract/delete_bond/$bond->id"); ?>', '#bond_table','bondTable')"
                                       title="Sil">
                                        <i class="fa fa-trash-o fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>