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
            <input id="select2-demo-1" style="width: 100%;" type="text" placeholder="Birimi"
                   class="form-control <?php cms_isset(form_error("leader_unit"), "is-invalid", ""); ?>"
                   data-plugin="select2" name="leader_unit">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("leader_unit"); ?></div>
            <?php } ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12 position-relative mb-2">
            <div class="col-form-label d-none d-md-block">Fiyat</div>
            <input id="select2-demo-1" style="width: 100%;" type="text" placeholder="Fiyat"
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
                            <a onclick="delete_price_item(this)" id="<?php echo $leader->id; ?>">
                                <i style="color: tomato" class="fa fa-minus-circle fa-2x"
                                   aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php }; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>