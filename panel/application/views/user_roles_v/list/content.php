<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Başlık</th>
                        <th>Durumu</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($items as $item) { ?>
                        <tr>
                            <td class="text-center"><?php echo $item->id; ?></td>
                            <td class=""><?php echo $item->title; ?></td>
                            <td>
                                <div class="media-body text-start icon-state switch-outline">
                                    <label class="switch">
                                        <input class="isActive"
                                               type="checkbox"
                                               name="notice"
                                               onclick="isActive(this)"
                                               data-url="<?php echo base_url("User_roles/isActiveSetter/$item->id"); ?>"
                                            <?php echo ($item->isActive) ? "checked" : ""; ?>>
                                        <span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <button
                                        data-url="<?php echo base_url("user_roles/delete/$item->id"); ?>"
                                        class="btn btn-sm btn-danger btn-outline remove-btn">
                                    <i class="fa fa-trash"></i> Sil
                                </button>
                                <a href="<?php echo base_url("user_roles/update_form/$item->id"); ?>" class="btn btn-sm btn-info btn-outline"><i class="fa fa-pencil-square-o"></i> Düzenle</a>
                                <a href="<?php echo base_url("user_roles/permissions_form/$item->id"); ?>" class="btn btn-sm btn-dark btn-outline"><i class="fa fa-eye"></i> Yetki Tanımı</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>









