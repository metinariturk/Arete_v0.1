<div id="leader_list" name="leader_list" class="leader_list">
    <form class="row g-1 " method="post" id="add_leader"
          action="<?php echo base_url("contract/add_leader/$item->id"); ?>">
        <div class="col-md-2 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block">Kodu</div>
            <input id="select2-demo-1" style="width: 100%;" type="text" placeholder="Kodu"
                   class="form-control <?php cms_isset(form_error("leader_code"), "is-invalid", ""); ?>"
                   data-plugin="select2" name="leader_code">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("leader_code"); ?></div>
            <?php } ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block">Poz Adı</div>
            <input id="select2-demo-1" style="width: 100%;" type="text" placeholder="Poz Adı"
                   class="form-control <?php cms_isset(form_error("leader_name"), "is-invalid", ""); ?>"
                   data-plugin="select2" name="leader_name">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("leader_name"); ?></div>
            <?php } ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block">Birimi</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("leader_unit"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="leader_unit">
                <option value="">Birimi Seçin</option>
                <?php foreach ((get_as_array($settings->units)) as $unit) { ?>
                    <option value="<?php echo $unit; ?>">
                        <?php echo $unit; ?>
                    </option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("leader_unit"); ?></div>
            <?php } ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block">Fiyat</div>
            <input id="select2-demo-1" style="width: 100%;" type="number" placeholder="Fiyat"
                   class="form-control <?php cms_isset(form_error("leader_price"), "is-invalid", ""); ?>"
                   data-plugin="select2" name="leader_price">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("leader_price"); ?></div>
            <?php } ?>
        </div>
        <hr>
        <div class="col-12" style="width: 100%">
            <a class="btn btn-primary btn-block" onclick="save_leader('add_leader')" type="button" style="width: 100%">
                <i class="fa fa-plus fa-2x"></i> Poz Ekle
            </a>
        </div>
    </form>
    <div class="row">
        <div class="col-12">
            <div class="container">
                <h1 class="mt-5">Excel Dosyasını Yükleyin</h1>
                <form action="<?php echo base_url("Contract/upload_book_excel/$item->id"); ?>" method="post"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="excelFile">Excel Dosyasını Seçin:</label>
                        <input type="file" class="form-control-file" id="excelFile" name="excel_file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Yükle</button>
                </form>
            </div>
            <h5>Poz Listesi</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>Sıra</th>
                    <th>Kodu</th>
                    <th>Poz Adı</th>
                    <th>Birimi</th>
                    <th>Fiyat</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($leaders as $leader) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $leader->code; ?></td>
                        <td><?php echo $leader->name; ?> </td>
                        <td><?php echo $leader->unit; ?></td>
                        <td><?php echo $leader->price; ?></td>
                        <td>
                            <a onclick="delete_leader(this)" id="<?php echo $leader->id; ?>">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                            <a onclick="update_leader_form(this)" id="<?php echo $leader->id; ?>">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                <?php }; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Düzenleme Modalı -->
<div class="modal fade" id="editLeaderModal" tabindex="-1" role="dialog" aria-labelledby="editLeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeaderModalLabel">Pozu Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_leader_form" method="post" action="<?php echo base_url('contract/update_leader'); ?>">
                    <input type="hidden" id="edit_leader_id" name="leader_id">
                    <div class="form-group">
                        <label for="edit_leader_code">Kodu</label>
                        <input type="text" class="form-control" id="edit_leader_code" name="leader_code" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_leader_name">Poz Adı</label>
                        <input type="text" class="form-control" id="edit_leader_name" name="leader_name">
                    </div>
                    <div class="form-group">
                        <label for="edit_leader_unit">Birimi</label>
                        <select style="width: 100%;" id="edit_leader_unit" name="leader_unit"
                                class="form-control <?php cms_isset(form_error("leader_unit"), "is-invalid", ""); ?>"
                                data-plugin="select2" >
                            <option value="">Birimi Seçin</option>
                            <?php foreach ((get_as_array($settings->units)) as $unit) { ?>
                                <option value="<?php echo $unit; ?>">
                                    <?php echo $unit; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_leader_price">Fiyat</label>
                        <input type="number" class="form-control" id="edit_leader_price" name="leader_price">
                    </div>
                    <button type="button" onclick="update_leader()" class="btn btn-primary">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>