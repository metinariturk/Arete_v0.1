<div class="refresh_group" id="refresh_group" name="refresh_group">
    <div class="container">
        <!-- Ana Grup Ekleme Alanı -->
        <form id="update_sub" action="<?php echo base_url("$this->Module_Name/update_sub_group/$item->id"); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" name="groups[new_main][code]" class="form-control form-control-sm" placeholder="Ana Grup Kodu">
                </div>
                <div class="col-md-6">
                    <input type="text" name="groups[new_main][name]" class="form-control form-control-sm" placeholder="Ana Grup Adı">
                </div>
                <div class="col-md-3">
                    <button type="button" form-id="update_sub" id="save_button" onclick="update_group(this)" class="btn btn-success btn-sm">
                        <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                    </button>
                </div>
            </div>

            <hr>

            <!-- Ana Gruplar -->
            <div class="accordion" id="accordionExample">
                <?php foreach ($main_groups as $main_group) { ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo $main_group->id; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $main_group->id; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $main_group->id; ?>">
                                <?php echo $main_group->code; ?> - <?php echo $main_group->name; ?>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo $main_group->id; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $main_group->id; ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <!-- Ana Grup Düzenleme -->
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][id]" value="<?php echo $main_group->id; ?>">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][code]" class="form-control form-control-sm" value="<?php echo $main_group->code; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][name]" class="form-control form-control-sm" value="<?php echo $main_group->name; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_group(this, 'main')" id="<?php echo $main_group->id; ?>">
                                            <i class="fa fa-trash-alt"></i> Sil
                                        </button>
                                    </div>
                                </div>

                                <!-- Alt Gruplar -->
                                <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                                <?php foreach ($sub_groups as $sub_group) { ?>
                                    <div class="row mb-2 ms-4">
                                        <div class="col-md-3">
                                            <input hidden type="text" name="groups[<?php echo $sub_group->id; ?>][id]" value="<?php echo $sub_group->id; ?>">
                                            <input type="text" name="groups[<?php echo $sub_group->id; ?>][code]" class="form-control form-control-sm" value="<?php echo $sub_group->code; ?>">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="groups[<?php echo $sub_group->id; ?>][name]" class="form-control form-control-sm" value="<?php echo $sub_group->name; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="delete_group(this, 'sub')" id="<?php echo $sub_group->id; ?>">
                                                <i class="fa fa-trash-alt"></i> Sil
                                            </button>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Yeni Alt Grup Ekleme -->
                                <div class="row ms-4">
                                    <div class="col-md-3">
                                        <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][main_id]" value="<?php echo $main_group->id; ?>">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][code]" class="form-control form-control-sm" placeholder="Kodu">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][name]" class="form-control form-control-sm" placeholder="Grup Adı">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" form-id="update_sub" id="save_button" onclick="update_group(this)" class="btn btn-success btn-sm">
                                            <i class="fa fa-plus-circle fa-lg"></i> Ekle
                                        </button>
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
