<div class="widget p-lg">
    <?php if (empty($items)) { ?>
        <div class="alert alert-info text-center">
            <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen
                <a href="<?php echo base_url("$this->Module_Name/new_form"); ?>"> Buradan
                    Yeni <?php echo $this->Module_Title; ?> Ekleyiniz</a>
            </p>
        </div>
    <?php } else { ?>
    <div class="table-responsive">
        <a class="pager-btn btn btn-purple btn-outline"
           href="<?php echo base_url("$this->Module_Name/new_form/"); ?>">
            <i class="fas fa-plus-circle"></i>
            Yeni Araç
        </a>
        <hr>
        <table id="default-datatable" data-plugin="DataTable" class="table table-striped content-container">
            <thead>
            <th class="w5">#id</th>
            <th class="w5">#</th>
            <th class="w15">Plaka</th>
            <th class="w15">Türü</th>
            <th class="w5">Bulunduğu İş Yeri</th>
            <th class="w10">Mülkiyet</th>
            <th class="w10">Aktif</th>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td class="w5c">
                        <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">#<?php echo $item->id; ?></a>
                    </td>

                    <td class="w5">
                        <div>
                            <?php $avatars = (directory_map("$this->File_Dir_Prefix/$item->id/avatar"));
                            if (!empty($avatars)) { ?>
                                <div class="avatar avatar-xs avatar-circle">
                                    <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                        <img  width="500" height="600"
                                             src="<?php echo base_url("$this->File_Dir_Prefix/$item->id/avatar/$avatars[0]"); ?>"
                                             alt="avatar"/>

                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="avatar avatar-xs avatar-circle">
                                    <a href="<?php echo base_url("$this->Module_Name/update_form/$item->id"); ?>">
                                        <i class="fa-solid fa-user fa-2x"></i>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                    </td>
                    <td class="w15">
                        <?php echo $item->plaka; ?> -
                        <?php echo $item->model; ?> -
                        <?php echo $item->marka; ?> -
                        <?php echo $item->ticari_ad; ?>
                    </td>
                    <td class="w5c"><?php echo $item->cins; ?></a></td>
                    <td class="w5c"><?php echo $item->model; ?></td>
                    <td class="w5c"><?php cms_if_echo($item->kiralik, "1", "Kiralık", "Sahibi"); ?></td>
                    <td class="w5c">
                        <input
                                data-url="<?php echo base_url("vehicle/isActiveSetter/$item->id"); ?>"
                                class="isActive"
                                type="checkbox"
                                data-switchery
                                data-color="#10c469"
                            <?php echo ($item->isActive) ? "checked" : ""; ?>
                        />
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>

