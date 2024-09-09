<div class="refresh_group" id="refresh_group" name="refresh_group">
    <div class="container">
        <!-- Ana Grup Ekleme Alanı -->
        <form id="update_sub"
              action="<?php echo base_url("$this->Module_Name/update_sub_group/$item->id"); ?>"
              method="post"
              enctype="multipart/form-data" autocomplete="off">
            <div class="row">
                <!-- Ana Grup Ekleme -->
                <div class="col-12 mb-1">
                    <div class="row">
                        <div class="col-md-3">

                            <input type="text" name="groups[new_main][code]" class="form-control form-control-sm"
                                   placeholder="Ana Grup Kodu">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="groups[new_main][name]" class="form-control form-control-sm"
                                   placeholder="Ana Grup Adı">
                        </div>
                        <div class="col-md-3">
                            <a form-id="update_sub" id="save_button" onclick="update_group(this)"
                               class="btn btn-success">
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Ana Gruplar -->
            <div class="row">
                <?php foreach ($main_groups as $main_group) { ?>
                    <div class="col-md-6 m-l-2">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][id]"
                                           class="form-control form-control-sm" value="<?php echo $main_group->id; ?>">
                                    <input type="text" name="groups[<?php echo $main_group->id; ?>][code]"
                                           class="form-control form-control-sm" value="<?php echo $main_group->code; ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="groups[<?php echo $main_group->id; ?>][name]"
                                           class="form-control form-control-sm" value="<?php echo $main_group->name; ?>">
                                </div>
                                <div class="col-md-3">
                                    <a onclick="delete_group(this, 'main')" id="<?php echo $main_group->id; ?>" class="ms-3">
                                        <i class="fa fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                        <?php foreach ($sub_groups as $sub_group) { ?>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                        <input hidden type="text" name="groups[<?php echo $sub_group->id; ?>][id]"
                                               class="form-control form-control-sm" value="<?php echo $sub_group->id; ?>">
                                        <input type="text" name="groups[<?php echo $sub_group->id; ?>][code]"
                                               class="form-control form-control-sm" value="<?php echo $sub_group->code; ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="groups[<?php echo $sub_group->id; ?>][name]"
                                               class="form-control form-control-sm" value="<?php echo $sub_group->name; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <a onclick="delete_group(this, 'sub')" id="<?php echo $sub_group->id; ?>" class="ms-3">
                                            <i class="fa fa-trash-alt" "></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <input hidden type="text"
                                           name="groups[<?php echo $main_group->id; ?>][new_sub][main_id]"
                                           class="form-control form-control-sm" value="<?php echo $main_group->id; ?>">
                                    <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][code]"
                                           class="form-control form-control-sm" placeholder="Kodu">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][name]"
                                           class="form-control form-control-sm" placeholder="Grup Adı">
                                </div>
                                <div class="col-md-3">
                                    <!-- Ekle Butonu -->
                                    <a form-id="update_sub" id="save_button" onclick="update_group(this)" class="ms-3">
                                        <i  class="fa fa-plus-circle fa-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                <?php } ?>
            </div>

        </form>

    </div>
</div>


