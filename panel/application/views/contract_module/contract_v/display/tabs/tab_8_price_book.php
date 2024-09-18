<div id="leader_list" name="leader_list" class="leader_list">
    <form class="row g-1" method="post" id="add_leader" action="<?php echo base_url("contract/add_leader/$item->id"); ?>">
        <div class="col-md-2 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block"><p>Kodu</p></div>
            <input id="select2-demo-1" style="width: 100%;" type="text" placeholder="Kodu"
                   class="form-control <?php cms_isset(form_error("leader_code"), "is-invalid", ""); ?>"
                   data-plugin="select2" name="leader_code">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><p><?php echo form_error("leader_code"); ?></p></div>
            <?php } ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block"><p>Poz Adı</p></div>
            <input id="select2-demo-1" style="width: 100%;" type="text" placeholder="Poz Adı"
                   class="form-control <?php cms_isset(form_error("leader_name"), "is-invalid", ""); ?>"
                   data-plugin="select2" name="leader_name">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><p><?php echo form_error("leader_name"); ?></p></div>
            <?php } ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block"><p>Birimi</p></div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("leader_unit"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="leader_unit">
                <option value=""><p>Birimi Seçin</p></option>
                <?php foreach ((get_as_array($settings->units)) as $unit) { ?>
                    <option value="<?php echo $unit; ?>">
                        <p><?php echo $unit; ?></p>
                    </option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><p><?php echo form_error("leader_unit"); ?></p></div>
            <?php } ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block"><p>Fiyat</p></div>
            <input id="select2-demo-1" style="width: 100%;" type="number" placeholder="Fiyat"
                   class="form-control <?php cms_isset(form_error("leader_price"), "is-invalid", ""); ?>"
                   data-plugin="select2" name="leader_price">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><p><?php echo form_error("leader_price"); ?></p></div>
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
            <hr>
            <div class="container">
                <h1 class="mt-5"><p class="f-16">Poz Kitabını Excel Dosyasından Yükleyin</p></h1>
                <form action="<?php echo base_url("Contract/upload_book_excel/$item->id"); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group d-flex align-items-center">
                        <label for="excelFile" class="mr-2"><p>Excel Dosyasını Seçin:</p></label>
                        <input type="file" class="form-control-file" id="excelFile" name="excel_file" required>
                        <button type="submit" class="btn btn-primary ml-2">Yükle</button>
                    </div>
                </form>
            </div>
            <hr>
            <h5><p>Poz Listesi</p></h5>
            <table class="table-xs table-border-horizontal">
                <thead>
                <tr>
                    <th><p>Sıra</p></th>
                    <th><p>Kodu</p></th>
                    <th><p>Poz Adı</p></th>
                    <th><p>Birimi</p></th>
                    <th><p>Fiyat</p></th>
                    <th colspan="2"><p>İşlem</p></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($leaders as $leader) { ?>
                    <tr>
                        <td><p><?php echo $i++; ?></p></td>
                        <td><p><?php echo $leader->code; ?></p></td>
                        <td><p><?php echo $leader->name; ?></p></td>
                        <td><p><?php echo $leader->unit; ?></p></td>
                        <td><p><?php echo $leader->price; ?></p></td>
                        <td>
                            <a onclick="delete_leader(this)" id="<?php echo $leader->id; ?>">
                                <i style="color: #808080" class="fa fa-trash fa-lg"></i>
                                <p>Sil</p>
                            </a>
                        </td>
                        <td>
                            <a onclick="update_leader_form(this)" id="<?php echo $leader->id; ?>">
                                <i style="color: #808080" class="fa fa-edit fa-lg"></i>
                                <p>Düzenle</p>
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
                <h5 class="modal-title" id="editLeaderModalLabel"><p>Pozu Düzenle</p></h5>
            </div>
            <div class="modal-body">
                <form id="edit_leader_form" method="post" action="<?php echo base_url('contract/update_leader'); ?>">
                    <input type="hidden" id="edit_leader_id" name="leader_id">
                    <div class="form-group">
                        <label for="edit_leader_code"><p>Kodu</p></label>
                        <input type="text" class="form-control" id="edit_leader_code" name="leader_code" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_leader_name"><p>Poz Adı</p></label>
                        <input type="text" class="form-control" id="edit_leader_name" name="leader_name">
                    </div>
                    <div class="form-group">
                        <label for="edit_leader_unit"><p>Birimi</p></label>
                        <select style="width: 100%;" id="edit_leader_unit" name="leader_unit"
                                class="form-control <?php cms_isset(form_error("leader_unit"), "is-invalid", ""); ?>"
                                data-plugin="select2">
                            <option value=""><p>Birimi Seçin</p></option>
                            <?php foreach ((get_as_array($settings->units)) as $unit) { ?>
                                <option value="<?php echo $unit; ?>">
                                    <p><?php echo $unit; ?></p>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_leader_price"><p>Fiyat</p></label>
                        <input type="number" class="form-control" id="edit_leader_price" name="leader_price">
                    </div>
                    <button type="button" onclick="update_leader()" class="btn btn-primary">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>
