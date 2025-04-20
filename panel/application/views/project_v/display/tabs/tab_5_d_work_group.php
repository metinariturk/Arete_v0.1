<div class="refresh_group" id="refresh_group" name="refresh_group">
    <div class="container">
        <!-- Ana Grup Ekleme Alanı ve Ana Gruplar Aynı Satırda -->
        <form id="update_sub" action="<?php echo base_url("Project/update_sub_group/$item->id"); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="row mb-3">
                <!-- Ana Grup Ekleme -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <strong>Yeni Ana Grup</strong>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <input type="text" name="groups[new_main][code]" class="form-control form-control-sm" placeholder="Ana Grup Kodu">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="groups[new_main][name]" class="form-control form-control-sm" placeholder="Ana Grup Adı">
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="javascript:void(0);" class="text-success" form-id="update_sub" id="save_button" onclick="update_group(this)">
                                        <i class="fa fa-plus-circle fa-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ana Gruplar -->
                <?php foreach ($main_groups as $main_group) { ?>
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <strong><?php echo $main_group->code; ?> - <?php echo $main_group->name; ?></strong>
                            </div>
                            <div class="card-body">
                                <!-- Ana Grup Düzenleme: Tek Satırda -->
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][id]" value="<?php echo $main_group->id; ?>">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][code]" class="form-control form-control-sm" value="<?php echo $main_group->code; ?>">
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][name]" class="form-control form-control-sm" value="<?php echo $main_group->name; ?>">
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="javascript:void(0);" class="text-danger" onclick="delete_group(this, 'main')" id="<?php echo $main_group->id; ?>">
                                            <i class="fa fa-trash-alt fa-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <!-- Alt Gruplar: Tek Satırda -->
                                <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                                <?php foreach ($sub_groups as $sub_group) { ?>
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <input hidden type="text" name="groups[<?php echo $sub_group->id; ?>][id]" value="<?php echo $sub_group->id; ?>">
                                            <input type="text" name="groups[<?php echo $sub_group->id; ?>][code]" class="form-control form-control-sm" value="<?php echo $sub_group->code; ?>">
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="groups[<?php echo $sub_group->id; ?>][name]" class="form-control form-control-sm" value="<?php echo $sub_group->name; ?>">
                                        </div>
                                        <div class="col-1 text-end">
                                            <a href="javascript:void(0);" class="text-danger" onclick="delete_group(this, 'sub')" id="<?php echo $sub_group->id; ?>">
                                                <i class="fa fa-trash-alt fa-lg"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Yeni Alt Grup Ekleme: Tek Satırda -->
                                <div class="row">
                                    <div class="col-3">
                                        <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][main_id]" value="<?php echo $main_group->id; ?>">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][code]" class="form-control form-control-sm" placeholder="Kodu">
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][name]" class="form-control form-control-sm" placeholder="Grup Adı">
                                    </div>
                                    <div class="col-1 d-flex align-items-center">
                                        <a href="javascript:void(0);" form-id="update_sub" id="save_button" onclick="update_group(this)" class="text-success">
                                            <i class="fa fa-plus-circle fa-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </form>
    </div>
</div>
