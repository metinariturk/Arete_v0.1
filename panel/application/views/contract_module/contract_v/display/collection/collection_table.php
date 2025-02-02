<?php $path_collection = base_url("uploads/$project->project_code/$item->dosya_no/Collection/"); ?>

<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="collectionTable" style="width:100%">
                    <thead>
                    <tr>
                        <th><i class="fa fa-reorder"></i></th>
                        <th>Ödeme Tarihi</th>
                        <th>Ödeme Türü</th>
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
                    <?php if (!empty($collections)) { ?>
                        <?php foreach ($collections as $collection) { ?>
                            <tr>
                                <td> <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $collection->tahsilat_tarih; ?>
                                </td>
                                <td>
                                    <p><?php echo $collection->tahsilat_turu; ?></p>
                                </td>
                                <td>
                                    <p><?php echo money_format($collection->tahsilat_miktar) . " " . get_currency($item->id); ?></p>
                                </td>
                                <td>
                                    <p><?php echo dateFormat_dmy($collection->vade_tarih); ?></p>
                                </td>
                                <td>
                                    <p><?php echo $collection->aciklama; ?></p>
                                </td>

                                <td>
                                    <a href="<?php echo base_url("Export/print_collection_bill/$collection->id"); ?>"
                                       title="Makbuz">
                                        <i class="fa fa-file fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a data-bs-toggle="modal" class="text-primary" id="open_edit_collection_modal_<?php echo $collection->id;?>"
                                       onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_collection_modal/$collection->id"); ?>','edit_collection_modal','EditCollectionModal')">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete('<?php echo base_url("Contract/delete_collection/$collection->id"); ?>', '#collection_table','collectionTable')"
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
