<?php $path_advance = base_url("uploads/$project->dosya_no/$item->dosya_no/Advance/"); ?>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="advanceTable" style="width:100%">
                    <thead>
                    <tr>
                        <th><i class="fa fa-reorder"></i></th>
                        <th>Avans Tarihi</th>
                        <th>Avans Türü</th>
                        <th>Tutarı</th>
                        <th>Vade Tarih</th>
                        <th>Açıklama</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php if (!empty($advances)) { ?>
                        <?php foreach ($advances as $advance) { ?>
                            <tr>
                                <td> <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $advance->avans_tarih; ?>
                                </td>
                                <td>
                                    <p><?php echo $advance->avans_turu; ?></p>
                                </td>
                                <td>
                                    <p><?php echo money_format($advance->avans_miktar) . " " . get_currency($item->id); ?></p>
                                </td>
                                <td>
                                    <p><?php echo dateFormat_dmy($advance->vade_tarih); ?></p>
                                </td>
                                <td>
                                    <p><?php echo $advance->aciklama; ?></p>
                                </td>
                                <td>
                                    <a href="<?php echo base_url("Export/print_advance_bill/$advance->id"); ?>"
                                       title="Makbuz">
                                        <i class="fa fa-file fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a data-bs-toggle="modal" class="text-primary" id="open_edit_advance_modal_<?php echo $advance->id;?>"
                                       onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_advance_modal/$advance->id"); ?>','edit_advance_modal','EditAdvanceModal')">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete('<?php echo base_url("Contract/delete_advance/$advance->id"); ?>', '#advance_table','advanceTable')"
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