    <div class="row">
        <div class="col-md-6">
            <div class="widget p-lg">
                <div class="table-responsive">
                    <a class="pager-btn btn btn-purple btn-outline"
                       href="<?php echo base_url("workman/new_form/$item->id"); ?>">
                        <i class="fas fa-plus-circle"></i>
                        Yeni Personel
                    </a>
                    <hr>
                    <table id="default-datatable" data-plugin="DataTable"
                           class="table table-striped content-container tablecenter">
                        <thead>
                        <th>id</th>
                        <th>Personel Adı</th>
                        <th>Ekip</th>
                        <th>Çalışma Süresi</th>
                        <th>Durumu</th>
                        <th>İşlem</th>
                        </thead>
                        <tbody>
                        <?php $all_workgroups = get_from_any_array("workgroup", "sub_category", "1"); ?>
                        <?php foreach ($all_workgroups as $all_workgroup) { ?>
                            <?php foreach ($workers as $worker) { ?>
                                <?php if ($all_workgroup->id == $worker->group) { ?>
                                    <tr>
                                        <td>
                                            <?php echo "$worker->id"; ?>
                                        </td>
                                        <td>
                                            <?php echo $worker->name . " " . $worker->surname; ?>
                                        </td>
                                        <td>
                                            <?php echo group_name($worker->group); ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo calistigi_gun($worker->start_date);
                                            ?>
                                        </td>
                                        <td>
                                            <input
                                                    data-url="<?php echo base_url("Workman/isActiveSetter/$worker->id"); ?>"
                                                    class="isActive"
                                                    type="checkbox"
                                                    data-switchery
                                                    data-color="#10c469"
                                                <?php echo ($worker->isActive) ? "checked" : ""; ?>
                                            />
                                        </td>
                                        <td class="w10c">
                                            <a class="btn btn-info pager-btn" href="<?php echo base_url("workman/file_form/$worker->id"); ?>" <span=""><i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            <span>Görüntüle</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="widget p-lg">
                <div class="table-responsive">
                    <table id="default-datatable" data-plugin="DataTable"
                           class="table table-striped tablecenter content-container">
                        <thead>
                        <th>id</th>
                        <th>Personel Adı</th>
                        <th>Ekip</th>
                        <th>Çalışma Süresi</th>
                        <th>Durumu</th>
                        <th>İşlem</th>
                        </thead>
                        <tbody>
                        <?php $all_workgroups = get_from_any_array("workgroup", "sub_category", "1"); ?>
                        <?php foreach ($all_workgroups as $all_workgroup) { ?>
                            <?php foreach ($passiveworkers as $worker) { ?>
                                <?php if ($all_workgroup->id == $worker->group) { ?>
                                    <tr>
                                        <td>
                                            <?php echo "$worker->id"; ?>
                                        </td>
                                        <td>
                                            <?php echo $worker->name . " " . $worker->surname; ?>
                                        </td>
                                        <td>
                                            <?php echo group_name($worker->group); ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo calistigi_gun($worker->start_date);
                                            ?>
                                        </td>
                                        <td>
                                            <input
                                                    data-url="<?php echo base_url("Workman/isActiveSetter/$worker->id"); ?>"
                                                    class="isActive"
                                                    type="checkbox"
                                                    data-switchery
                                                    data-color="#10c469"
                                                <?php echo ($worker->isActive) ? "checked" : ""; ?>
                                            />
                                        </td>
                                        <td class="w10c">
                                            <a class="btn btn-info pager-btn" href="<?php echo base_url("workman/file_form/$worker->id"); ?>" <span=""><i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            <span>Görüntüle</span>
                                            </a>
                                        </td>

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>







